<?php

namespace App\Http\Controllers;

use App\BusinessListing;
use App\Firm;
use App\User;
use Auth;
use DB;
use Illuminate\Http\Request;

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
        $data['activeMenu']        = 'manage_clients';

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

        /*   print_r($business_listings);
        die();*/

        foreach ($business_listings as $key => $business_listing) {

            $business_link = url("/investment-opportunities/fund/" . $business_listing->business_slug);
            if ($business_listing->type == "proposal") {
                $business_link = url("investment-opportunities/single-company/" . $business_listing->business_slug);
            }

            $name_html = "<b><a href='" . $business_link . "' target='_blank' > " . title_case($business_listing->business_title) . "</a></b><br/>" . get_ordinal_number($business_listing->round) . " Round<br/>(" . $business_listing->type . ")
                                                <br/>
                                                <i>" . $business_listing->bo_email."</i>";

            $analyst_feedback = 'Pending';
            if (isset($business_listing->analyst_feedback)) {
                if (!is_null($business_listing->analyst_feedback) && $business_listing->analyst_feedback !== '' && $business_listing->analyst_feedback != false) {
                    $analyst_feedback = 'Pending';
                }
            }
            $analyst_feedback_html ="<span class='text-warning'> (Analyst Feedback:".$analyst_feedback.")</span>";

            $biz_status_display = "<small>".implode(' ', array_map('ucfirst', explode('_', $business_listing->business_status)))."</small>";
            $actionHtml         = $biz_status_display .$analyst_feedback_html. '<br/><select data-id="" class="firm_actions" edit-url="#">
                                                <option>--select--</option>
                                                <option value="edit">View</option>
                                                </select>';
            $activity_site_wide_html = "&pound" . $business_listing->bi_invested . " <span class='text-info'>FA</span>";
            $activity_site_wide_html .= "<br/>&pound" . $business_listing->watch_list . " <span class='text-warning'>AW</span>";
            $activity_site_wide_html .= "<br/>&pound" . $business_listing->bi_pledged . " <span class='text-success'>PA</span>";

            $activity_firmwide_html = "&pound" . $business_listing->bi_invested_in_firm . " <span class='text-info'>FA</span>";
            $activity_firmwide_html .= "<br/>&pound" . $business_listing->my_watch_list . " <span class='text-warning'>AW</span>";
            $activity_firmwide_html .= "<br/>&pound" . $business_listing->bi_pledged_in_firm . " <span class='text-success'>PA</span>";

            $business_listings_data[] = [
                'logo'              => '',
                'name'              => $name_html,
                'duediligence'      => '', //$business_listing->approver,
                'created_date'      => date('d/m/Y', strtotime($business_listing->created_at)),
                'modified_date'     => date('d/m/Y', strtotime($business_listing->updated_at)),
                'firmtoraise'       => $business_listing->firm_name . '<br/>&pound' . $business_listing->target_amount . "<br/> <u>To Raise</u>",
                'activity_sitewide' => $activity_site_wide_html,
                'activity_firmwide' => $activity_firmwide_html,
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
            $firms      = new Firm;
            $firm_ids   = $firms->getAllChildFirmsByFirmID($filters['firm_name']);
            $firm_ids[] = $filters['firm_name'];

        } else {
            $user         = Auth::user();
            $user_firm_id = $user->firm_id;
            $firms        = new Firm;
            $firm_ids     = $firms->getAllChildFirmsByFirmID($user_firm_id);
            $firm_ids[]   = $user_firm_id;

        }

        $firm_investors     = User::whereIn('firm_id', $firm_ids)->pluck('id')->toArray();
        $firm_investors_str = implode(',', $firm_investors);
        //print_r($firm_investors_str);

        $wm_associated_firms_query_select_data = "SELECT firm.name as firm_name, bp.round as round, bp.target_amount as target_amount,bp.created_at as created_at, bp.updated_at as updated_at, bp.business_status as business_status, bp.type as type, bp.content AS content,bp.parent AS parent, bp.short_content AS short_content, bp.owner_id AS owner_id,

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

        $wm_associated_firms_query_select_count = " select count(*) ";
        $wm_associated_firms_query              = " FROM business_listings bp";

        $wm_associated_firms_query .= " JOIN users as bo_info on bo_info.id =   bp.owner_id  ";
        //$wm_associated_firms_query.=" JOIN users as bo_info on bo_info.id =   bp.owner_id AND bp.status = 'publish' ";
        /* $wm_associated_firms_query.=" JOIN users as bo_info on bo_info.id =   bp.owner_id
        JOIN {$wpdb->prefix}postmeta bpd ON bp.ID = bpd.post_id AND bp.post_type = 'business-proposal' AND bp.post_status = 'publish' AND bpd.meta_key = 'proposal_details'";*/

        /*$listed_query = "JOIN {$wpdb->prefix}postmeta bpds ON  bpds.post_id = bpd.post_id and bpds.meta_key = 'proposal_status'  ";
        if (!current_user_can('view_all_proposals')) {
        $listed_query = "JOIN {$wpdb->prefix}postmeta bpds ON  bpds.post_id = bpd.post_id and bpds.meta_key = 'proposal_status' and bpds.meta_value = 'listed'";
        }

        $listed_query.= "JOIN {$wpdb->prefix}postmeta m_propfund_type ON  m_propfund_type.post_id = bpd.post_id and m_propfund_type.meta_key = 'proposal-fund-type' and m_propfund_type.meta_value!='list_proposal'  ";*/
        $listed_query = "";
        $wm_associated_firms_query .= " LEFT OUTER JOIN firms firm on firm.id = bo_info.firm_id

         LEFT OUTER
                JOIN business_investments bpi ON bp.id = bpi.business_id

        LEFT OUTER
        JOIN business_investments my_bpi ON (my_bpi.id = bpi.id AND my_bpi.investor_id IN (" . $firm_investors_str . "))
        GROUP BY bp.id  ";

        $sql_limit = " ORDER BY business_title ASC LIMIT " . $skip . "," . $length;

        /* echo $wm_associated_firms_query_select_data.$wm_associated_firms_query.$sql_limit;
        die();*/
        $business_listings = DB::select($wm_associated_firms_query_select_data . $wm_associated_firms_query . $sql_limit);

        $sql_business_listings_count = "SELECT count(*) as count FROM business_listings biz  ";
        /* Get business listings count */
        if (isset($filters['firm_name']) && $filters['firm_name'] != "") {
            $sql_business_listings_count .= "
            LEFT JOIN users on biz.owner_id = users.id
            LEFT JOIN firms on users.firm_id = firms.id  AND users.firm_id = " . $filters['firm_name'];
        }

        $sql_business_listings_count_where = "";

        if (isset($filters['business_listings_type']) && $filters['business_listings_type'] != "") {
            $sql_business_listings_count .= "biz.type ='" . $filters['business_listings_type'] . "'";
        }

        $res_business_count = DB::select($sql_business_listings_count);
        $business_count     = $res_business_count[0]->count;

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

        foreach ($business_listings as $biz) {

            $firms = new Firm;
            if ($biz->firm_id != "") {
                $biz_firms       = $firms->getAllChildFirmsByFirmID($biz->firm_id);
                $biz_firms[]     = $biz->firm_id;
                $args['firm_id'] = $biz_firms;

            } else {
                $args['firm_id'] = $biz->firm_id;
            }

            $business_listings_update[] = $this->business_investment_details($biz->id, 0, $args, $biz);

        }

        return ['total_business_listings' => $business_count, 'list' => $business_listings_update];

    }

    public function business_investment_details($business_id, $investor_id = 0, $args = array(), $biz)
    {

        $data = array();

        $defaults = array(
            'firm_id' => '',
        );

        /*   $extract_arg = wp_parse_args($args, $defaults);
        extract($extract_arg, EXTR_SKIP);*/

        $firm_id = $args['firm_id'];

        //Added the level of int clause and status
        $query = " SELECT  bp_details.data_value as proposal_details ,SUM(CASE biz.status WHEN 'funded' THEN biz.amount ELSE 0 END) as invested,SUM(CASE  WHEN biz.status='pledged' and biz.details like '%ready-to-invest%' THEN biz.amount ELSE 0 END) as pledged
                            FROM business_investments as biz right outer JOIN business_listing_datas bp_details on bp_details.business_id = biz.business_id
                    WHERE bp_details.business_id = " . $business_id . " and bp_details.data_key = 'proposal_details'";

        /* $query = " SELECT  bp_details.meta_value as proposal_details ,SUM(CASE biz.status WHEN 'funded' THEN biz.amount_invested ELSE 0 END) as invested,SUM(CASE  WHEN biz.status='pledged' and biz.details like '%ready-to-invest%' THEN biz.amount_invested ELSE 0 END) as pledged
        FROM biz_proposals_investors as biz right outer JOIN {$wpdb->prefix}postmeta bp_details on bp_details.post_id = biz.biz_proposal_id
        WHERE bp_details.post_id = " . $business_id . " and data_key = 'proposal_details'";*/

        // echo "\n\n".$query;

        $results_query = DB::select($query);
        $results       = $results_query[0];

        $proposal_details = unserialize($results->proposal_details);

        $invested = $results->invested;

        $pledged = $results->pledged;

        $fund_raised = $invested + $pledged; //display fund raised as sum of pledged and invested

        $investment_sought  = (isset($proposal_details["investment-sought"])) ? $proposal_details["investment-sought"] : '';
        $minimum_investment = (isset($proposal_details["minimum-investment"])) ? $proposal_details["minimum-investment"] : 5000;

        $fund_raised_percentage = ($investment_sought != 0) ? ($fund_raised / $investment_sought) * 100 : 0; //display fund raised as sum of pledged and invested

        $funds_yet_to_raise = (double) $investment_sought - (double) $fund_raised;

        $data = array("bi_investment_sought" => check_null($investment_sought),
            "bi_minimum_investment"              => check_null($minimum_investment),
            "bi_invested"                        => check_null($invested),
            "bi_pledged"                         => check_null($pledged),
            "bi_fund_raised"                     => check_null($fund_raised),
            "bi_fund_raised_percentage"          => check_null($fund_raised_percentage),
            "bi_funds_yet_to_raise"              => check_null($funds_yet_to_raise));

        $biz->bi_investment_sought      = check_null($investment_sought);
        $biz->bi_minimum_investment     = check_null($minimum_investment);
        $biz->bi_invested               = check_null($invested);
        $biz->bi_pledged                = check_null($pledged);
        $biz->bi_fund_raised            = check_null($fund_raised);
        $biz->bi_fund_raised_percentage = check_null($fund_raised_percentage);
        $biz->bi_funds_yet_to_raise     = check_null($funds_yet_to_raise);

        if ($firm_id != '') {

            /* $qry_firm_values = "select SUM(CASE biz.status WHEN 'funded' THEN biz.amount_invested ELSE 0 END) as invested_in_firm,
            SUM(CASE WHEN biz.status ='pledged' and biz.details like '%ready-to-invest%' THEN biz.amount_invested ELSE 0 END) as pledged_in_firm
            from users investors JOIN biz_proposals_investors biz
            on biz.investor_id = user_id and biz.biz_proposal_id = " . $business_id . "
            where meta_key = 'firm' ";*/

            $qry_firm_values = "select SUM(CASE biz.status WHEN 'funded' THEN biz.amount ELSE 0 END) as invested_in_firm,
            SUM(CASE WHEN biz.status ='pledged' and biz.details like '%ready-to-invest%' THEN biz.amount ELSE 0 END) as pledged_in_firm
            from users investors JOIN business_investments biz
            on biz.investor_id = investors.id and biz.business_id = " . $business_id . "
              ";

            if (is_array($firm_id)) {

                if (count($firm_id) > 0) {
                    $firm_id_str = implode(',', $firm_id);
                }

                $qry_firm_values .= " where investors.firm_id in  (" . $firm_id_str . ")";
            } else {
                $qry_firm_values .= " where  investors.firm_id = " . $firm_id;
            }

            $res_firm_values_query = DB::select($qry_firm_values);
            $res_firm_values       = $res_firm_values_query[0];

            $data["bi_invested_in_firm"] = check_null($res_firm_values->invested_in_firm);
            $data["bi_pledged_in_firm"]  = check_null($res_firm_values->pledged_in_firm);

            $biz->bi_invested_in_firm = check_null($res_firm_values->invested_in_firm);
            $biz->bi_pledged_in_firm  = check_null($res_firm_values->pledged_in_firm);

        } else {
            $data["bi_invested_in_firm"] = 0;
            $data["bi_pledged_in_firm"]  = 0;

            $biz->bi_invested_in_firm = 0;
            $biz->bi_pledged_in_firm  = 0;
        }

        /* if (isset($latest_activity_date)) {

        if ($business_id != 0 && $business_id != '' && $latest_activity_date == true) {

        $qry_recent_proposal_pledge_fund = "(
        SELECT MAX( fp.invested_date ) AS last_funded_pledged,
        fp.status AS status
        FROM biz_proposals_investors fp
        WHERE fp.status =  'funded'
        AND fp.biz_proposal_id =" . $business_id . "
        )
        UNION (

        SELECT MAX( pp.modified_date ) AS last_funded_pledged,
        pp.status AS  status
        FROM biz_proposals_investors pp
        WHERE pp.status =  'pledged'
        AND pp.biz_proposal_id =" . $business_id . "
        )";

        $res_recent_proposal_pledge_fund = $wpdb->get_results($qry_recent_proposal_pledge_fund, ARRAY_A);

        $data["bi_last_invested_date"] = "";
        $data["bi_last_pledged_date"]  = "";

        if ($res_recent_proposal_pledge_fund != false && count($res_recent_proposal_pledge_fund) > 0) {

        foreach ($res_recent_proposal_pledge_fund as $key_plg_fnd => $value_plg_fnd) {

        if ($value_plg_fnd['status'] == "pledged") {
        $data["bi_last_pledged_date"] = isset($value_plg_fnd['last_funded_pledged']) ? $value_plg_fnd['last_funded_pledged'] : '';
        } elseif ($value_plg_fnd['status'] == "funded") {
        $data["bi_last_invested_date"] = isset($value_plg_fnd['last_funded_pledged']) ? $value_plg_fnd['last_funded_pledged'] : '';
        }

        }

        if ($data["bi_last_invested_date"] == '') {
        $data["bi_latest_activity_date"] = $data["bi_last_pledged_date"];
        } else if ($data["bi_last_pledged_date"] == '') {
        $data["bi_latest_activity_date"] = $data["bi_last_invested_date"];
        } else {
        if (strtotime($data["bi_last_invested_date"]) > strtotime($data["bi_last_pledged_date"])) {
        $data["bi_latest_activity_date"] = $data["bi_last_invested_date"];
        } else {
        $data["bi_latest_activity_date"] = $data["bi_last_pledged_date"];
        }

        }
        }
        }
        } */

        return $biz;

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
