<?php

namespace App\Http\Controllers;

use App\BusinessListing;
use App\Firm;
use App\User;
use Auth;
use Illuminate\Http\Request;

class CurrentBusinessValuation extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        /*$current_business_valuation = new BusinessValuation;

        $current_business_valuation_data = $current_business_valuation->getCurrentBusinessList($list_args);*/
        $current_business_valuation_data = "";

        $firmsList = getModelList('App\Firm', [], 0, 0, ['name' => 'asc']);
        $firms     = $firmsList['list'];

        $breadcrumbs   = [];
        $breadcrumbs[] = ['url' => url('/'), 'name' => "Manage"];
        $breadcrumbs[] = ['url' => '', 'name' => 'Manage Clients'];
        $breadcrumbs[] = ['url' => '', 'name' => 'Current Business Valuation'];

        $data['firms']                           = $firms;
        $data['current_business_valuation_list'] = $current_business_valuation_data;
        $data['breadcrumbs']                     = $breadcrumbs;
        $data['pageTitle']                       = 'Manage Clients : Growthinvest';
        $data['activeMenu']                      = 'manage_clients';

        return view('backoffice.clients.current_business_valuation')->with($data);

    }

    public function getCurrentValuationListings(Request $request)
    {
        $requestData = $request->all(); //dd($requestData);
        $data        = [];
        $skip        = $requestData['start'];
        $length      = $requestData['length'];
        $orderValue  = $requestData['order'][0];
        $filters     = []; //$requestData['filters'];

        $columnOrder = array(
            '1' => 'business_title',
            '2' => 'created_atusers.firm.name',
            '3' => '',
            '4' => '',
        );

        $columnName = 'business_listings.title';
        $orderBy    = 'asc';

        if (isset($columnOrder[$orderValue['column']])) {
            $columnName = $columnOrder[$orderValue['column']];
            $orderBy    = $orderValue['dir'];
        }

        $orderDataBy = [$columnName => $orderBy];

        $filter_business_listings = $this->getFilteredCurrentValuations($filters, $skip, $length, $orderDataBy);
        //dd($filter_business_listings);
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

            $name_html = "<b><a href='" . $business_link . "' target='_blank' > " . title_case($business_listing->business_title) . "</a></b><span class='text-muted'>" . get_ordinal_number($business_listing->round) . " Round</span>
                                                <br/>
                                                <span class='text-warning'>" . $this->getDisplayBusinessStatus($business_listing->business_status) . "<span>";



            
           
            $proposal_valuation = json_decode($business_listing->proposal_valuation);

            $shareprice= isset($proposal_valuation->shareprice)?$proposal_valuation->shareprice:'';
            $totalvaluation= isset($proposal_valuation->totalvaluation)?$proposal_valuation->totalvaluation:'';
            $actionHtml =   '<button type="button" class="btn btn-primary edit_valuation" data-toggle="modal"   proposal-id="65516" share-price="'.$shareprice.'" total-valuation="'.$totalvaluation.'" >Edit</button>';

            $business_listings_data[] = [
                'name'            => $name_html,
                'created_date'    => date('d/m/Y', strtotime($business_listing->created_at)),
                'total_valuation' => $totalvaluation,
                'share_price'     => $shareprice,
                'action'          => $actionHtml,

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

    public function getFilteredCurrentValuations($filters = array(), $skip = 1, $length = 50, $orderDataBy = array())
    {

        $logged_in_user = Auth::user();

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

        $business_listings_query = BusinessListing::where(['business_listings.status' => 'publish', 'round' => '1']);

        $cap_proposalstatus = [];
        if (!$logged_in_user->can('manage_options')) {

            if ($logged_in_user->can('view_listed_on_platform_proposals')) {
                // $cap_view_listed_on_platform_proposals = true ;
                $cap_proposalstatus[] = 'listed';
            }

            if ($logged_in_user->can('view_incomplete_proposals')) {
                /* $cap_view_incomplete_proposals = true ; */
                $cap_proposalstatus[] = 'awaiting_inputs';
            }

            if ($logged_in_user->can('view_needs_approval_proposals')) {
                /* $cap_view_needs_approval_proposals = true ; */
                $cap_proposalstatus[] = 'pending_review';
            }

            if (count($cap_proposalstatus) > 0) {
                $business_listings_query->whereIn('business_status', $cap_proposalstatus);
            }

        }

        /*  $business_listings_query = BusinessListing::where(['business_listings.status' => 'publish'])->leftJoin('business_has_defaults', function ($join) {
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
        //$entrepreneurQuery->select(\DB::raw("GROUP_CONCAT(business_listings.title ) as business, users.*"));*/

        $business_listings_query->select(\DB::raw("business_listings.title as business_title, business_listings.slug as business_slug,business_listings.id as business_id, business_listings.round as round, business_listings.business_status as business_status, business_listings.gi_code as gi_code, business_listings.created_at as created_at, business_listings.valuation as proposal_valuation"));
        foreach ($orderDataBy as $columnName => $orderBy) {
            $business_listings_query->orderBy($columnName, $orderBy);
        }
        // \DB::connection()->enableQueryLog();

        if ($length > 1) {

            $total_business_listings = $business_listings_query->get()->count();
            $business_listings       = $business_listings_query->skip($skip)->take($length)->get();
        } else {
            $business_listings       = $business_listings_query->get();
            $total_business_listings = $business_listings_query->count();
        }

        /*   echo "<pre>";
        print_r($business_listings);
        $queries = \DB::getQueryLog();
        dd($queries);

        die()*/;
        /* $business_listings_update = [];
        foreach ($business_listings as $biz) {

        $firms = new Firm;
        if ($biz->firm_id != "") {
        $biz_firms       = $firms->getAllChildFirmsByFirmID($biz->firm_id);
        $biz_firms[]     = $biz->firm_id;
        $args['firm_id'] = $biz_firms;

        } else {
        $args['firm_id'] = $biz->firm_id;
        }

        $new_biz_list = $this->business_investment_details($biz->id, 0, $args, $biz);

        $res_approver           = DB::select("SELECT def.name FROM `business_has_defaults` bhd LEFT JOIN `defaults` def ON bhd.default_id = def.id where bhd.business_id = " . $biz->id . " AND def.type='approver'");
        $new_biz_list->approver = '';
        if (count($res_approver) > 0) {
        $new_biz_list->approver = $res_approver[0]->name;
        }

        $business_listings_update[] = $new_biz_list;

        }*/

        return ['total_business_listings' => $total_business_listings, 'list' => $business_listings];

    }

    public function getDisplayBusinessStatus($business_status)
    {

        switch ($business_status) {
            case 'awaiting_inputs':
                $display_business_status = "Awaiting Business Owner Inputs";
                break;
            case 'early_stage':
                $display_business_status = "Marked as Incubator";
                break;
            case 'listed':
                $display_business_status = "Listed on Platform";
                break;
            case 'fund_raised':
                $display_business_status = "Fund Raised";
                break;
            case 'pending_review':
                $display_business_status = "Pending Review";
                break;
            case 'reject':
                $display_business_status = "Rejected";
                break;
            case 'archive':
                $display_business_status = "Archived";
                break;
            default:
                $display_business_status = "Pending Review";
                break;

        }
        return $display_business_status;

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
