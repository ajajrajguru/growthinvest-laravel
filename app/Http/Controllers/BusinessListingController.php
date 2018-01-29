<?php

namespace App\Http\Controllers;

use App\BusinessListing;
use App\Firm;
use Auth;
use Illuminate\Http\Request;
use App\User;
use DB;

class BusinessListingController extends Controller
{
    public $args = [];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* $firms = new Firm;
        $result = $firms->getAllChildFirmsByFirmID(28);
        echo"<pre>";
        print_r($result);
        die();*/

        $business_listing        = new BusinessListing;
        $list_args['backoffice'] = true;
        $business_listing_data   = $business_listing->getBusinessList($list_args);
/*echo "<pre>";
print_r($business_listing_data);
die();*/

        $firmsList = getModelList('App\Firm', [], 0, 0, ['name' => 'asc']);
        $firms     = $firmsList['list'];

        $breadcrumbs   = [];
        $breadcrumbs[] = ['url' => url('/'), 'name' => "Manage"];
        $breadcrumbs[] = ['url' => '', 'name' => 'Manage Clients'];
        $breadcrumbs[] = ['url' => '', 'name' => 'Manage Businesses'];

        $data['firms']             = $firms;
        $data['business_listings'] = $business_listing_data;
        $data['breadcrumbs']       = $breadcrumbs;
        $data['pageTitle']         = 'Manage Clients : Growthinvest';
        $data['activeMenu']          = 'manage_clients';

