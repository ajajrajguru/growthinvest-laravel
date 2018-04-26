<?php

namespace App\Http\Controllers;

use App\BusinessInvestment;
use App\BusinessListing;
use App\Commission;
use App\Firm;
use App\InvestorPdfHtml;
use App\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Spipu\Html2Pdf\Html2Pdf;
use View;

class BusinessListingController extends Controller
{
    public $args = [];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($biz_type = 'all')
    {

        /* $firms = new Firm;
        $result = $firms->getAllChildFirmsByFirmID(28);
        echo"<pre>";
        print_r($result);
        die();*/

        $business_listing             = new BusinessListing;
        $list_args['backoffice']      = true;
        $list_args['invest_listings'] = 'no';
        if ($biz_type == "invest-listings") {
            $list_args['invest_listings'] = 'yes';
        }

        $business_listing_data = $business_listing->getBusinessList($list_args);

        /*echo "<pre>";
        print_r($business_listing_data);*/

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
        $data['invest_listings']   = $list_args['invest_listings'];

        return view('backoffice.clients.business_listings')->with($data);

    }

    public function getBusinessListings(Request $request)
    {
        $requestData     = $request->all(); //dd($requestData);
        $data            = [];
        $skip            = $requestData['start'];
        $length          = $requestData['length'];
        $orderValue      = $requestData['order'][0];
        $filters         = $requestData['filters'];
        $invest_listings = isset($requestData['invest_listings']) ? $requestData['invest_listings'] : 'no';

        $biz_args['invest_listings'] = $invest_listings;
        $columnOrder                 = array(
            '1' => 'business_title',
            '2' => 'users.firm.name',
            '3' => 'created_at',
            '4' => 'updated_at',
        );

        $columnName = 'business_listings.title';
        $orderBy    = 'asc';

        if (isset($columnOrder[$orderValue['column']])) {
            $columnName = $columnOrder[$orderValue['column']];
            $orderBy    = $orderValue['dir'];
        }

        $orderDataBy = [$columnName => $orderBy];

        $filter_business_listings = $this->getFilteredBusinessListings($filters, $skip, $length, $orderDataBy, $biz_args);
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
                                                <i>" . $business_listing->bo_email . "</i>";

            $analyst_feedback = 'Pending';
            if (isset($business_listing->analyst_feedback)) {
                if (!is_null($business_listing->analyst_feedback) && $business_listing->analyst_feedback !== '' && $business_listing->analyst_feedback != false) {
                    $analyst_feedback = 'Pending';
                }
            }
            $analyst_feedback_html = "<span class='text-warning'> (Analyst Feedback:" . $analyst_feedback . ")</span>";

            //$biz_status_display = "<small>" . implode(' ', array_map('ucfirst', explode('_', $business_listing->business_status))) . "</small>";
            $biz_status_display = "<small>" . $this->getDisplayBusinessStatus($business_listing->business_status) . "</small>";

            $actionHtml = $biz_status_display . $analyst_feedback_html . '<br/><select data-id="" class="firm_actions" edit-url="#">
                                                <option>--select--</option>
                                                <option value="edit">View</option>
                                                </select>';
            $activity_site_wide_html = format_amount($business_listing->bi_invested, 0, true, true) . " <span class='text-info'>FA</span>";
            $activity_site_wide_html .= "<br/> " . $business_listing->watch_list . " <span class='text-warning'>AW</span>";
            $activity_site_wide_html .= "<br/>" . format_amount($business_listing->bi_pledged, 0, true, true) . " <span class='text-success'>PA</span>";

            $activity_firmwide_html = format_amount($business_listing->bi_invested_in_firm, 0, true, true) . " <span class='text-info'>FA</span>";
            $activity_firmwide_html .= "<br/> " . $business_listing->my_watch_list . " <span class='text-warning'>AW</span>";
            $activity_firmwide_html .= "<br/>" . format_amount($business_listing->bi_pledged_in_firm, 0, true, true) . " <span class='text-success'>PA</span>";

            $business_listings_data[] = [
                'logo'              => '',
                'name'              => $name_html,
                'duediligence'      => $business_listing->approver,
                'created_date'      => date('d/m/Y', strtotime($business_listing->created_at)),
                'modified_date'     => date('d/m/Y', strtotime($business_listing->updated_at)),
                'firmtoraise'       => $business_listing->firm_name . '<br/>' . format_amount($business_listing->target_amount, 0, true, true) . "<br/> <u>To Raise</u>",
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

    public function getFilteredBusinessListings($filters = array(), $skip = 1, $length = 50, $orderDataBy = array(), $biz_args)
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

        $wm_associated_firms_query_select_data = "SELECT bp.invest_listing as invest_listing, bp.gi_code as gi_code, firm.name as firm_name, bp.round as round, bp.target_amount as target_amount,bp.created_at as created_at, bp.updated_at as updated_at, bp.business_status as business_status, bp.type as type, bp.content AS content,bp.parent AS parent, bp.short_content AS short_content, bp.owner_id AS owner_id,

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
        JOIN business_investments my_bpi ON (my_bpi.id = bpi.id AND my_bpi.investor_id IN (" . $firm_investors_str . "))";

        $sql_business_listings_count       = "SELECT count(*) as count FROM business_listings biz  ";
        $sql_business_listings_count_where = "";

        $wm_associated_where               = "";
        $sql_business_listings_count_where = "";

        if (isset($filters['firm_name']) && $filters['firm_name'] != "") {

            $wm_associated_where .= " WHERE bo_info.firm_id ='" . $filters['firm_name'] . "'";

            $sql_business_listings_count .= "
            LEFT JOIN users on biz.owner_id = users.id
            JOIN firms on users.firm_id = firms.id  AND users.firm_id = " . $filters['firm_name'];
        }
        if (isset($filters['business_listings_type']) && $filters['business_listings_type'] != "") {

            $wm_associated_where .= ($wm_associated_where == "" ? " WHERE " : " AND ");
            $wm_associated_where .= "  bp.type ='" . $filters['business_listings_type'] . "'";

            $sql_business_listings_count_where .= " WHERE biz.type ='" . $filters['business_listings_type'] . "'";
        }

        if (isset($filters['invest_listings']) && $filters['invest_listings'] != "") {

            $wm_associated_where .= ($wm_associated_where == "" ? " WHERE " : " AND ");
            $wm_associated_where .= "  bp.invest_listing " . ($filters['invest_listings'] == "yes" ? " ='yes' " : " != 'yes' ");

            $sql_business_listings_count_where .= ($sql_business_listings_count_where == "" ? " WHERE " : " AND ");
            $sql_business_listings_count_where .= "  biz.invest_listing  " . ($filters['invest_listings'] == "yes" ? " ='yes' " : " != 'yes' ");
        }

        $sql_business_listings_count .= $sql_business_listings_count_where;

        $wm_associated_group_by = " GROUP BY bp.id ";

        $orderBy_sql = " ORDER BY business_title ASC ";

        $orderBy_sql = "";
        if (count($orderDataBy) > 0) {
            $cnt_orderby = 0;
            $orderBy_sql = " ORDER BY ";

            foreach ($orderDataBy as $columnName => $orderBy) {
                if ($cnt_orderby > 0) {
                    $orderBy_sql .= ", ";
                }
                $orderBy_sql .= $columnName . " " . $orderBy;
                $cnt_orderby++;
            }
        }

        if ($length > 1) {
            $sql_limit = $orderBy_sql . " LIMIT " . $skip . "," . $length;
        }

        /*   echo $wm_associated_firms_query_select_data . $wm_associated_firms_query . $wm_associated_where . $wm_associated_group_by . $sql_limit;
        die();*/
        $business_listings = DB::select($wm_associated_firms_query_select_data . $wm_associated_firms_query . $wm_associated_where . $wm_associated_group_by . $sql_limit);

        /* Get business listings count */
        if (isset($filters['firm_name']) && $filters['firm_name'] != "") {

        }

        if (isset($filters['business_listings_type']) && $filters['business_listings_type'] != "") {

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

        /*echo "<pre>";
        print_r($business_listings);
        die();  */
        $business_listings_update = [];
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

        }

        return ['total_business_listings' => $business_count, 'list' => $business_listings_update];

    }

    public function business_investment_details($business_id, $investor_id = 0, $args = array(), $biz)
    {

        $data = array();

        $defaults = array(
            'firm_id' => '',
        );

        $firm_id = isset($args['firm_id']) ? $args['firm_id'] : '';

        //Added the level of int clause and status
        $query = " SELECT  bp_details.data_value as proposal_details ,SUM(CASE biz.status WHEN 'funded' THEN biz.amount ELSE 0 END) as invested,SUM(CASE  WHEN biz.status='pledged' and biz.details like '%ready-to-invest%' THEN biz.amount ELSE 0 END) as pledged
                            FROM business_investments as biz right outer JOIN business_listing_datas bp_details on bp_details.business_id = biz.business_id
                    WHERE bp_details.business_id = " . $business_id . " and bp_details.data_key = 'proposal_details'";

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

        $biz->bi_investment_sought      = check_null($investment_sought);
        $biz->bi_minimum_investment     = check_null($minimum_investment);
        $biz->bi_invested               = check_null($invested);
        $biz->bi_pledged                = check_null($pledged);
        $biz->bi_fund_raised            = check_null($fund_raised);
        $biz->bi_fund_raised_percentage = check_null($fund_raised_percentage);
        $biz->bi_funds_yet_to_raise     = check_null($funds_yet_to_raise);

        if ($firm_id != '') {

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

        return $biz;

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

    public function exportBusinessListings(Request $request)
    {

        $data    = [];
        $filters = $request->all();

        $columnName = 'business_listings.title';
        $orderBy    = 'asc';

        $orderDataBy = [$columnName => $orderBy];

        $filter_business_listings = $this->getFilteredBusinessListings($filters, 0, 0, $orderDataBy);
        $business_listings        = $filter_business_listings['list'];

        $fileName = 'all_business_listings_as_on_' . date('d-m-Y');
        //  $header   = ['Platform GI Code', 'Entrepreneur Name', 'Email ID', 'Firm', 'Business Proposals', 'Registered Date', 'Source'];
        $header = ['Platform GI Code', 'Proposal/Fund Name', 'Due Diligence', 'Round', 'Type', 'Entrepreneur Email ID',
            'Firm Name', 'To Raise', 'Site Wide Funded Amount', 'Site Wide Added to Watchlist', 'Site Wide Pledged Amount',
            'Firm Wide Funded Amount', 'Firm Wide Added to Watchlist', 'Firm Wide Pledged Amount', 'Status'];
        $userData = [];

        foreach ($business_listings as $business_listing) {

            $round_ordinal      = get_ordinal_number($business_listing->round);
            $display_round      = ($round_ordinal != '') ? $round_ordinal . " Round" : "";
            $biz_status_display = $this->getDisplayBusinessStatus($business_listing->business_status);

            $userData[] = [$business_listing->gi_code,
                title_case($business_listing->business_title),
                $business_listing->approver,
                $display_round,
                $business_listing->type,
                $business_listing->bo_email,
                $business_listing->firm_name,
                $business_listing->target_amount,
                $business_listing->bi_invested,
                $business_listing->watch_list,
                $business_listing->bi_pledged,
                $business_listing->bi_invested_in_firm,
                $business_listing->my_watch_list,
                $business_listing->bi_pledged_in_firm,
                $biz_status_display,

            ];

        }

        generateCSV($header, $userData, $fileName);

        return true;

    }

    public function getBusinessDetails($slug = 'fonmoney')
    {

        $business_listing = BusinessListing::where('slug', $slug)->first();

        $data_keys = [
            'isEIS', 'hmrc_status', 'tradingname', 'markit_overview', 'management_team', 'company_details',
            'fundcharges_details', 'proposal_desc_details', 'fiancial_field', 'use_of_funds', 'exit_strategy',
            'proposal_details', 'busi_pro_selected_firms', 'fundvct_details', 'check_list_items', 'fund_productoverview',
            'fund_manageroverview', 'fund_minamountdesc', 'fund_closedate', 'fund_launchdate', 'fund_openclosed',
            'fund_investmentobjective', 'fund_targetreturn', 'fund_typeoffund', 'fund_managername', 'fund_nominee_custody',
            'fund_minmaxinvestment', 'fundcharges_details', 'investment_opportunities', 'company_transfer_asset'];

        $serialized_meta_keys = [
            'isEIS', 'hmrc_status', 'tradingname', 'markit_overview', 'management_team', 'company_details', 'fundcharges_details',
            'proposal_desc_details', 'fiancial_field', 'use_of_funds', 'proposal_details', 'busi_pro_selected_firms', 'fundvct_details'];

        $business_datas = $business_listing->businessListingData()->whereIn('data_key', $data_keys)->get()->toArray();

        foreach ($business_datas as $key => $business_data) {

            if (in_array($business_data['data_key'], $serialized_meta_keys)) {
                $business_data_ar[$business_data['data_key']] = @unserialize($business_data['data_value']);
                if (in_array($business_data['data_key'], ['proposal_desc_details', 'company_details', 'fundvct_details', 'fundcharges_details'])) {
                    $business_data_ar[$business_data['data_key']] = @unserialize($business_data_ar[$business_data['data_key']]);

                }
            } else {
                $business_data_ar[$business_data['data_key']] = $business_data['data_value'];
            }

        }

        //$biz_defaults = $business_listing->getBusinessDefaultsByBizId('',['type'=>'approver']);
        $biz_defaults       = $business_listing->getBusinessDefaultsByBizId();
        $approvers          = $business_listing->getApproversFromDefaultAr($biz_defaults);
        $milestones         = $business_listing->getMilestonesFromDefaultAr($biz_defaults);
        $stages_of_business = $business_listing->getStagesOfBusinessFromDefaultAr($biz_defaults);
        $business_sectors   = $business_listing->getBusinessSectorsFromDefaultAr($biz_defaults);

        $biz_investments = $this->business_investment_details($business_listing->id, 0, array(), $business_listing);

        $biz_investments_ar = $biz_investments->toArray();
        $business_ar        = $business_listing->toArray();

        $data         = array_merge($business_ar, $business_data_ar);
        $team_members = [];

        foreach ($data['management_team'] as $member_ar) {

            foreach ($member_ar as $member) {
                $team[$member['key']] = $member['value'];
            }
            $team_members[] = $team;

        }

        $round_parent            = ($business_listing->parent == 0) ? $business_listing->id : $business_listing->parent;
        $data['business_rounds'] = $business_listing->getAllNextProposalRounds($business_listing->id, $round_parent);

        $data['management_team']    = $team_members;
        $data['approvers']          = $approvers;
        $data['milestones']         = $milestones;
        $data['stages_of_business'] = $stages_of_business;
        $data['business_sectors']   = $business_sectors;

        /*echo "<pre>";
        print_r($data);
        die(); */

        return view('frontend.single-business-view', $data);

    }

    public function currentBusinessValuations()
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

    public function migratteVctData($type)
    {
        if ($type == 'fund-vct-data') {
            // updateVCTData();
        } elseif ($type == 'investors-certification') {
            // updateInvestorsCurrentCerification();
        }

    }

    public function investmentOpportunities(Request $request, $type)
    {

        if ($type == 'single-company') {
            $businessListingType = 'proposal';
        } elseif ($type == 'funds') {
            $businessListingType = 'fund';
        } elseif ($type == 'vct') {
            $businessListingType = 'vct';
        }

        $sectors         = getBusinessSectors();
        $dueDeligence    = getDueDeligence();
        $stageOfBusiness = getStageOfBusiness();

        $data['aicsector']             = aicsectors();
        $data['stageOfBusiness']       = $stageOfBusiness;
        $data['business_listing_type'] = $businessListingType;
        $data['sectors']               = $sectors;
        $data['dueDeligence']          = $dueDeligence;
        return view('frontend.investment-opportunities')->with($data);
    }

    public function getFilteredInvestmentOpportunity(Request $request)
    {

        $filters                = $request->all();
        $joinedBusinessDefaults = false;
        $joinedBusinessData     = false;
        $listingTaxStatus       = ['proposal' => ['eis', 'seis'], 'fund' => ['eis', 'seis'], 'vct' => ['vct']];
        $businessListingType    = $filters['business_listing_type'];
        $orderBy                = $filters['order_by'];

        // SUM(CASE business_investments.status WHEN "funded" THEN business_investments.amount ELSE 0 END) as invested,SUM(CASE  WHEN business_investments.status="pledged" and business_investments.details like "%ready-to-invest%" THEN business_investments.amount ELSE 0 END) as pledged,

        // SUM(business_investments.amount) as amount_raised, ((SUM(business_investments.amount) / business_listings.target_amount)*100) as percentage

        $businessListingQuery = BusinessListing::select(\DB::raw('business_listings.*, SUM(CASE business_investments.status WHEN "funded" THEN business_investments.amount ELSE 0 END) as invested,SUM(CASE  WHEN business_investments.status="pledged" and business_investments.details like "%ready-to-invest%" THEN business_investments.amount ELSE 0 END) as pledged '))->leftjoin('business_investments', function ($join) {
            $join->on('business_listings.id', 'business_investments.business_id')->whereIn('business_investments.status', ['pledged', 'funded']);
        })->where('business_listings.business_status', 'listed')->where('business_listings.investment_opportunities', 'yes');

        if (!Auth::check()) {
            $businessListingQuery->where('business_listings.disp_to_nonloggedin', 'yes');
        }

        if (isset($filters['search_title']) && $filters['search_title'] != "") {
            $searchTitle = $filters['search_title'];
            $businessListingQuery->where('business_listings.title', 'like', '%' . $searchTitle . '%');
        }

        if (isset($filters['sectors']) && $filters['sectors'] != "") {
            $sectors = $filters['sectors'];
            $sectors = explode(',', $sectors);
            $sectors = array_filter($sectors);

            $businessListingQuery->leftjoin('business_has_defaults', function ($join) {
                $join->on('business_listings.id', 'business_has_defaults.business_id');
            })->whereIn('business_has_defaults.default_id', $sectors);
            $joinedBusinessDefaults = true;
        }

        if (isset($filters['due_deligence']) && $filters['due_deligence'] != "") {
            $dueDeligence = $filters['due_deligence'];
            $dueDeligence = explode(',', $dueDeligence);
            $dueDeligence = array_filter($dueDeligence);

            if (!$joinedBusinessDefaults) {
                $businessListingQuery->leftjoin('business_has_defaults', function ($join) {
                    $join->on('business_listings.id', 'business_has_defaults.business_id');
                });
            }
            $joinedBusinessDefaults = true;
            $businessListingQuery->whereIn('business_has_defaults.default_id', $dueDeligence);
        }

        if (isset($filters['business_stage']) && $filters['business_stage'] != "") {
            $businessStage = $filters['business_stage'];
            $businessStage = explode(',', $businessStage);
            $businessStage = array_filter($businessStage);

            if (!$joinedBusinessDefaults) {
                $businessListingQuery->leftjoin('business_has_defaults', function ($join) {
                    $join->on('business_listings.id', 'business_has_defaults.business_id');
                });
            }
            $joinedBusinessDefaults = true;
            $businessListingQuery->whereIn('business_has_defaults.default_id', $businessStage);
        }

        if (isset($filters['fund_type']) && $filters['fund_type'] != "") {
            $fundTypes = $filters['fund_type'];
            $fundTypes = explode(',', $fundTypes);
            $fundTypes = array_filter($fundTypes);

            if (!$joinedBusinessData) {
                $businessListingQuery->leftjoin('business_listing_datas', function ($join) {
                    $join->on('business_listings.id', 'business_listing_datas.business_id');
                });
            }
            $joinedBusinessData = true;

            $businessListingQuery->whereIn('business_listing_datas.data_value', $fundTypes)->where('business_listing_datas.data_key', 'fund_typeoffund');
        }

        if (isset($filters['fund_status']) && $filters['fund_status'] != "") {
            $fundStatus = $filters['fund_status'];
            $fundStatus = explode(',', $fundStatus);
            $fundStatus = array_filter($fundStatus);

            if (!$joinedBusinessData) {
                $businessListingQuery->leftjoin('business_listing_datas', function ($join) {
                    $join->on('business_listings.id', 'business_listing_datas.business_id');
                });
            }
            $joinedBusinessData = true;

            $businessListingQuery->whereIn('business_listing_datas.data_value', $fundStatus)->where('business_listing_datas.data_key', 'fund_openclosed');
        }

        if (isset($filters['fund_investmentobjective']) && $filters['fund_investmentobjective'] != "") {
            $fundInvestmentObjective = $filters['fund_investmentobjective'];
            $fundInvestmentObjective = explode(',', $fundInvestmentObjective);
            $fundInvestmentObjective = array_filter($fundInvestmentObjective);

            if (!$joinedBusinessData) {
                $businessListingQuery->leftjoin('business_listing_datas', function ($join) {
                    $join->on('business_listings.id', 'business_listing_datas.business_id');
                });
            }
            $joinedBusinessData = true;

            $businessListingQuery->whereIn('business_listing_datas.data_value', $fundInvestmentObjective)->where('business_listing_datas.data_key', 'fund_investmentobjective');
        }

        if (isset($filters['vct_type']) && $filters['vct_type'] != "") {
            $vctType = $filters['vct_type'];
            $vctType = explode(',', $vctType);
            $vctType = array_filter($vctType);

            if (!$joinedBusinessData) {
                $businessListingQuery->leftjoin('business_listing_datas', function ($join) {
                    $join->on('business_listings.id', 'business_listing_datas.business_id');
                });
            }
            $joinedBusinessData = true;

            $businessListingQuery->whereIn('business_listing_datas.data_value', $vctType)->where('business_listing_datas.data_key', 'vcttype');
        }

        if (isset($filters['vct_investmentstrategy']) && $filters['vct_investmentstrategy'] != "") {
            $vctInvestmentstrategy = $filters['vct_investmentstrategy'];
            $vctInvestmentstrategy = explode(',', $vctInvestmentstrategy);
            $vctInvestmentstrategy = array_filter($vctInvestmentstrategy);

            if (!$joinedBusinessData) {
                $businessListingQuery->leftjoin('business_listing_datas', function ($join) {
                    $join->on('business_listings.id', 'business_listing_datas.business_id');
                });
            }
            $joinedBusinessData = true;

            $businessListingQuery->whereIn('business_listing_datas.data_value', $vctInvestmentstrategy)->where('business_listing_datas.data_key', 'investmentstrategy');
        }

        if (isset($filters['vct_offeringtype']) && $filters['vct_offeringtype'] != "") {
            $vctOfferingtype = $filters['vct_offeringtype'];
            $vctOfferingtype = explode(',', $vctOfferingtype);
            $vctOfferingtype = array_filter($vctOfferingtype);

            if (!$joinedBusinessData) {
                $businessListingQuery->leftjoin('business_listing_datas', function ($join) {
                    $join->on('business_listings.id', 'business_listing_datas.business_id');
                });
            }
            $joinedBusinessData = true;

            $businessListingQuery->whereIn('business_listing_datas.data_value', $vctOfferingtype)->where('business_listing_datas.data_key', 'offeringtype');
        }

        if (isset($filters['aic_sector']) && $filters['aic_sector'] != "") {
            $aicsector = $filters['aic_sector'];
            $aicsector = explode(',', $aicsector);
            $aicsector = array_filter($aicsector);

            if (!$joinedBusinessData) {
                $businessListingQuery->leftjoin('business_listing_datas', function ($join) {
                    $join->on('business_listings.id', 'business_listing_datas.business_id');
                });
            }
            $joinedBusinessData = true;

            $businessListingQuery->whereIn('business_listing_datas.data_value', $aicsector)->where('business_listing_datas.data_key', 'aicsector');
        }

        if ($businessListingType == 'vct') {
            $businessListingQuery->where('business_listings.type', 'fund');
        } else {
            $businessListingQuery->where('business_listings.type', $businessListingType);
        }

        if (isset($filters['tax_status']) && $filters['tax_status'] != "") {
            $taxStatus = $filters['tax_status'];
            $taxStatus = explode(',', $taxStatus);
            $taxStatus = array_filter($taxStatus);

            if (in_array('all', $taxStatus)) {
                if (count($taxStatus) == 1) {
                    $taxStatus = $listingTaxStatus[$businessListingType];
                } else {
                    if (($key = array_search('all', $taxStatus)) !== false) {
                        unset($taxStatus[$key]);
                    }
                }
            }

            if (in_array('combined', $taxStatus)) {
                if (count($taxStatus) == 1) {
                    $taxStatus = $listingTaxStatus[$businessListingType];
                } else {
                    if (($key = array_search('combined', $taxStatus)) !== false) {
                        unset($taxStatus[$key]);
                    }
                }
            }

        } else {

            $taxStatus = $listingTaxStatus[$businessListingType];
        }

        $businessListingQuery->where(function ($bQuery) use ($taxStatus, $businessListingType) {
            foreach ($taxStatus as $key => $status) {
                $statusArr   = [];
                $statusArr[] = $status;
                $taxStatus   = json_encode($statusArr);

                if ($key == 0) {
                    $bQuery->whereRaw("JSON_CONTAINS(business_listings.tax_status, '" . $taxStatus . "' )");
                } else {
                    $bQuery->orWhereRaw("JSON_CONTAINS(business_listings.tax_status, '" . $taxStatus . "' )");
                }

                if ($businessListingType == 'fund') {
                    $fundstaxStatusNotIn = ['vct', 'iht', 'sitr', 'tier1'];
                    foreach ($fundstaxStatusNotIn as $key => $taxStatusNotIn) {
                        $bQuery->whereRaw("JSON_SEARCH(business_listings.tax_status, 'one', '" . $taxStatusNotIn . "' )  IS NULL");
                    }

                }

            }

        });

        if ($businessListingType == 'proposal') {
            $cardName = 'single-company-card';
        } elseif ($businessListingType == 'fund') {
            $cardName = 'funds-card';
        } elseif ($businessListingType == 'vct') {
            $cardName = 'vct-card';
        }

        $businessListingQuery->groupBy('business_listings.id');

        if ($orderBy == 'most_active') {
            $businessListingQuery->orderBy('business_investments.id', 'desc');
        } elseif ($orderBy == 'least_active') {
            $businessListingQuery->orderBy('business_investments.id', 'asc');
        } elseif ($orderBy == 'newest_first') {
            $businessListingQuery->orderBy('business_listings.id', 'desc');
        } elseif ($orderBy == 'oldest_first') {
            $businessListingQuery->orderBy('business_listings.id', 'asc');
        } elseif ($orderBy == 'a_z') {
            $businessListingQuery->orderBy('business_listings.title', 'asc');
        } else {
            $businessListingQuery->orderBy('business_listings.title', 'asc');
        }

        $businessListings      = $businessListingQuery->get();
        $totalBusinessListings = $businessListings->count();

        $businessListings = $businessListings->map(function ($businessListing, $key) {
            $businessDefaults                          = $businessListing->getBusinessDefaultsData();
            $businessListing['business_defaults']      = $businessDefaults;
            $fundRaised                                = $businessListing->invested + $businessListing->pledged; //display fund raised as sum of pledged and invested
            $fundRaisedPercentage                      = ($businessListing->target_amount != 0) ? ($fundRaised / $businessListing->target_amount) * 100 : 0; //display fund raised as sum of pledged and invested
            $businessListing['amount_raised']          = $fundRaised;
            $businessListing['fund_raised_percentage'] = $fundRaisedPercentage;

            return $businessListing;
        });

        if ($orderBy == 'most_funded') {
            $businessListings = $businessListings->sortByDesc('amount_raised');
        } elseif ($orderBy == 'least_funded') {
            $businessListings = $businessListings->sortBy('amount_raised');
        }

        if (isset($filters['investment_sought']) && $filters['investment_sought'] != "") {
            $investmentSought = $filters['investment_sought'];
            $investmentSought = explode(',', $investmentSought);
            $investmentSought = array_filter($investmentSought);

            $filteredInvestmentSought = collect([]);
            if (in_array('below_250k', $investmentSought)) {
                $below250kbusinessListings = $businessListings->where('target_amount', '<=', 250000);
                $filteredInvestmentSought  = $filteredInvestmentSought->merge($below250kbusinessListings);

            }

            if (in_array('251k_500k', $investmentSought)) {
                $from251kTo500kbusinessListings = $businessListings->where('target_amount', '>=', 251000)->where('target_amount', '<', 500000);
                $filteredInvestmentSought       = $filteredInvestmentSought->merge($from251kTo500kbusinessListings);
            }

            if (in_array('501k_1m', $investmentSought)) {
                $from501To1mbusinessListings = $businessListings->where('target_amount', '>=', 501000)->where('target_amount', '<', 1000000);
                $filteredInvestmentSought    = $filteredInvestmentSought->merge($from501To1mbusinessListings);

            }

            if (in_array('1m_above', $investmentSought)) {
                $above1mbusinessListings  = $businessListings->where('target_amount', '>=', 1000000);
                $filteredInvestmentSought = $filteredInvestmentSought->merge($above1mbusinessListings);
            }
            $businessListings      = $filteredInvestmentSought;
            $totalBusinessListings = $businessListings->count();

        }

        if (isset($filters['funded_per']) && $filters['funded_per'] != "") {
            $fundedPer = $filters['funded_per'];
            $fundedPer = explode(',', $fundedPer);
            $fundedPer = array_filter($fundedPer);

            // $lessFlag = false;
            // $aboveFlag = false;
            // $min      = 0;
            // $max      = 0;
            // if (in_array('below_25', $fundedPer)) {
            //     $lessFlag = true;
            //     $min      = 0;
            //     $max      = 25;
            // }

            // if (in_array('25_50', $fundedPer)) {
            //     if (!$lessFlag) {
            //         $lessFlag = true;
            //         $min      = 25;
            //     }

            //     $max = 50;
            // }

            // if (in_array('50_75', $fundedPer)) {
            //     if (!$lessFlag) {
            //         $lessFlag = true;
            //         $min      = 50;
            //     }

            //     $max = 75;

            // }

            // if (in_array('75_above', $fundedPer)) {
            //     $aboveFlag = true;
            //     $max = 75;
            // }

            // if($lessFlag){
            //     $businessListings = $businessListings->where('percentage', '>=', $min);
            // }

            // if ($max) {
            //     if(!$aboveFlag)
            //         $businessListings = $businessListings->where('percentage', '<=', $max);
            //     else
            //         $businessListings = $businessListings->where('percentage', '>=', $max);
            // }
            $filteredFundedPer = collect([]);
            if (in_array('below_25', $fundedPer)) {
                $below25businessListings = $businessListings->where('fund_raised_percentage', '<=', 25);
                $filteredFundedPer       = $filteredFundedPer->merge($below25businessListings);

            }

            if (in_array('25_50', $fundedPer)) {
                $from25To50businessListings = $businessListings->where('fund_raised_percentage', '>=', 25)->where('fund_raised_percentage', '<', 50);
                $filteredFundedPer          = $filteredFundedPer->merge($from25To50businessListings);
            }

            if (in_array('50_75', $fundedPer)) {
                $from50To75businessListings = $businessListings->where('fund_raised_percentage', '>=', 50)->where('fund_raised_percentage', '<', 75);
                $filteredFundedPer          = $filteredFundedPer->merge($from50To75businessListings);

            }

            if (in_array('75_above', $fundedPer)) {
                $above75businessListings = $businessListings->where('fund_raised_percentage', '>=', 75);
                $filteredFundedPer       = $filteredFundedPer->merge($above75businessListings);
            }
            $businessListings      = $filteredFundedPer;
            $totalBusinessListings = $businessListings->count();
        }

        // //platform listings
        $platformListings = $businessListings->filter(function ($businessListing, $key) {
            $businessDefaults = $businessListing->business_defaults;
            if ((isset($businessDefaults['approver'])) && in_array('Platform Listing', $businessDefaults['approver'])) {
                return $businessListing;
            }

        });

        //business listings
        $businessListings = $businessListings->filter(function ($businessListing, $key) {
            $businessDefaults = $businessListing->business_defaults;
            if ((!isset($businessDefaults['approver'])) || (isset($businessDefaults['approver'])) && !in_array('Platform Listing', $businessDefaults['approver'])) {
                return $businessListing;
            }

        });

        $businesslistingHtml = View::make('frontend.business-listings.' . $cardName, compact('businessListings'))->render();
        $businessListings    = $platformListings;
        $platformListingHtml = View::make('frontend.business-listings.' . $cardName, compact('businessListings'))->render();

        $json_data = array(
            "businesslistingHtml"   => $businesslistingHtml,
            "platformListingHtml"   => $platformListingHtml,
            "totalBusinessListings" => $totalBusinessListings,

        );

        return response()->json($json_data);

    }

    public function investmentClients(Request $request)
    {
        $requestFilters = $request->all();
        $firmsList      = getModelList('App\Firm', [], 0, 0, ['name' => 'asc']);
        $firms          = $firmsList['list'];

        $user                 = new User;
        $investors            = $user->getInvestorUsers();
        $clientCategoriesList = getModelList('App\Defaults', ['type' => 'certification'], 0, 0, ['name' => 'asc']);
        $clientCategories     = $clientCategoriesList['list'];

        $investmentList = BusinessListing::select('business_listings.*')->join('business_investments', function ($join) {
            $join->on('business_listings.id', 'business_investments.business_id')->whereIn('business_investments.status', ['funded']);
        })->where('business_listings.business_status', 'listed')->groupBy('business_listings.id')->get();

        $breadcrumbs   = [];
        $breadcrumbs[] = ['url' => url('/'), 'name' => "Manage"];
        $breadcrumbs[] = ['url' => '', 'name' => 'Financials'];
        $breadcrumbs[] = ['url' => '', 'name' => 'Investment Clients'];

        $data['requestFilters']   = $requestFilters;
        $data['firms']            = $firms;
        $data['firm_ids']         = [];
        $data['investors']        = $investors;
        $data['clientCategories'] = $clientCategories;
        $data['investmentList']   = $investmentList;
        $data['breadcrumbs']      = $breadcrumbs;
        $data['pageTitle']        = 'Investment Clients';
        $data['activeMenu']       = 'financials';

        return view('backoffice.financials.investment-clients')->with($data);

    }

    public function getInvestmentClients(Request $request)
    {

        $requestData = $request->all(); //dd($requestData);
        $data        = [];
        $skip        = $requestData['start'];
        $length      = $requestData['length'];
        $orderValue  = $requestData['order'][0];
        $filters     = $requestData['filters'];

        $columnOrder = array(
            '1' => 'business_investments.created_at',
            '2' => 'business_listings.title',
            '3' => 'investorname',
            '4' => 'firm_name',
            '5' => 'invested',
            '6' => 'accrude_amount',
            '7' => 'commission_amount',
            '8' => 'due_amount',
        );

        $columnName = 'business_investments.created_at';
        $orderBy    = 'desc';

        if (isset($columnOrder[$orderValue['column']])) {
            $columnName = $columnOrder[$orderValue['column']];
            $orderBy    = $orderValue['dir'];
        }

        $orderDataBy = [$columnName => $orderBy];

        $filterInvestmentClients = $this->getFilteredInvestmentClients($filters, $skip, $length, $orderDataBy);
        $investmentClients       = $filterInvestmentClients['list'];
        $totalInvestmentClients  = $filterInvestmentClients['totalInvestmentClients'];

        $investmentClientsData = [];
        $firms                 = [];

        $totalInvested = 0;
        $totalDue      = 0;
        $totalPaid     = 0;
        $totalAccrude  = 0;
        foreach ($investmentClients as $key => $investmentClient) {
            $commissions = $investmentClient->wm_commission;
            $paid        = ($investmentClient->commission_amount) ? $investmentClient->commission_amount : 0;
            $accrude     = ($commissions / 100) * $investmentClient->invested;
            $due         = $accrude - $paid;

            $totalInvested += $investmentClient->invested;
            $totalDue += $due;
            $totalPaid += $paid;
            $totalAccrude += $accrude;

            $firms[$investmentClient->firm_id] = $investmentClient->firm_name;

            if ($investmentClient->firms_parent_id && !isset($firms[$investmentClient->firms_parent_id])) {
                $parentFirm                                = Firm::find($investmentClient->firms_parent_id);
                $firms[$investmentClient->firms_parent_id] = (!empty($parentFirm)) ? $parentFirm->name : '';
            }
            $parentFirmName = ($investmentClient->firms_parent_id) ? $firms[$investmentClient->firms_parent_id] : '';

            $investmentClientsData[] = [
                '#'                     => '<div class="custom-checkbox custom-control"><input type="checkbox" value="' . $investmentClient->id . '" class="custom-control-input ck_business" name="ck_business" id="ch' . $investmentClient->id . '"><label class="custom-control-label" for="ch' . $investmentClient->id . '"></label></div> ',
                'invested_date'         => date('d/m/Y', strtotime($investmentClient->investment_date)),
                'investment'            => title_case($investmentClient->title),
                'investor'              => '<a href="' . url('backoffice/investor/' . $investmentClient->investorgicode . '/investor-profile') . '" target="_blank">' . title_case($investmentClient->investorname) . '</a>',
                'firm'                  => '<a href="' . url('backoffice/firms/' . $investmentClient->firm_gi_code . '/') . '" target="_blank">' . title_case($investmentClient->firm_name) . '</a>',
                'invested_amount'       => format_amount($investmentClient->invested, 0, true),
                'accrude'               => format_amount($accrude, 0, true),
                'paid'                  => format_amount($paid, 0, true),
                'due'                   => format_amount($due, 0, true),
                'invested_amount_value' => $investmentClient->invested,
                'accrude_value'         => $accrude,
                'paid_value'            => $paid,
                'due_value'             => $due,
                'parent_firm'           => $parentFirmName,
                'investment_gi_code'    => $investmentClient->gi_code,
                'investor_gi_code'      => $investmentClient->investor_gi_code,
                'firm_gi_code'          => $investmentClient->firm_gi_code,
                'transaction_type'      => 'AI-C',
                'action'                => '<a href="javascript:void(0)" class="add-fees"   business="' . $investmentClient->id . '" investor="' . $investmentClient->investorid . '" type="wm">Expand<i class="icon-arrow-down"></i></a>',

            ];

        }

        $json_data = array(
            "draw"            => intval($requestData['draw']),
            "recordsTotal"    => intval($totalInvestmentClients),
            "recordsFiltered" => intval($totalInvestmentClients),
            "data"            => $investmentClientsData,
            "totalInvested"   => format_amount($totalInvested, 0, true),
            "totalDue"        => format_amount($totalDue, 0, true),
            "totalPaid"       => format_amount($totalPaid, 0, true),
            "totalAccrude"    => format_amount($totalAccrude, 0, true),
        );

        return response()->json($json_data);

    }

    public function getFilteredInvestmentClients($filters, $skip, $length, $orderDataBy)
    {

        $investmentClients = BusinessInvestment::select(\DB::raw('business_listings.*,business_investments.created_at as investment_date,business_investments.investor_id as investorid,firms.name as firm_name,firms.id as firm_id,firms.gi_code as firm_gi_code,firms.wm_commission ,firms.parent_id as firms_parent_id ,IFNULL(commissions.amount, 0) as commission_amount, investor.gi_code as investor_gi_code, CONCAT(investor.first_name," ",investor.last_name) as investorname,investor.email  as investoremail,investor.gi_code  as investorgicode, SUM(business_investments.amount) as invested,
            ((firms.wm_commission / 100)*  SUM(business_investments.amount)) as accrude_amount,
            (((firms.wm_commission / 100)*  SUM(business_investments.amount)) - IFNULL(commissions.amount, 0)) as due_amount'))->leftjoin('business_listings', function ($join) {
            $join->on('business_investments.business_id', 'business_listings.id')->where('business_listings.business_status', 'listed')->where('business_listings.status', 'publish');
        })->leftjoin('users as investor', function ($join) {
            $join->on('business_investments.investor_id', 'investor.id');
        })->leftjoin('users', function ($join) {
            $join->on('business_listings.owner_id', 'users.id');
        })->leftjoin('commissions', function ($join) {
            $join->on('business_listings.id', 'commissions.business_id')->where('commissions.commission_type', 'wm');
        })->leftjoin('firms', function ($join) {
            $join->on('users.firm_id', 'firms.id');
        })->where('business_investments.status', 'funded');

        if ((isset($filters['duration_from']) && $filters['duration_from'] != "") && (isset($filters['duration_to']) && $filters['duration_to'] != "")) {
            $fromDate = date('Y-m-d', strtotime($filters['duration_from']));
            $toDate   = date('Y-m-d', strtotime($filters['duration_to']));
            $investmentClients->whereDate("business_investments.created_at", ">=", $fromDate);
            $investmentClients->whereDate("business_listings.created_at", "<=", $toDate);

        }

        if (isset($filters['firm_name']) && $filters['firm_name'] != "") {
            $investmentClients->where('firms.id', $filters['firm_name']);
        }

        if (isset($filters['firm_ids']) && $filters['firm_ids'] != "") {
            $firmIds = explode(',', $filters['firm_ids']);
            $investmentClients->whereIn('firms.id', $firmIds);
        }

        if (isset($filters['business_ids']) && $filters['business_ids'] != "") {
            $businessIds = explode(',', $filters['business_ids']);
            $businessIds = array_filter($businessIds);
            $investmentClients->whereIn('business_listings.id', $businessIds);
        }

        if (isset($filters['investor_name']) && $filters['investor_name'] != "") {
            $investmentClients->where('business_investments.investor_id', $filters['investor_name']);
        }

        if (isset($filters['client_category']) && $filters['client_category'] != "") {
            $investmentClients->leftjoin('user_has_certifications', function ($join) {
                $join->on('investor.id', 'user_has_certifications.user_id');
            })->where('user_has_certifications.last_active', '1')->where('user_has_certifications.certification_default_id', $filters['client_category']);

        }

        if (isset($filters['investment']) && $filters['investment'] != "") {
            $investmentClients->where('business_listings.id', $filters['investment']);
        }

        foreach ($orderDataBy as $columnName => $orderBy) {
            $investmentClients->orderBy($columnName, $orderBy);
        }

        $investmentClients->groupBy('business_investments.investor_id')->groupBy('business_investments.business_id');

        if ($length > 1) {

            $totalInvestmentClients = $investmentClients->get()->count();
            $investmentClients      = $investmentClients->skip($skip)->take($length)->get();
        } else {
            $investmentClients      = $investmentClients->get();
            $totalInvestmentClients = $investmentClients->count();
        }
        // dd(\DB::getQueryLog());
        return ['totalInvestmentClients' => $totalInvestmentClients, 'list' => $investmentClients];

    }

    public function exportInvestmentClients(Request $request)
    {
        $filters    = $request->all();
        $columnName = 'business_investments.created_at';
        $orderBy    = 'desc';

        $orderDataBy = [$columnName => $orderBy];

        $filterInvestmentClients = $this->getFilteredInvestmentClients($filters, 0, 0, $orderDataBy);
        $investmentClients       = $filterInvestmentClients['list'];
        $totalInvestmentClients  = $filterInvestmentClients['totalInvestmentClients'];

        $investmentClientsData = [];
        $firms                 = [];

        $header = ["Invested Date", "Proposal,Investor", "Firm Name", "Invested Amount", "Accrued", "Paid", "Due", "Parent Firm", "GI ID for the Investments", "GI ID for the Investor", "GI ID for the firm", "Transaction type"];

        $totalInvested = 0;
        $totalDue      = 0;
        $totalPaid     = 0;
        $totalAccrude  = 0;
        foreach ($investmentClients as $key => $investmentClient) {
            $commissions = $investmentClient->wm_commission;
            $paid        = ($investmentClient->commission_amount) ? $investmentClient->commission_amount : 0;
            $accrude     = ($commissions / 100) * $investmentClient->invested;
            $due         = $accrude - $paid;

            $totalInvested += $investmentClient->invested;
            $totalDue += $due;
            $totalPaid += $paid;
            $totalAccrude += $accrude;

            $firms[$investmentClient->firm_id] = $investmentClient->firm_name;

            if ($investmentClient->firms_parent_id && !isset($firms[$investmentClient->firms_parent_id])) {
                $parentFirm                                = Firm::find($investmentClient->firms_parent_id);
                $firms[$investmentClient->firms_parent_id] = (!empty($parentFirm)) ? $parentFirm->name : '';
            }
            $parentFirmName = ($investmentClient->firms_parent_id) ? $firms[$investmentClient->firms_parent_id] : '';

            $investmentClientsData[] = [
                date('d/m/Y', strtotime($investmentClient->investment_date)),
                title_case($investmentClient->title) . '(' . $investmentClient->investoremail . ')',
                title_case($investmentClient->investorname),
                title_case($investmentClient->firm_name),
                format_amount($investmentClient->invested),
                format_amount($accrude, 0),
                format_amount($paid, 0),
                format_amount($due, 0),
                $parentFirmName,
                $investmentClient->gi_code,
                $investmentClient->investor_gi_code,
                $investmentClient->firm_gi_code,
                'AI-C',

            ];

        }
        $fileName = 'Wealth_Manager_Fees_as_on_' . date('d-m-Y');
        generateCSV($header, $investmentClientsData, $fileName);

        return true;
    }

    public function generateInvestmentClientsPdf(Request $request)
    {
        $data       = [];
        $filters    = $request->all();
        $columnName = 'business_investments.created_at';
        $orderBy    = 'desc';

        $orderDataBy = [$columnName => $orderBy];

        $filterInvestmentClients = $this->getFilteredInvestmentClients($filters, 0, 0, $orderDataBy);
        $investmentClients       = $filterInvestmentClients['list'];
        $totalInvestmentClients  = $filterInvestmentClients['totalInvestmentClients'];

        $args                     = array();
        $header_footer_start_html = getHeaderPageMarkup($args);

        $investorPdf = new InvestorPdfHtml();

        $html = $investorPdf->getInvestmentClientHtml($investmentClients);
        // echo $html; exit;

        $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', array(5, 5, 5, 5));
        $html2pdf->pdf->SetDisplayMode('fullpage');

        $html2pdf->writeHTML($html);
        $html2pdf->output();

        return true;

    }

    public function businessClients(Request $request)
    {
        $requestFilters = $request->all();
        $firmsList      = getModelList('App\Firm', [], 0, 0, ['name' => 'asc']);
        $firms          = $firmsList['list'];

        $investmentList = BusinessListing::select('business_listings.*')->join('business_investments', function ($join) {
            $join->on('business_listings.id', 'business_investments.business_id')->whereIn('business_investments.status', ['funded']);
        })->where('business_listings.business_status', 'listed')->groupBy('business_listings.id')->get();

        $breadcrumbs   = [];
        $breadcrumbs[] = ['url' => url('/'), 'name' => "Manage"];
        $breadcrumbs[] = ['url' => '', 'name' => 'Financials'];
        $breadcrumbs[] = ['url' => '', 'name' => 'Business Clients'];

        $data['requestFilters'] = $requestFilters;
        $data['firms']          = $firms;
        $data['firm_ids']       = [];
        $data['investmentList'] = $investmentList;
        $data['breadcrumbs']    = $breadcrumbs;
        $data['pageTitle']      = 'Business Clients';
        $data['activeMenu']     = 'financials';

        return view('backoffice.financials.business-clients')->with($data);

    }

    public function getBusinessClients(Request $request)
    {

        $requestData = $request->all(); //dd($requestData);
        $data        = [];
        $skip        = $requestData['start'];
        $length      = $requestData['length'];
        $orderValue  = $requestData['order'][0];
        $filters     = $requestData['filters'];

        $columnOrder = array(
            '1' => 'business_listings.title',
            '2' => 'investment_raised',
            '3' => 'accrude_amount',
            '4' => 'paid_amount',
            '5' => 'due_amount',
        );


        $columnName = 'business_listings.title';
        $orderBy    = 'desc';


        if (isset($columnOrder[$orderValue['column']])) {
            $columnName = $columnOrder[$orderValue['column']];
            $orderBy    = $orderValue['dir'];
        }

        
        $orderDataBy = [$columnName => $orderBy];

        $filterBusinessClients = $this->getFilteredBusinessClients($filters, $skip, $length, $orderDataBy);
        $businessClients       = $filterBusinessClients['list'];
        $totalBusinessClients  = $filterBusinessClients['totalBusinessClients'];

        $businessClientsData = [];
        $firms               = [];

        $totalInvested = 0;
        $totalDue      = 0;
        $totalPaid     = 0;
        $totalAccrude  = 0;

        foreach ($businessClients as $key => $businessClient) {
            $commissions = $businessClient->wm_commission;
            // $commisonPaid = DB::select(" select SUM(amount) as `paid` from `commissions` where commission_type='introducer' and `business_id` = '" . $businessClient->id . "' group by `business_id`");
            // $paid         = (!empty($commisonPaid) && isset($commisonPaid[0])) ? $commisonPaid[0]->paid : 0;
            $paid    = $businessClient->paid_amount;
            $accrude = ($commissions / 100) * $businessClient->investment_raised;
            $due     = $accrude - $paid;



            $totalInvested += $businessClient->invested;
            $totalDue += $due;
            $totalPaid += $paid;
            $totalAccrude += $accrude;

            

            $businessClientsData[] = [
                '#'               => '<div class="custom-checkbox custom-control"><input type="checkbox" value="' . $businessClient->id . '" class="custom-control-input ck_business" name="ck_business" id="ch' . $businessClient->id . '"><label class="custom-control-label" for="ch' . $businessClient->id . '"></label></div> ',
                'investment'      => title_case($businessClient->title) . '<br>(' . $businessClient->investoremail . ')',
                'invested_amount' => format_amount($businessClient->investment_raised, 0, true),
                'accrude'         => format_amount($accrude, 0, true),
                'paid'            => format_amount($paid, 0, true),
                'due'             => format_amount($due, 0, true),

                'action'          => '<a href="javascript:void(0)" class="add-fees" business="' . $businessClient->id . '" investor="0" type="introducer">Expand<i class="icon-arrow-down"></i></a>',

            ];

        }

        $json_data = array(
            "draw"            => intval($requestData['draw']),
            "recordsTotal"    => intval($totalBusinessClients),
            "recordsFiltered" => intval($totalBusinessClients),
            "data"            => $businessClientsData,
            "totalInvested"   => format_amount($totalInvested, 0, true),
            "totalDue"        => format_amount($totalDue, 0, true),
            "totalPaid"       => format_amount($totalPaid, 0, true),
            "totalAccrude"    => format_amount($totalAccrude, 0, true),
        );

        return response()->json($json_data);

    }

    public function getFilteredBusinessClients($filters, $skip, $length, $orderDataBy)
    {
        

        $businessClients = BusinessInvestment::select(\DB::raw('business_listings.*,business_investments.created_at as investment_date,firms.name as firm_name,firms.id as firm_id,firms.gi_code as firm_gi_code,firms.wm_commission ,firms.parent_id as firms_parent_id ,investor.gi_code as investor_gi_code, CONCAT(investor.first_name," ",investor.last_name) as investorname,investor.email  as investoremail, SUM(business_investments.amount) as investment_raised, IFNULL((select SUM(amount) as `paid` from `commissions` where commission_type="introducer" and `business_id`=business_listings.id ),0) as paid_amount,((firms.wm_commission / 100)*  SUM(business_investments.amount)) as accrude_amount, (((firms.wm_commission / 100)*  SUM(business_investments.amount)) - IFNULL((select SUM(amount) as `paid` from `commissions` where commission_type="introducer" and `business_id`=business_listings.id ),0)) as due_amount'))->leftjoin('business_listings', function ($join) {
            $join->on('business_investments.business_id', 'business_listings.id')->where('business_listings.business_status', 'listed')->where('business_listings.status', 'publish');
        })->leftjoin('users as investor', function ($join) {
            $join->on('business_investments.investor_id', 'investor.id');
        })->leftjoin('users', function ($join) {
            $join->on('business_listings.owner_id', 'users.id');
        })->leftjoin('firms', function ($join) {
            $join->on('users.firm_id', 'firms.id');
        })->where('business_investments.status', 'funded');

        if ((isset($filters['duration_from']) && $filters['duration_from'] != "") && (isset($filters['duration_to']) && $filters['duration_to'] != "")) {
            $fromDate = date('Y-m-d', strtotime($filters['duration_from']));
            $toDate   = date('Y-m-d', strtotime($filters['duration_to']));
            $businessClients->whereDate("business_investments.created_at", ">=", $fromDate);
            $businessClients->whereDate("business_listings.created_at", "<=", $toDate);

        }

        if (isset($filters['firm_name']) && $filters['firm_name'] != "") {
            $businessClients->where('firms.id', $filters['firm_name']);
        }

        if (isset($filters['firm_ids']) && $filters['firm_ids'] != "") {
            $firmIds = explode(',', $filters['firm_ids']);
            $businessClients->whereIn('firms.id', $firmIds);
        }

        if (isset($filters['business_ids']) && $filters['business_ids'] != "") {
            $businessIds = explode(',', $filters['business_ids']);
            $businessIds = array_filter($businessIds);
            $businessClients->whereIn('business_listings.id', $businessIds);
        }

        if (isset($filters['investment']) && $filters['investment'] != "") {
            $businessClients->where('business_listings.id', $filters['investment']);
        }

        foreach ($orderDataBy as $columnName => $orderBy) {
            $businessClients->orderBy($columnName, $orderBy);
        }

        $businessClients->groupBy('business_investments.business_id');
        // dd($businessClients->toSql());
        if ($length > 1) {

            $totalBusinessClients = $businessClients->get()->count();
            $businessClients      = $businessClients->skip($skip)->take($length)->get();
        } else {
            $businessClients      = $businessClients->get();
            $totalBusinessClients = $businessClients->count();
        }

        return ['totalBusinessClients' => $totalBusinessClients, 'list' => $businessClients];

    }

    public function exportBusinessClients(Request $request)
    {
        $filters    = $request->all();
        $columnName = 'business_investments.created_at';
        $orderBy    = 'desc';

        $orderDataBy = [$columnName => $orderBy];

        $filterBusinessClients = $this->getFilteredBusinessClients($filters, 0, 0, $orderDataBy);
        $businessClients       = $filterBusinessClients['list'];
        $totalBusinessClients  = $filterBusinessClients['totalBusinessClients'];

        $investmentClientsData = [];
        $firms                 = [];

        $header = ['Platform GI Code', 'Business Proposal', 'Investment Raised', 'Commission accrued', 'Commission paid', 'Commission due'];

        foreach ($businessClients as $key => $businessClient) {
            $commissions  = $businessClient->wm_commission;
            // $commisonPaid = DB::select(" select SUM(amount) as `paid` from `commissions` where commission_type='introducer' and `business_id` = '" . $businessClient->id . "' group by `business_id`");
            // $paid         = (!empty($commisonPaid) && isset($commisonPaid[0])) ? $commisonPaid[0]->paid : 0;
            $paid    = $businessClient->paid_amount;
            $accrude      = ($commissions / 100) * $businessClient->investment_raised;
            $due          = $accrude - $paid;

            $businessClientsData[] = [
                $businessClient->gi_code,
                title_case($businessClient->title) . '(' . $businessClient->investoremail . ')',
                format_amount($businessClient->investment_raised, 0),
                format_amount($accrude, 0),
                format_amount($paid, 0),
                format_amount($due, 0),

            ];

        }
        $fileName = 'Introducer_commission_as_on_' . date('d-m-Y');
        generateCSV($header, $businessClientsData, $fileName);

        return true;
    }

    public function generateBusinessClientsPdf(Request $request)
    {
        $data       = [];
        $filters    = $request->all();
        $columnName = 'business_investments.created_at';
        $orderBy    = 'desc';

        $orderDataBy = [$columnName => $orderBy];

        $filterBusinessClients = $this->getFilteredBusinessClients($filters, 0, 0, $orderDataBy);
        $businessClients       = $filterBusinessClients['list'];
        $totalBusinessClients  = $filterBusinessClients['totalBusinessClients'];

        $args                     = array();
        $header_footer_start_html = getHeaderPageMarkup($args);

        $investorPdf = new InvestorPdfHtml();

        $html = $investorPdf->getBusinessClientHtml($businessClients);
        // echo $html; exit;

        $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', array(5, 5, 5, 5));
        $html2pdf->pdf->SetDisplayMode('fullpage');

        $html2pdf->writeHTML($html);
        $html2pdf->output();

        return true;

    }

    public function saveCommission(Request $request)
    {
        $requestData = $request->all();

        $commission                  = new Commission;
        $commission->commission_type = $requestData['type'];

        $commission->investor_id = $requestData['investor_id'];
        $commission->business_id = $requestData['business_id'];
        $commission->comment     = $requestData['comment'];
        $commission->amount      = $requestData['amount'];
        $commission->save();

        return $commission->id;

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
