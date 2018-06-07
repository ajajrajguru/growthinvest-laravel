<?php

namespace App\Http\Controllers;

use App\BusinessHasDefault;
use App\BusinessInvestment;
use App\BusinessListing;
use App\BusinessListingData;
use App\BusinessPdfHtml;
use App\BusinessVideo;
use App\Commission;
use App\Firm;
use App\InvestorPdfHtml;
use App\User;
use Auth;
use DB;
use File;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
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

        $requestFilters = $request->all();

        if (!empty($requestFilters)) {
            foreach ($requestFilters as $key => $values) {
                if ($key == 'title') {
                    continue;
                }

                $values               = explode(',', $values);
                $requestFilters[$key] = array_filter($values);

            }
        }

        $sectors         = getBusinessSectors();
        $dueDeligence    = getDueDeligence();
        $stageOfBusiness = getStageOfBusiness();

        $data['aicsector']             = aicsectors();
        $data['stageOfBusiness']       = $stageOfBusiness;
        $data['requestFilters']        = $requestFilters;
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

        $filterDefaultIds = [];
        if (isset($filters['sectors']) && $filters['sectors'] != "") {
            $sectors          = $filters['sectors'];
            $sectors          = explode(',', $sectors);
            $sectors          = array_filter($sectors);
            $filterDefaultIds = array_merge($sectors, $filterDefaultIds);

            $businessListingQuery->leftjoin('business_has_defaults as bds', function ($join) {
                $join->on('business_listings.id', 'bds.business_id');
            })->whereIn('bds.default_id', $sectors);
            $joinedBusinessDefaults = true;
        }

        if (isset($filters['due_deligence']) && $filters['due_deligence'] != "") {
            $dueDeligence     = $filters['due_deligence'];
            $dueDeligence     = explode(',', $dueDeligence);
            $dueDeligence     = array_filter($dueDeligence);
            $filterDefaultIds = array_merge($dueDeligence, $filterDefaultIds);

            $businessListingQuery->leftjoin('business_has_defaults  as bddd', function ($join) {
                $join->on('business_listings.id', 'bddd.business_id');
            })->whereIn('bddd.default_id', $dueDeligence);

        }

        if (isset($filters['business_stage']) && $filters['business_stage'] != "") {
            $businessStage    = $filters['business_stage'];
            $businessStage    = explode(',', $businessStage);
            $businessStage    = array_filter($businessStage);
            $filterDefaultIds = array_merge($businessStage, $filterDefaultIds);

            $businessListingQuery->leftjoin('business_has_defaults  as bdbs', function ($join) {
                $join->on('business_listings.id', 'bdbs.business_id');
            })->whereIn('bdbs.default_id', $businessStage);
        }

        if (isset($filters['fund_type']) && $filters['fund_type'] != "") {
            $fundTypes = $filters['fund_type'];
            $fundTypes = explode(',', $fundTypes);
            $fundTypes = array_filter($fundTypes);

            $businessListingQuery->leftjoin('business_listing_datas as bldft', function ($join) {
                $join->on('business_listings.id', 'bldft.business_id');
            })->whereIn('bldft.data_value', $fundTypes)->where('bldft.data_key', 'fund_typeoffund');
        }

        if (isset($filters['fund_status']) && $filters['fund_status'] != "") {
            $fundStatus = $filters['fund_status'];
            $fundStatus = explode(',', $fundStatus);
            $fundStatus = array_filter($fundStatus);

            $businessListingQuery->leftjoin('business_listing_datas as bldfs', function ($join) {
                $join->on('business_listings.id', 'bldfs.business_id');
            })->whereIn('bldfs.data_value', $fundStatus)->where('bldfs.data_key', 'fund_openclosed');
        }

        if (isset($filters['fund_investmentobjective']) && $filters['fund_investmentobjective'] != "") {
            $fundInvestmentObjective = $filters['fund_investmentobjective'];
            $fundInvestmentObjective = explode(',', $fundInvestmentObjective);
            $fundInvestmentObjective = array_filter($fundInvestmentObjective);

            $businessListingQuery->leftjoin('business_listing_datas as bldfio', function ($join) {
                $join->on('business_listings.id', 'bldfio.business_id');
            })->whereIn('bldfio.data_value', $fundInvestmentObjective)->where('bldfio.data_key', 'fund_investmentobjective');
        }

        if (isset($filters['vct_type']) && $filters['vct_type'] != "") {
            $vctType = $filters['vct_type'];
            $vctType = explode(',', $vctType);
            $vctType = array_filter($vctType);

            $businessListingQuery->leftjoin('business_listing_datas as bldfvt', function ($join) {
                $join->on('business_listings.id', 'bldfvt.business_id');
            })->whereIn('bldfvt.data_value', $vctType)->where('bldfvt.data_key', 'vcttype');
        }

        if (isset($filters['vct_investmentstrategy']) && $filters['vct_investmentstrategy'] != "") {
            $vctInvestmentstrategy = $filters['vct_investmentstrategy'];
            $vctInvestmentstrategy = explode(',', $vctInvestmentstrategy);
            $vctInvestmentstrategy = array_filter($vctInvestmentstrategy);

            $businessListingQuery->leftjoin('business_listing_datas as bldfvis', function ($join) {
                $join->on('business_listings.id', 'bldfvis.business_id');
            })->whereIn('bldfvis.data_value', $vctInvestmentstrategy)->where('bldfvis.data_key', 'investmentstrategy');
        }

        if (isset($filters['vct_offeringtype']) && $filters['vct_offeringtype'] != "") {
            $vctOfferingtype = $filters['vct_offeringtype'];
            $vctOfferingtype = explode(',', $vctOfferingtype);
            $vctOfferingtype = array_filter($vctOfferingtype);

            $businessListingQuery->leftjoin('business_listing_datas as bldfvot', function ($join) {
                $join->on('business_listings.id', 'bldfvot.business_id');
            })->whereIn('bldfvot.data_value', $vctOfferingtype)->where('bldfvot.data_key', 'offeringtype');
        }

        if (isset($filters['aic_sector']) && $filters['aic_sector'] != "") {
            $aicsector = $filters['aic_sector'];
            $aicsector = explode(',', $aicsector);
            $aicsector = array_filter($aicsector);

            $businessListingQuery->leftjoin('business_listing_datas as bldfas', function ($join) {
                $join->on('business_listings.id', 'bldfas.business_id');
            })->whereIn('bldfas.data_value', $aicsector)->where('bldfas.data_key', 'aicsector');
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

            $businessLink = url("/investment-opportunities/fund/" . $investmentClient->slug);
            if ($investmentClient->type == "proposal") {
                $businessLink = url("investment-opportunities/single-company/" . $investmentClient->slug);
            }

            $investmentClientsData[] = [
                '#'                     => '<div class="custom-checkbox custom-control"><input type="checkbox" value="' . $investmentClient->id . '" class="custom-control-input ck_business" name="ck_business" id="ch' . $investmentClient->investment_id . '"><label class="custom-control-label" for="ch' . $investmentClient->investment_id . '"></label></div> ',
                'invested_date'         => date('d/m/Y', strtotime($investmentClient->investment_date)),
                'investment'            => '<a href="' . $businessLink . '" target="_blank">' . title_case($investmentClient->title) . '</a>',
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

        $investmentClients = BusinessInvestment::select(\DB::raw('business_listings.*,business_investments.id as investment_id,business_investments.created_at as investment_date,business_investments.investor_id as investorid,firms.name as firm_name,firms.id as firm_id,firms.gi_code as firm_gi_code,firms.wm_commission ,firms.parent_id as firms_parent_id ,IFNULL(commissions.amount, 0) as commission_amount, investor.gi_code as investor_gi_code, CONCAT(investor.first_name," ",investor.last_name) as investorname,investor.email  as investoremail,investor.gi_code  as investorgicode, SUM(business_investments.amount) as invested,
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
            $join->on('investor.firm_id', 'firms.id');
        })->where('business_investments.status', 'funded');

        if ((isset($filters['duration_from']) && $filters['duration_from'] != "") && (isset($filters['duration_to']) && $filters['duration_to'] != "")) {
            $fromDate = date('Y-m-d', strtotime($filters['duration_from']));
            $toDate   = date('Y-m-d', strtotime($filters['duration_to']));
            $investmentClients->whereDate("business_investments.created_at", ">=", $fromDate);
            $investmentClients->whereDate("business_investments.created_at", "<=", $toDate);

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
            $investorEmail  = (!empty($investmentClient->investoremail)) ? '(' . $investmentClient->investoremail . ')' : '';

            $investmentClientsData[] = [
                date('d/m/Y', strtotime($investmentClient->investment_date)),
                title_case($investmentClient->title) . $investorEmail,
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
            $commissions = $businessClient->introducer_commission;
            // $commisonPaid = DB::select(" select SUM(amount) as `paid` from `commissions` where commission_type='introducer' and `business_id` = '" . $businessClient->id . "' group by `business_id`");
            // $paid         = (!empty($commisonPaid) && isset($commisonPaid[0])) ? $commisonPaid[0]->paid : 0;
            $paid    = $businessClient->paid_amount;
            $accrude = ($commissions / 100) * $businessClient->investment_raised;
            $due     = $accrude - $paid;

            $totalInvested += $businessClient->investment_raised;
            $totalDue += $due;
            $totalPaid += $paid;
            $totalAccrude += $accrude;
            $owenerEmail = (!empty($businessClient->owneremail)) ? '<br>(' . $businessClient->owneremail . ')' : '';

            $businessLink = url("/investment-opportunities/fund/" . $businessClient->slug);
            if ($businessClient->type == "proposal") {
                $businessLink = url("investment-opportunities/single-company/" . $businessClient->slug);
            }

            $businessClientsData[] = [
                '#'               => '<div class="custom-checkbox custom-control"><input type="checkbox" value="' . $businessClient->id . '" class="custom-control-input ck_business" name="ck_business" id="ch' . $businessClient->id . '"><label class="custom-control-label" for="ch' . $businessClient->id . '"></label></div> ',
                'investment'      => '<a href="' . $businessLink . '" target="_blank">' . title_case($businessClient->title) . $owenerEmail . '</a>',
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

        $businessClients = BusinessInvestment::select(\DB::raw('business_listings.*,business_investments.created_at as investment_date,firms.name as firm_name,firms.id as firm_id,firms.gi_code as firm_gi_code,firms.introducer_commission ,firms.parent_id as firms_parent_id , CONCAT(owner.first_name," ",owner.last_name) as ownername,owner.email  as owneremail, SUM(business_investments.amount) as investment_raised, IFNULL((select SUM(amount) as `paid` from `commissions` where commission_type="introducer" and `business_id`=business_listings.id ),0) as paid_amount,((firms.wm_commission / 100)*  SUM(business_investments.amount)) as accrude_amount, (((firms.wm_commission / 100)*  SUM(business_investments.amount)) - IFNULL((select SUM(amount) as `paid` from `commissions` where commission_type="introducer" and `business_id`=business_listings.id ),0)) as due_amount'))->leftjoin('business_listings', function ($join) {
            $join->on('business_investments.business_id', 'business_listings.id')->where('business_listings.business_status', 'listed')->where('business_listings.status', 'publish');
        })->leftjoin('users as owner', function ($join) {
            $join->on('business_listings.owner_id', 'owner.id');
        })->leftjoin('firms', function ($join) {
            $join->on('owner.firm_id', 'firms.id');
        })->where('business_investments.status', 'funded');

        if ((isset($filters['duration_from']) && $filters['duration_from'] != "") && (isset($filters['duration_to']) && $filters['duration_to'] != "")) {
            $fromDate = date('Y-m-d', strtotime($filters['duration_from']));
            $toDate   = date('Y-m-d', strtotime($filters['duration_to']));
            $businessClients->whereDate("business_investments.created_at", ">=", $fromDate);
            $businessClients->whereDate("business_investments.created_at", "<=", $toDate);

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
            $commissions = $businessClient->introducer_commission;
            // $commisonPaid = DB::select(" select SUM(amount) as `paid` from `commissions` where commission_type='introducer' and `business_id` = '" . $businessClient->id . "' group by `business_id`");
            // $paid         = (!empty($commisonPaid) && isset($commisonPaid[0])) ? $commisonPaid[0]->paid : 0;
            $paid        = $businessClient->paid_amount;
            $accrude     = ($commissions / 100) * $businessClient->investment_raised;
            $due         = $accrude - $paid;
            $owenerEmail = (!empty($businessClient->owneremail)) ? '<br>(' . $businessClient->owneremail . ')' : '';

            $businessClientsData[] = [
                $businessClient->gi_code,
                title_case($businessClient->title) . $owenerEmail,
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

    // enterpreneur business proposals
    public function getUserBusinessProposals()
    {

        $user   = Auth::user();
        $userId = $user->id;

        $businessListings = BusinessListing::where('owner_id', $userId)->whereIn('status', ['publish', 'draft'])->get();

        $businessListings = $businessListings->filter(function ($businessListing) {

            $investedAmount = BusinessInvestment::select(\DB::raw('SUM(amount) as invested'))->where('status', 'funded')->where('business_id', $businessListing->id)->groupBy('business_id')->first();
            if (!empty($investedAmount)) {
                $investedAmount = $investedAmount->invested;
            } else {
                $investedAmount = 0;
            }

            $investedCount  = BusinessInvestment::where('status', 'pledged')->where('business_id', $businessListing->id)->count();
            $pledgeCount    = BusinessInvestment::where('status', 'funded')->where('business_id', $businessListing->id)->count();
            $watchListCount = BusinessInvestment::where('status', 'watch_list')->where('business_id', $businessListing->id)->count();
            $questionCount  = 0;

            $businessListing['investedAmount'] = format_amount($investedCount, 0, true);
            $businessListing['investedCount']  = $investedCount;
            $businessListing['pledgeCount']    = $pledgeCount;
            $businessListing['watchListCount'] = $watchListCount;
            $businessListing['questionCount']  = $questionCount;

            return $businessListing;
        });

        $data['businessListings'] = $businessListings;
        $data['user']             = $user;

        $data['active_menu'] = 'business-proposals';

        return view('frontend.entrepreneur.business-proposals')->with($data);
    }

/**
 * Show the form for creating a new resource.
 *
 * @return \Illuminate\Http\Response
 */
    public function create($type, $slug = '')
    {
        if ($type == 'single-company') {
            $businessListingType = 'proposal';
        } elseif ($type == 'funds') {
            $businessListingType = 'fund';
        } elseif ($type == 'vct') {
            $businessListingType = 'vct';
        }

        $sectors         = getDefaultValues('business-sector');
        $stageOfBusiness = getDefaultValues('stage_of_business');
        $milestones      = getDefaultValues('milestone');
        $businessStatus  = '';

        if ($slug == '') {
            $businessListing = new BusinessListing;
        } else {
            $businessListing = BusinessListing::where('slug', $slug)->first();
            $businessStatus  = $businessListing->status;
        }

        if ($businessStatus == 'publish') {
            $publishedBusinessListing = $businessListing;
        } else {
            $publishedBusinessListing = BusinessListing::where('slug', $slug)->where('status', 'publish')->first();
        }

        $sectionStatus           = $businessListing->getBusinessSectionStatus();
        $businessIdeas           = $businessListing->getBusinessIdeas();
        $businessProposalDetails = $businessListing->getBusinessProposalDetails();
        $fundingRequirement      = $businessListing->getFundingRequirement();
        $businessHmrcStatus      = $businessListing->getBusinessHmrcStatus();
        $financials              = $businessListing->getFinancials();
        $teamMemberDetails       = $businessListing->getTeamMemberDetails();
        $companyDetails          = $businessListing->getCompanyDetails();
        $businessFiles           = $businessListing->getAllBusinessFile();
        $documentUploads         = $businessListing->getDocumentUpload();
        $dueDeligence            = $businessListing->getDueDeligence();
        $publicAdditionalDocs    = $businessListing->getBusinessMultipleFile('public_additional_documents');
        $privateAdditionalDocs   = $businessListing->getBusinessMultipleFile('private_additional_documents');
        $defaultIds              = $businessListing->businessDefaults()->pluck('default_id')->toArray();
        $profilePic              = $businessListing->getBusinessLogo('medium_1x1');
        $backgroundImage         = $businessListing->getBusinessBackgroundImage('medium_2_58x1');
        $videos                  = $businessListing->businessVideos()->get();

        $data['active_menu']              = 'business-proposals';
        $data['mode']                     = 'edit';
        $data['businessListing']          = $businessListing;
        $data['publishedBusinessListing'] = $publishedBusinessListing;
        $data['businessProposalDetails']  = (!empty($businessProposalDetails)) ? unserialize($businessProposalDetails->data_value) : [];
        $data['businessHmrcStatus']       = (!empty($businessHmrcStatus)) ? $businessHmrcStatus->data_value : '';
        $data['defaultIds']               = $defaultIds;
        $data['businessIdeas']            = $businessIdeas;
        $data['sectors']                  = $sectors;
        $data['stageOfBusiness']          = $stageOfBusiness;
        $data['businessFiles']            = $businessFiles;
        $data['documentUploads']          = (!empty($documentUploads)) ? unserialize($documentUploads->data_value) : [];
        $data['publicAdditionalDocs']     = $publicAdditionalDocs;
        $data['privateAdditionalDocs']    = $privateAdditionalDocs;
        $data['fundingRequirement']       = (!empty($fundingRequirement)) ? unserialize($fundingRequirement->data_value) : [];
        $data['financials']               = (!empty($financials)) ? unserialize($financials->data_value) : [];
        $data['companyDetails']           = (!empty($companyDetails)) ? unserialize($companyDetails->data_value) : [];
        $data['teamMemberDetails']        = (!empty($teamMemberDetails)) ? unserialize($teamMemberDetails->data_value) : [];
        $data['dueDeligence']             = (!empty($dueDeligence)) ? unserialize($dueDeligence->data_value) : [];
        $data['sectionStatus']            = (!empty($sectionStatus)) ? unserialize($sectionStatus->data_value) : [];
        $data['milestones']               = $milestones;
        $data['businessLogo']             = $profilePic['url'];
        $data['hasBusinessLogo']          = $profilePic['hasImage'];
        $data['backgroundImage']          = $backgroundImage['url'];
        $data['businessListingType']      = $businessListingType;
        $data['hasBackgroundImage']       = $backgroundImage['hasImage'];
        $data['videos']                   = $videos;

        return view('frontend.entrepreneur.add-business-proposals')->with($data);
    }

/**
 * Store a newly created resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
    public function store(Request $request)
    {
        $requestData = $request->all();
        $submitType  = $requestData['submit_type'];
        $formData    = $requestData['form_data'];
        $submitData  = [];
        foreach ($formData as $key => $data) {
            if (in_array($data['name'], ['exp_tax_status', 'tags_input', 'chk_milestones', 'use_of_funds', 'use_of_funds_amount'])) {
                $submitData[$data['name']][] = $data['value'];
            } else {
                $submitData[$data['name']] = $data['value'];

            }

        }

        $giCode     = $submitData['gi_code']; //published gi code
        $refernceId = $submitData['refernce_id']; //published gi code
        $redirect   = false;

        if ($refernceId == '') {
            $redirect = true;
        }

        $businessListing                           = new BusinessListing;

        if ($giCode != '') {
            $publishBusinessListing = BusinessListing::where('gi_code', $giCode)->first();
            $slug = $publishBusinessListing->slug;
            $parentId = $publishBusinessListing->id;
        }
        else{
            $slug = getUniqueBusinessSlug($businessListing, $submitData['title']);
            $parentId = '';
        }

        
        $businessListing->parent                   = $parentId;
        $businessListing->slug                     = $slug
        $businessListing->type                     = $submitData['business_type'];
        $businessListing->status                   = 'draft';
        $businessListing->investment_opportunities = 'no';
        $businessListing->disp_to_nonloggedin      = 'no';
        $businessListing->owner_id                 = Auth::user()->id;
        $businessListing->title                    = $submitData['title'];
        $businessListing->save();

        $this->saveBusinessSectionStatus($businessListing, $submitData);

        if ($submitType == 'business_idea') {
            $this->saveBusinessIdeas($businessListing, $submitData);
        } elseif ($submitType == 'business_proposal_details') {
            $this->saveBusinessProposalDetails($businessListing, $submitData);
        } elseif ($submitType == 'funding_requirement') {
            $this->saveFundingRequirement($businessListing, $submitData);
        } elseif ($submitType == 'financials') {
            $this->saveFinancials($businessListing, $submitData);
        } elseif ($submitType == 'team-members') {
            $this->saveTeamMembers($businessListing, $submitData);
        } elseif ($submitType == 'company-details') {
            $this->saveCompanyDetails($businessListing, $submitData);
        }

        $businessListingType = 'single-company';
        if ($businessListing->type == 'proposal') {
            $businessListingType = 'single-company';
        } elseif ($businessListing->type == 'funds') {
            $businessListingType = 'fund';
        }

        $json_data = array(
            "gi_code"       => $businessListing->gi_code,
            "business_slug" => $businessListing->slug,
            "business_type" => $businessListingType,
            "redirect"      => $redirect,
            "status"        => true,
        );

        return response()->json($json_data);

    }

    public function saveAll(Request $request)
    {
        $requestData = $request->all();
        $submitType  = $requestData['submit_type'];
        $formData    = $requestData['form_data'];
        $submitData  = [];
        foreach ($formData as $key => $data) {
            if (in_array($data['name'], ['exp_tax_status', 'tags_input', 'chk_milestones', 'use_of_funds', 'use_of_funds_amount', 'public_file_path[]', 'private_file_path[]', 'public_additional_documents_file_id', 'private_additional_documents_file_id'])) {
                $submitData[$data['name']][] = $data['value'];
            } else {
                $submitData[$data['name']] = $data['value'];

            }

        }

        $giCode     = $submitData['gi_code'];
        $redirect   = false;
        $clearDraft = false;

        if ($submitType == 'submit') {

            $clearDraft = true;
            if ($giCode == '') {
                $redirect = true;
                $giArgs   = array('prefix' => "GIBP", 'min' => 60000001, 'max' => 70000000);

                $businessListing = new BusinessListing;
                $giCode          = generateGICode($businessListing, 'gi_code', $giArgs);

                $businessListing->slug                     = getUniqueBusinessSlug($businessListing, $submitData['title']);
                $businessListing->type                     = $submitData['business_type'];
                $businessListing->status                   = 'publish';
                $businessListing->gi_code                  = $giCode;
                $businessListing->investment_opportunities = 'no';
                $businessListing->disp_to_nonloggedin      = 'no';
                $businessListing->owner_id                 = Auth::user()->id;

            } else {
                $businessListing = BusinessListing::where('gi_code', $giCode)->first();
            }

        } else {
            
            $businessListing                           = new BusinessListing;
           if ($giCode != '') {
                $publishBusinessListing = BusinessListing::where('gi_code', $giCode)->first();
                $slug = $publishBusinessListing->slug;
                $parentId = $publishBusinessListing->id;
            }
            else{
                $slug = getUniqueBusinessSlug($businessListing, $submitData['title']);
                $parentId = '';
            }

            
            $businessListing->parent                   = $parentId;
            $businessListing->slug                     = $slug
            $businessListing->type                     = $submitData['business_type'];
            $businessListing->status                   = 'draft';
            $businessListing->investment_opportunities = 'no';
            $businessListing->disp_to_nonloggedin      = 'no';
            $businessListing->owner_id                 = Auth::user()->id;

        }

        $businessListing->title = $submitData['title'];
        $businessListing->save();

        $this->saveBusinessSectionStatus($businessListing, $submitData);
        $this->saveBusinessIdeas($businessListing, $submitData);
        $this->saveBusinessProposalDetails($businessListing, $submitData);
        $this->saveFundingRequirement($businessListing, $submitData);
        $this->saveFinancials($businessListing, $submitData);
        $this->saveTeamMembers($businessListing, $submitData);
        $this->saveCompanyDetails($businessListing, $submitData);
        $this->saveDocumentUpload($businessListing, $submitData);
        $this->saveDueDeligence($businessListing, $submitData);
        $this->deleteDocument($businessListing, $submitData);
        $this->saveImageVideo($businessListing, $submitData);

        if ($clearDraft) {
            $draftListings = BusinessListing::where('parent', $businessListing->id)->get(); 
            foreach ($draftListings as $key => $draftListing) {
                $this->deleteBusiness($draftListing);
            }

        }

        $businessListingType = 'single-company';
        if ($businessListing->type == 'proposal') {
            $businessListingType = 'single-company';
        } elseif ($businessListing->type == 'funds') {
            $businessListingType = 'fund';
        }

        $json_data = array(
            "gi_code"       => $businessListing->gi_code,
            "business_type" => $businessListingType,
            "business_slug" => $businessListing->slug,
            "redirect"      => $redirect,
            "status"        => true,
        );

        return response()->json($json_data);

    }

    public function deleteBusiness($businessListing)
    {
        $businessData     = BusinessListingData::where('business_id', $businessListing->id)->delete();
        $businessDefaults = BusinessHasDefault::select('business_has_defaults.*')->join('defaults', 'defaults.id', '=', 'business_has_defaults.default_id')->whereIn('defaults.type', ['business-sector', 'milestone', 'stage_of_business'])->where('business_has_defaults.business_id', $businessListing->id)->delete();
        $businessListing->businessVideos()->delete();

    }

    public function saveBusinessSectionStatus($businessListing, $submitData)
    {
        $data = ['section_status_1' => $submitData['section_status_1'], 'section_status_2' => $submitData['section_status_2'], 'section_status_3' => $submitData['section_status_3'], 'section_status_4' => $submitData['section_status_4'], 'section_status_5' => $submitData['section_status_5'], 'section_status_6' => $submitData['section_status_6'], 'section_status_7' => $submitData['section_status_7'], 'section_status_8' => $submitData['section_status_8'], 'section_status_9' => $submitData['section_status_9']];

        $businessIdeas = $businessListing->getBusinessSectionStatus();
        if (empty($businessIdeas)) {
            $businessIdeas              = new BusinessListingData;
            $businessIdeas->business_id = $businessListing->id;
            $businessIdeas->data_key    = 'business_section_status';
        }

        $businessIdeas->data_value = serialize($data);
        $businessIdeas->save();

    }

    public function saveBusinessIdeas($businessListing, $submitData)
    {
        $data = ['aboutbusiness' => $submitData['aboutbusiness'], 'businessstage' => $submitData['businessstage'], 'businessfunded' => $submitData['businessfunded'], 'incomegenerated' => $submitData['incomegenerated'], 'aboutteam' => $submitData['aboutteam'], 'marketscope' => $submitData['marketscope'], 'exit_strategy' => $submitData['exit_strategy']];

        $businessIdeas = $businessListing->getBusinessIdeas();
        if (empty($businessIdeas)) {
            $businessIdeas              = new BusinessListingData;
            $businessIdeas->business_id = $businessListing->id;
            $businessIdeas->data_key    = 'business_ideas';
        }

        $businessIdeas->data_value = serialize($data);
        $businessIdeas->save();

    }

    public function saveBusinessProposalDetails($businessListing, $submitData)
    {
        $data = ['business_proposal_details' => $submitData['business_proposal_details'], 'address' => $submitData['address'], 'postcode' => $submitData['postcode'], 'website' => $submitData['website'], 'social-facebook' => $submitData['social-facebook'], 'social-linkedin' => $submitData['social-linkedin'], 'social-twitter' => $submitData['social-twitter'], 'social-google' => $submitData['social-google'], 'social-companyhouse' => $submitData['social-companyhouse'], 'started-trading' => $submitData['started-trading'], 'started-trading' => $submitData['started-trading']];

        $businessProposalDetails = $businessListing->getBusinessProposalDetails();
        if (empty($businessProposalDetails)) {
            $businessProposalDetails              = new BusinessListingData;
            $businessProposalDetails->business_id = $businessListing->id;
            $businessProposalDetails->data_key    = 'business_proposal_details';
        }

        $businessProposalDetails->data_value = serialize($data);
        $businessProposalDetails->save();

        $round           = $submitData['proposal_round'];
        $taxStatus       = (isset($submitData['exp_tax_status'])) ? $submitData['exp_tax_status'] : [];
        $hmrcStatus      = $submitData['hmrc_status'];
        $businessSectors = (isset($submitData['tags_input'])) ? $submitData['tags_input'] : [];
        $businessStage   = $submitData['lst_stages_of_business'];
        $milestones      = (isset($submitData['chk_milestones'])) ? $submitData['chk_milestones'] :[];

        $businessListing->tax_status = $taxStatus;
        $businessListing->round      = $round;
        $businessListing->save();

        $businessHmrcStatus = $businessListing->getBusinessHmrcStatus();
        if (empty($businessHmrcStatus)) {
            $businessHmrcStatus              = new BusinessListingData;
            $businessHmrcStatus->business_id = $businessListing->id;
            $businessHmrcStatus->data_key    = 'hmrc_status';
        }
        $businessHmrcStatus->data_value = $hmrcStatus;
        $businessHmrcStatus->save();

        BusinessHasDefault::select('business_has_defaults.*')->join('defaults', 'defaults.id', '=', 'business_has_defaults.default_id')->where('defaults.type', 'business-sector')->where('business_has_defaults.business_id', $businessListing->id)->delete();
        if (!empty($businessSectors)) {

            foreach ($businessSectors as $businessSector) {

                $businessHasDefault              = new BusinessHasDefault;
                $businessHasDefault->business_id = $businessListing->id;
                $businessHasDefault->default_id  = $businessSector;
                $businessHasDefault->save();

            }
        }

        BusinessHasDefault::select('business_has_defaults.*')->join('defaults', 'defaults.id', '=', 'business_has_defaults.default_id')->where('defaults.type', 'milestone')->where('business_has_defaults.business_id', $businessListing->id)->delete();
        if (!empty($milestones)) {

            foreach ($milestones as $milestone) {
                $businessHasDefault              = new BusinessHasDefault;
                $businessHasDefault->business_id = $businessListing->id;
                $businessHasDefault->default_id  = $milestone;
                $businessHasDefault->save();
            }
        }

        BusinessHasDefault::select('business_has_defaults.*')->join('defaults', 'defaults.id', '=', 'business_has_defaults.default_id')->where('defaults.type', 'stage_of_business')->where('business_has_defaults.business_id', $businessListing->id)->delete();

        if (!empty($businessStage)) {

            $businessHasDefault              = new BusinessHasDefault;
            $businessHasDefault->business_id = $businessListing->id;
            $businessHasDefault->default_id  = $businessStage;
            $businessHasDefault->save();

        }

    }

    public function saveFundingRequirement($businessListing, $submitData)
    {
        $notSureRaise           = (isset($submitData['not-sure-raise'])) ? $submitData['not-sure-raise'] : '0';
        $notCalculatedShare     = (isset($submitData['not-calculated-share'])) ? $submitData['not-calculated-share'] : '0';
        $noofsharesissue        = (isset($submitData['no-of-shares-issue'])) ? $submitData['no-of-shares-issue'] : '';
        $noofnewsharesissue     = (isset($submitData['no-of-new-shares-issue'])) ? $submitData['no-of-new-shares-issue'] : '';
        $sharepricecurrinvround = (isset($submitData['share-price-curr-inv-round'])) ? $submitData['share-price-curr-inv-round'] : '';
        $shareclassissued       = (isset($submitData['share-class-issued'])) ? $submitData['share-class-issued'] : '';
        $nominalvalueshare      = (isset($submitData['nominal-value-share'])) ? $submitData['nominal-value-share'] : '';

        $data = ['no-of-shares-issue' => $noofsharesissue, 'no-of-new-shares-issue' => $noofnewsharesissue, 'share-price-curr-inv-round' => $sharepricecurrinvround, 'share-class-issued' => $shareclassissued, 'nominal-value-share' => $nominalvalueshare, 'not-sure-raise' => $notSureRaise, 'not-calculated-share' => $notCalculatedShare, 'investment-sought' => $submitData['investment-sought'], 'minimum-investment' => $submitData['minimum-investment'], 'minimum-raise' => $submitData['minimum-raise'], 'post-money-valuation' => $submitData['post-money-valuation'], 'pre-money-valuation' => $submitData['pre-money-valuation'], 'percentage-giveaway' => $submitData['percentage-giveaway'], 'deadline-subscription' => $submitData['deadline-subscription']];

        $data['use_of_funds'] = [];
        $amount               = $submitData['use_of_funds_amount'];
        foreach ($submitData['use_of_funds'] as $key => $useOfFunds) {
            $data['use_of_funds'][] = ['value' => $useOfFunds, 'amount' => $amount[$key]];
        }

        $fundingRequirement = $businessListing->getFundingRequirement();
        if (empty($fundingRequirement)) {
            $fundingRequirement              = new BusinessListingData;
            $fundingRequirement->business_id = $businessListing->id;
            $fundingRequirement->data_key    = 'funding_requirement';
        }

        $fundingRequirement->data_value = serialize($data);
        $fundingRequirement->save();

        $businessListing->target_amount = $submitData['investment-sought'];
        $businessListing->save();

    }

    public function saveFinancials($businessListing, $submitData)
    {

        $data = ['revenue_year1' => $submitData['revenue_year1'], 'revenue_year2' => $submitData['revenue_year2'], 'revenue_year3' => $submitData['revenue_year3'], 'sale_year1' => $submitData['sale_year1'], 'sale_year2' => $submitData['sale_year2'], 'sale_year3' => $submitData['sale_year3'], 'expences_year1' => $submitData['expences_year1'], 'expences_year2' => $submitData['expences_year2'], 'expences_year3' => $submitData['expences_year3'], 'ebitda_year_1' => $submitData['ebitda_year_1'], 'ebitda_year_2' => $submitData['ebitda_year_2'], 'ebitda_year_3' => $submitData['ebitda_year_3']];

        $data['use_of_funds'] = [];
        $amount               = $submitData['use_of_funds_amount'];
        foreach ($submitData['use_of_funds'] as $key => $useOfFunds) {
            $data['use_of_funds'][] = ['value' => $useOfFunds, 'amount' => $amount[$key]];
        }

        $financials = $businessListing->getFinancials();
        if (empty($financials)) {
            $financials              = new BusinessListingData;
            $financials->business_id = $businessListing->id;
            $financials->data_key    = 'financials';
        }

        $financials->data_value = serialize($data);
        $financials->save();

    }

    public function getTeamMemberHtml(Request $request)
    {
        $requestData             = $request->all();
        $memberCounter           = $requestData['memberCounter'];
        $memberCount             = $memberCounter + 1;
        $businessListing         = new BusinessListing;
        $data['memberCount']     = $memberCount;
        $data['businessListing'] = $businessListing;

        $memberPicType = 'member_picture_' . $memberCount;
        $containerId   = 'member-picture-' . $memberCount;
        $pickFile      = 'mem-picfile-' . $memberCount;
        $imageCLass    = 'member-profile-picture-' . $memberCount;
        $postUrl       = url("upload-cropper-image");

        $memberHtml = View::make('frontend.entrepreneur.add-team-member-card')->with($data)->render();

        $cropModalData = ['objectType' => 'App\BusinessListing', 'objectId' => $businessListing->id, 'aspectRatio' => 1, 'heading' => 'Crop Profile Image', 'imageClass' => $imageCLass, 'minContainerWidth' => 450, 'minContainerHeight' => 200, 'displaySize' => 'medium_1x1', 'imageType' => $memberPicType];

        $cropModal = View::make('includes.crop-modal')->with($cropModalData)->render();

        $json_data = array(
            "memberHtml"  => $memberHtml,
            "memberCount" => $memberCount,
            "containerId" => $containerId,
            "pickFile"    => $pickFile,
            "imageCLass"  => $imageCLass,
            "postUrl"     => $postUrl,
            "cropModal"   => $cropModal,

        );

        return response()->json($json_data);
    }

    public function saveTeamMembers($businessListing, $submitData)
    {

        $memberCounter = $submitData['member_counter'];

        $data = [];
        if ($memberCounter > 1) {
            for ($i = 1; $i <= $memberCounter; $i++) {
                if (!isset($submitData['member_name_' . $i])) {
                    continue;
                }

                $memberData                        = [];
                $memberData['name']                = $submitData['member_name_' . $i];
                $memberData['position']            = $submitData['member_position_' . $i];
                $memberData['bio']                 = $submitData['member_bio_' . $i];
                $memberData['preinvestment']       = $submitData['member_preinvestment_' . $i];
                $memberData['postinvestment']      = $submitData['member_postinvestment_' . $i];
                $memberData['equitypreinvestment'] = $submitData['member_equitypreinvestment_' . $i];
                $croppedImageUrl                   = $submitData['cropped_image_url_' . $i];
                $memberImageUrl                    = $submitData['image_url_' . $i];

                // $memberData['member-name'] = $submitData['cropped_image_url_'.$i];
                if ($croppedImageUrl != '' && $croppedImageUrl != '-1') {
                    $memberImageUrl = updateModelImage($businessListing, $croppedImageUrl, 'team_member_picture', 'medium_1x1');
                }
                $memberData['picture'] = ($croppedImageUrl == '-1') ? '' : $memberImageUrl;

                $socialmediaLinkCounter = $submitData['socialmedia_link_counter_' . $i];
                $socialMediaLinks       = [];
                if ($socialmediaLinkCounter >= 1) {
                    for ($j = 1; $j <= $socialmediaLinkCounter; $j++) {
                        if (!isset($submitData['social_link_' . $i . '_' . $j])) {
                            continue;
                        }

                        $socialMediaLinks[] = ['social_link' => $submitData['social_link_' . $i . '_' . $j], 'link_type' => $submitData['link_type_' . $i . '_' . $j]];
                    }
                }

                $memberData['socialmedia-link'] = $socialMediaLinks;

                $data['team-members'][] = $memberData;
            }
        }

        $teamMemberDetails = $businessListing->getTeamMemberDetails();
        if (empty($teamMemberDetails)) {
            $teamMemberDetails              = new BusinessListingData;
            $teamMemberDetails->business_id = $businessListing->id;
            $teamMemberDetails->data_key    = 'team_members';
        }

        $teamMemberDetails->data_value = serialize($data);
        $teamMemberDetails->save();

    }

    public function saveCompanyDetails($businessListing, $submitData)
    {
        $data = ['number' => $submitData['detail_number'], 'type' => $submitData['detail_type'], 'telephone' => $submitData['detail_telephone'], 'sic2003' => $submitData['detail_sic2003'], 'typeofaccount' => $submitData['detail_typeofaccount'], 'latestannualreturns' => $submitData['detail_latestannualreturns'], 'nextannualreturnsdue' => $submitData['detail_nextannualreturnsdue'], 'latestannualaccounts' => $submitData['detail_latestannualaccounts'], 'nextannualaccountsdue' => $submitData['detail_nextannualaccountsdue'], 'tradingaddress' => $submitData['detail_tradingaddress'], 'incorporationdate' => $submitData['detail_incorporationdate'], 'sic2007' => $submitData['detail_sic2007']];

        $companyDetails = $businessListing->getCompanyDetails();
        if (empty($companyDetails)) {
            $companyDetails              = new BusinessListingData;
            $companyDetails->business_id = $businessListing->id;
            $companyDetails->data_key    = 'company_details';
        }

        $companyDetails->data_value = serialize($data);
        $companyDetails->save();

    }

    public function saveDocumentUpload($businessListing, $submitData)
    {
        $proposalsummaryoption  = (isset($submitData['proposalsummaryoption'])) ? $submitData['proposalsummaryoption'] : '';
        $primaryapplicationform = (isset($submitData['primaryapplicationform'])) ? $submitData['primaryapplicationform'] : '';
        $data                   = ['proposalsummaryoption' => $proposalsummaryoption, 'primaryapplicationform' => $primaryapplicationform];
        $documentUpload         = $businessListing->getDocumentUpload();
        if (empty($documentUpload)) {
            $documentUpload              = new BusinessListingData;
            $documentUpload->business_id = $businessListing->id;
            $documentUpload->data_key    = 'document_upload';
        }

        $documentUpload->data_value = serialize($data);
        $documentUpload->save();

        // dd($submitData);
        if (isset($submitData['proposal_summary']) && !empty($submitData['proposal_summary'])) {
            $this->updateUploadedFile($businessListing, $submitData['proposal_summary'], 'proposal_summary');
        }

        if (isset($submitData['generate_summary']) && !empty($submitData['generate_summary'])) {
            $this->updateUploadedFile($businessListing, $submitData['generate_summary'], 'generate_summary');
        }

        if (isset($submitData['information_memorandum']) && !empty($submitData['information_memorandum'])) {
            $this->updateUploadedFile($businessListing, $submitData['information_memorandum'], 'information_memorandum');
        }

        if (isset($submitData['kid_document']) && !empty($submitData['kid_document'])) {
            $this->updateUploadedFile($businessListing, $submitData['kid_document'], 'kid_document');
        }

        if (isset($submitData['application_form_1']) && !empty($submitData['application_form_1'])) {
            $this->updateUploadedFile($businessListing, $submitData['application_form_1'], 'application_form_1');
        }

        if (isset($submitData['application_form_2']) && !empty($submitData['application_form_2'])) {
            $this->updateUploadedFile($businessListing, $submitData['application_form_2'], 'application_form_2');
        }

        if (isset($submitData['application_form_3']) && !empty($submitData['application_form_3'])) {
            $this->updateUploadedFile($businessListing, $submitData['application_form_3'], 'application_form_3');
        }

        if (isset($submitData['presentation']) && !empty($submitData['presentation'])) {
            $this->updateUploadedFile($businessListing, $submitData['presentation'], 'presentation');
        }

        if (isset($submitData['financial_projection']) && !empty($submitData['financial_projection'])) {
            $this->updateUploadedFile($businessListing, $submitData['financial_projection'], 'financial_projection');
        }

        if (isset($submitData['public_file_path[]']) && !empty($submitData['public_file_path[]'])) {
            foreach ($submitData['public_file_path[]'] as $key => $publicFile) {
                $this->updateUploadedFile($businessListing, $publicFile, 'public_additional_documents');
            }

        }

        if (isset($submitData['private_file_path[]']) && !empty($submitData['private_file_path[]'])) {
            foreach ($submitData['private_file_path[]'] as $key => $publicFile) {
                $this->updateUploadedFile($businessListing, $publicFile, 'private_additional_documents');
            }

        }

    }

    public function deleteDocument($businessListing, $submitData)
    {
        // check if file is deleted
        $savedDocFileIds = [];
        $businessFiles   = $businessListing->getAllBusinessFile();
        if (!empty($businessFiles)) {
            foreach ($businessFiles as $fileType => $businessFile) {
                if (in_array($fileType, ['public_additional_documents', 'private_additional_documents'])) {
                    $savedDocFileIds[] = $businessFile['id'];

                    continue;
                }

                if (!isset($submitData[$fileType . '_url'])) {
                    $fileId = $businessFile['id'];
                    $businessListing->unmapFile($fileId);
                }
            }
        }

        //multiple file delete by id not exist
        // check if submitted file ids exist in saved ids if not unmap
        $publicAdditionalDocumentsIds  = (isset($submitData['public_additional_documents_file_id'])) ? $submitData['public_additional_documents_file_id'] : [];
        $privateAdditionalDocumentsIds = (isset($submitData['private_additional_documents_file_id'])) ? $submitData['private_additional_documents_file_id'] : [];
        $outputFileIds                 = array_merge($publicAdditionalDocumentsIds, $privateAdditionalDocumentsIds);

        foreach ($savedDocFileIds as $key => $fileId) {
            if (!in_array($fileId, $outputFileIds)) {
                $businessListing->unmapFile($fileId);
            }
        }
    }

    public function saveDueDeligence($businessListing, $submitData)
    {

        $primaryplatformduediligence = (isset($submitData['primaryplatformduediligence'])) ? $submitData['primaryplatformduediligence'] : '';
        $data                        = ['desc_diligencereportsintro' => $submitData['desc_diligencereportsintro'], 'primaryplatformduediligence' => $primaryplatformduediligence];

        $hardmanCounter     = $submitData['hardman-counter'];
        $taxEffectCounter   = $submitData['tax-efficient-review-counter'];
        $allenbridgeCounter = $submitData['allenbridge-counter'];
        $micapCounter       = $submitData['micap-counter'];
        $allStreetCounter   = $submitData['all-street-counter'];

        $data['hardman-links']              = $this->generateExternalLinks($hardmanCounter, 'hardman', $submitData);
        $data['tax-efficient-review-links'] = $this->generateExternalLinks($taxEffectCounter, 'tax-efficient-review', $submitData);
        $data['allenbridge-links']          = $this->generateExternalLinks($allenbridgeCounter, 'allenbridge', $submitData);
        $data['micap-links']                = $this->generateExternalLinks($micapCounter, 'micap', $submitData);
        $data['all-street-links']           = $this->generateExternalLinks($allStreetCounter, 'all-street', $submitData);

        $dueDeligence = $businessListing->getDueDeligence();
        if (empty($dueDeligence)) {
            $dueDeligence              = new BusinessListingData;
            $dueDeligence->business_id = $businessListing->id;
            $dueDeligence->data_key    = 'due_deligence';
        }

        $dueDeligence->data_value = serialize($data);
        $dueDeligence->save();

        if (isset($submitData['due_deligence_report']) && !empty($submitData['due_deligence_report'])) {
            $this->updateUploadedFile($businessListing, $submitData['due_deligence_report'], 'due_deligence_report');
        }

        if (isset($submitData['hardman_document']) && !empty($submitData['hardman_document'])) {
            $this->updateUploadedFile($businessListing, $submitData['hardman_document'], 'hardman_document');
        }

        if (isset($submitData['tax_efficient_review']) && !empty($submitData['tax_efficient_review'])) {
            $this->updateUploadedFile($businessListing, $submitData['tax_efficient_review'], 'tax_efficient_review');
        }

        if (isset($submitData['allenbridge']) && !empty($submitData['allenbridge'])) {
            $this->updateUploadedFile($businessListing, $submitData['allenbridge'], 'allenbridge');
        }

        if (isset($submitData['micap']) && !empty($submitData['micap'])) {
            $this->updateUploadedFile($businessListing, $submitData['micap'], 'micap');
        }

        if (isset($submitData['all_street']) && !empty($submitData['all_street'])) {
            $this->updateUploadedFile($businessListing, $submitData['all_street'], 'all_street');
        }

    }

    public function generateExternalLinks($counter, $type, $submitData)
    {

        $data = [];
        if ($counter >= 1) {
            for ($i = 1; $i <= $counter; $i++) {
                if (!isset($submitData[$type . '_title_' . $i])) {
                    continue;
                }

                $data[] = ['name' => $submitData[$type . '_title_' . $i], 'url' => $submitData[$type . '_path_' . $i]];
            }
        }

        return $data;
    }

    public function updateUploadedFile($object, $file, $type)
    {
        $source   = pathinfo($file);
        $basename = $source['basename'];

        $currentPath  = public_path() . '/uploads/tmp/' . $basename;
        $uploadedFile = new UploadedFile($currentPath, $basename);

        if (in_array($type, ['public_additional_documents', 'private_additional_documents'])) {
            $id = $object->uploadFile($uploadedFile, false, $basename);
            $object->mapFile($id, $type);
        } else {
            $id = $object->uploadFile($uploadedFile, false, $basename);
            $object->remapFiles([$id], $type);
        }

        //delete temp file
        if (File::exists($file)) {
            File::delete($file);
        }
    }

    public function saveImageVideo($businessListing, $submitData)
    {
        $logoImageUrl       = $submitData['logo_cropped_image_url'];
        $backgroundImageUrl = $submitData['background_cropped_image_url'];

        // $memberData['member-name'] = $submitData['cropped_image_url_'.$i];
        if ($logoImageUrl != '' && $logoImageUrl != '-1') {
            $memberImageUrl = updateModelImage($businessListing, $logoImageUrl, 'business_logo', 'medium_1x1');
        }

        if ($logoImageUrl == '-1') {
            $profilePicImages = $businessListing->getImages('business_logo');
            foreach ($profilePicImages as $key => $profilePicImage) {
                $fileId = $profilePicImage['id'];
                $businessListing->unmapImage($fileId);
            }
        }

        if ($backgroundImageUrl != '' && $backgroundImageUrl != '-1') {
            $memberImageUrl = updateModelImage($businessListing, $backgroundImageUrl, 'business_background_image', 'medium_2_58x1');
        }

        if ($backgroundImageUrl == '-1') {
            $profilePicImages = $businessListing->getImages('business_background_image');
            foreach ($profilePicImages as $key => $profilePicImage) {
                $fileId = $profilePicImage['id'];
                $businessListing->unmapImage($fileId);
            }
        }

        $videoCounter = $submitData['video_counter'];
        if ($videoCounter >= 1) {
            $businessListing->businessVideos()->delete();

            for ($i = 1; $i <= $videoCounter; $i++) {
                if (isset($submitData['video_name_' . $i])) {
                    $videoName = $submitData['video_name_' . $i];
                    $embedCode = $submitData['embed_code_' . $i];
                    $feedback  = $submitData['feedback_' . $i];

                    $businessVideo                = new BusinessVideo;
                    $businessVideo->business_id   = $businessListing->id;
                    $businessVideo->name          = $videoName;
                    $businessVideo->embed_code    = $embedCode;
                    $businessVideo->is_pitchevent = $feedback;
                    $businessVideo->save();

                }

            }
        }

    }

    public function generateBusinessProposalPdf($giCode)
    {
        $businessListing = BusinessListing::where('gi_code', $giCode)->first();

        if (empty($businessListing)) {
            abort(404);
        }

        $businessPdf = new BusinessPdfHtml();

        $html = $businessPdf->getBusinessProposalHtml($businessListing);
        // echo $html; exit;

        $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', array(5, 5, 5, 5));
        $html2pdf->pdf->SetDisplayMode('fullpage');

        $html2pdf->writeHTML($html);
        $html2pdf->output();

        return true;

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