        return view('backoffice.clients.business_listings')->with($data);

    }

    public function getBusinessListings(Request $request)
    {
        $requestData = $request->all(); //dd($requestData);
        $data        = [];
        $skip        = $requestData['start'];
        $length      = $requestData['length'];
        $orderValue  = $requestData['order'][0];
        $filters     = $requestData['filters'];

        $columnOrder = array(
            '1' => 'business_listings.title',
            '2' => 'users.firm.name',
            '3' => 'users.business',
            '3' => 'users.created_at',
        );

        $columnName = 'business_listings.title';
        $orderBy    = 'asc';

        if (isset($columnOrder[$orderValue['column']])) {
            $columnName = $columnOrder[$orderValue['column']];
            $orderBy    = $orderValue['dir'];
        }

        $orderDataBy = [$columnName => $orderBy];

        $filter_business_listings = $this->getFilteredBusinessListings($filters, $skip, $length, $orderDataBy);
        $business_listings        = $filter_business_listings['list'];
        $total_business_listings  = $filter_business_listings['total_business_listings'];

        $business_listings_data = [];

        /*print_r($business_listings);
        die();*/

        foreach ($business_listings as $key => $business_listing) {

            $business_link = url("/investment-opportunities/fund/" . $business_listing->business_slug);
            if ($business_listing->type == "proposal") {
                $business_link = url("investment-opportunities/single-company/" . $business_listing->business_slug);
            }

            $name_html = "<b><a href='" . $business_link . "' target='_blank' > " . title_case($business_listing->business_title) . "</a></b><br/>" . get_ordinal_number($business_listing->round) . " Round<br/>(" . $business_listing->type . ")
                                                <br/>
                                                " .   $business_listing->bo_email ;
            $biz_status_display = implode(' ', array_map('ucfirst', explode('_', $business_listing->business_status)));
            $actionHtml         = $biz_status_display . '<br/><select data-id="" class="firm_actions" edit-url="#">
                                                <option>--select--</option>
                                                <option value="edit">View</option>
                                                </select>';

            $business_listings_data[] = [
                'logo'              => '',
                'name'              => $name_html,
                'duediligence'      => '',//$business_listing->approver,
                'created_date'      => date('d/m/Y', strtotime($business_listing->created_at)),
                'modified_date'     => date('d/m/Y', strtotime($business_listing->updated_at)),
                'firmtoraise'       =>  $business_listing->firm_name. '<br/>&pound' . $business_listing->target_amount,
                'activity_sitewide' => '',
                'activity_firmwide' => '',
                'action'            => $actionHtml,

            ];

        }

        $json_data = array(
            "draw"            => intval($requestData['draw']),
            "recordsTotal"    => intval($total_business_listings),
            "recordsFiltered" => intval($total_business_listings),
            "data"            => $business_listings_data,
        );

        return response()->json($json_data);

    }

    public function getFilteredBusinessListings($filters = array(), $skip = 1, $length = 50, $orderDataBy = array())
    {

        if (isset($filters['firm_name']) && $filters['firm_name'] != "") {
            $firms       = new Firm;
            $firm_ids    = $firms->getAllChildFirmsByFirmID($filters['firm_name']);
            $firm_ids[]  = $filters['firm_name'];
            
        } else {
            $user         = Auth::user();
            $user_firm_id = $user->firm_id;
            $firms        = new Firm;
            $firm_ids     = $firms->getAllChildFirmsByFirmID($user_firm_id);
            $firm_ids[]   = $user_firm_id;
             
        }

        $firm_investors = User::whereIn('firm_id',$firm_ids)->pluck('id')->toArray();
         $firm_investors_str =  implode(',',$firm_investors);
        //print_r($firm_investors_str);

        

        $wm_associated_firms_query_select_data="SELECT firm.name as firm_name, bp.round as round, bp.target_amount as target_amount,bp.created_at as created_at, bp.updated_at as updated_at, bp.business_status as business_status, bp.type as type, bp.content AS content,bp.parent AS parent, bp.short_content AS short_content, bp.owner_id AS owner_id,

        bp.id AS id,bo_info.id as bo ,bo_info.email as bo_email,  firm.name as firm_name, firm.id as firm_id,bp.title AS business_title,bp.slug AS business_slug, bp.created_at as business_date,bp.updated_at as business_modified,  bp.business_status as proposal_status ,bp.status as post_status,
        SUM(CASE bpi.status WHEN 'watch_list' THEN 1 ELSE 0 END) AS watch_list,
        SUM(CASE  WHEN bpi.status='pledged' and bpi.details like '%ready-to-invest%' THEN 1 ELSE 0 END) AS pledged,
        SUM(CASE bpi.status WHEN 'funded' THEN 1 ELSE 0 END) AS funded,
        SUM(CASE WHEN bpi.status='pledged' and bpi.details like '%ready-to-invest%' THEN bpi.amount ELSE 0 END) AS pledged_amount,
        SUM(CASE bpi.status WHEN 'funded' THEN bpi.amount ELSE 0 END) AS funded_amount,
        SUM(CASE my_bpi.status WHEN 'watch_list' THEN 1 ELSE 0 END) AS my_watch_list,
        SUM(CASE WHEN my_bpi.status='pledged' and my_bpi.details like '%ready-to-invest%' THEN 1 ELSE 0 END) AS my_pledged,
        SUM(CASE my_bpi.status WHEN 'funded' THEN 1 ELSE 0 END) AS my_funded,
        SUM(CASE WHEN my_bpi.status='pledged' and my_bpi.details like '%ready-to-invest%' THEN bpi.amount ELSE 0 END) AS my_pledged_amount,
        SUM(CASE my_bpi.status WHEN 'funded' THEN bpi.amount ELSE 0 END) AS my_funded_amount";

        $wm_associated_firms_query_select_count =" select count(*) ";
        $wm_associated_firms_query=" FROM business_listings bp";

        
         $wm_associated_firms_query.=" JOIN users as bo_info on bo_info.id =   bp.owner_id  ";
         //$wm_associated_firms_query.=" JOIN users as bo_info on bo_info.id =   bp.owner_id AND bp.status = 'publish' ";
       /* $wm_associated_firms_query.=" JOIN users as bo_info on bo_info.id =   bp.owner_id
        JOIN {$wpdb->prefix}postmeta bpd ON bp.ID = bpd.post_id AND bp.post_type = 'business-proposal' AND bp.post_status = 'publish' AND bpd.meta_key = 'proposal_details'";*/

        /*$listed_query = "JOIN {$wpdb->prefix}postmeta bpds ON  bpds.post_id = bpd.post_id and bpds.meta_key = 'proposal_status'  ";
        if (!current_user_can('view_all_proposals')) {
        $listed_query = "JOIN {$wpdb->prefix}postmeta bpds ON  bpds.post_id = bpd.post_id and bpds.meta_key = 'proposal_status' and bpds.meta_value = 'listed'";
        }

        $listed_query.= "JOIN {$wpdb->prefix}postmeta m_propfund_type ON  m_propfund_type.post_id = bpd.post_id and m_propfund_type.meta_key = 'proposal-fund-type' and m_propfund_type.meta_value!='list_proposal'  ";*/
        $listed_query="";
        $wm_associated_firms_query.=" LEFT OUTER JOIN firms firm on firm.id = bo_info.firm_id
      
         LEFT OUTER
                JOIN business_investments bpi ON bp.id = bpi.business_id

        LEFT OUTER
        JOIN business_investments my_bpi ON (my_bpi.id = bpi.id AND my_bpi.investor_id IN (" . $firm_investors_str . "))
        GROUP BY bp.id  ";

        $sql_limit =" ORDER BY business_title ASC LIMIT ".$skip.",".$length;

       /* echo $wm_associated_firms_query_select_data.$wm_associated_firms_query.$sql_limit;
        die();*/
        $business_listings = DB::select($wm_associated_firms_query_select_data.$wm_associated_firms_query.$sql_limit);

        

        
        $sql_business_listings_count ="SELECT count(*) as count FROM business_listings biz  ";
        /* Get business listings count */
        if (isset($filters['firm_name']) && $filters['firm_name'] != "") {
            $sql_business_listings_count.= "
            LEFT JOIN users on biz.owner_id = users.id 
            LEFT JOIN firms on users.firm_id = firms.id  AND users.firm_id = ".$filters['firm_name']; 
        }

        $sql_business_listings_count_where ="";

        if (isset($filters['business_listings_type']) && $filters['business_listings_type'] != "") {
            $sql_business_listings_count.="biz.type ='".$filters['business_listings_type']."'";
        }

        $res_business_count = DB::select($sql_business_listings_count);
        $business_count = $res_business_count[0]->count;

        
       

       /* echo $wm_associated_firms_query;
        die();*/

       /* $business_listings_query = BusinessListing::where(['business_listings.status' => 'publish'])->leftJoin('business_has_defaults', function ($join) {
            $join->on('business_listings.id', '=', 'business_has_defaults.business_id');
        })->leftJoin('defaults', function ($join) {
            $join->on('business_has_defaults.default_id', '=', 'defaults.id');
        });
        if (isset($filters['firm_name']) && $filters['firm_name'] != "") {
        $business_listings_query->where('business_listings.owner.firm.id', $filters['firm_name']);
        }
        
        if (isset($filters['firm_name']) && $filters['firm_name'] != "") {
            //$business_listings_query->where('business_listings.owner.firm.id', $filters['firm_name']);
            $this->args['firm_name'] = $filters['firm_name'];
            $business_listings_query->join('users', function ($join) {
                $join->on('business_listings.owner_id', '=', 'users.id')->where('users.firm_id', $this->args['firm_name']);
            });

        }

        if (isset($filters['business_listings_type']) && $filters['business_listings_type'] != "") {
            $business_listings_query->where('business_listings.type', $filters['business_listings_type']);
        }

        /////////////////// $entrepreneurQuery->groupBy('users.id')->select('users.*');
        $business_listings_query->groupBy('business_listings.id')->select('business_listings.*');
        //$entrepreneurQuery->select(\DB::raw("GROUP_CONCAT(business_listings.title ) as business, users.*"));

        */
 

        

        /*foreach ($orderDataBy as $columnName => $orderBy) {
            $business_listings_query->orderBy($columnName, $orderBy);
        }

        if ($length > 1) {

            $total_business_listings = $business_listings_query->get()->count();
            $business_listings       = $business_listings_query->skip($skip)->take($length)->get();
        } else {
            $business_listings       = $business_listings_query->get();
            $total_business_listings = $business_listings_query->count();
        }*/

        /* echo "<pre>";
        print_r($entrepreneurs);
        die();  */

        return ['total_business_listings' => $business_count, 'list' => $business_listings];

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
