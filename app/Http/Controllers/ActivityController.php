<?php

namespace App\Http\Controllers;

use App\Activity;
use App\ActivityGroup;
use App\BusinessListing;
use App\Firm;
use App\InvestorPdfHtml;
use App\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Spipu\Html2Pdf\Html2Pdf;

class ActivityController extends Controller
{
    public function investorActivity($giCode, Request $request)
    {
        $investor = User::where('gi_code', $giCode)->first();
        if (empty($investor)) {
            abort(404);
        }

        $requestFilters = $request->all();

        $breadcrumbs   = [];
        $breadcrumbs[] = ['url' => url('/backoffice/dashboard'), 'name' => "Dashboard"];
        $breadcrumbs[] = ['url' => url('/backoffice/investor'), 'name' => 'Manage Clients'];
        $breadcrumbs[] = ['url' => '', 'name' => 'Manage Investors'];
        $breadcrumbs[] = ['url' => '', 'name' => $investor->displayName()];
        $breadcrumbs[] = ['url' => '', 'name' => 'View Activity'];

        $businessListing          = BusinessListing::where('status', 'publish')->where('status', 'publish')->get();
        $data['businessListings'] = $businessListing;
        $data['activityTypes']    = activityTypeList();
        $data['durationType']     = durationType();
        $data['investor']         = $investor;
        $data['breadcrumbs']      = $breadcrumbs;
        $data['requestFilters']   = $requestFilters;
        $data['pageTitle']        = 'View Activity';
        $data['activeMenu']       = 'manage_clients';

        return view('backoffice.clients.investor-activity')->with($data);

    }

    public function getInvestorActivity(Request $request)
    {

        $requestData = $request->all(); //dd($requestData);
        $data        = [];
        $skip        = $requestData['start'];
        $length      = $requestData['length'];
        $orderValue  = $requestData['order'][0];
        $filters     = $requestData['filters'];

        $columnOrder = array(
            '2' => 'username',
            '4' => 'date_recorded',
            '5' => 'activitytype',
        );

        $columnName = 'date_recorded';
        $orderBy    = 'asc';

        if (isset($columnOrder[$orderValue['column']])) {
            $columnName = $columnOrder[$orderValue['column']];
            $orderBy    = $orderValue['dir'];
        }

        $orderDataBy = [$columnName => $orderBy];

        $filterActivityListing = $this->getFilteredActivityListing($filters, $skip, $length, $orderDataBy);
        $activityListings      = $filterActivityListing['list'];
        $totalActivityListings = $filterActivityListing['totalActivityListings'];

        $activityListingData = [];
        $activityTypeList    = activityTypeList();

        foreach ($activityListings as $key => $activityListing) {

            $activityId[$activityListing->id] = $activityListing->id;
            $userActivity                     = Activity::find($activityListing->id);
            $activityMeta                     = (!empty($userActivity->meta()->first())) ? $userActivity->meta()->first()->meta_value : '';

            $activityListingData[] = [
                'logo'           => '',
                'proposal_funds' => '',
                'user'           => (!empty($activityListing->username)) ? title_case($activityListing->username) : '',
                'description'    => (isset($activityMeta['amount invested'])) ? $activityMeta['amount invested'] : '',
                'date'           => (!empty($activityListing->date_recorded)) ? date('d/m/Y H:i:s', strtotime($activityListing->date_recorded)) : '',
                'activity'       => (isset($activityTypeList[$activityListing->type])) ? $activityTypeList[$activityListing->type] : '',

            ];

        }

        $json_data = array(
            "draw"            => intval($requestData['draw']),
            "recordsTotal"    => intval($totalActivityListings),
            "recordsFiltered" => intval($totalActivityListings),
            "data"            => $activityListingData,
        );

        return response()->json($json_data);

    }

    // public function getFilteredActivityListing($filters, $skip, $length, $orderDataBy){

    //     $activityListingQuery = Activity::select('*');

    //     // if (isset($filters['user_id']) && $filters['user_id'] != "") {
    //     //     $activityListingQuery->where('activity.user_id', $filters['user_id']);
    //     // }

    //     if (isset($filters['duration']) && $filters['duration'] != "") {
    //         $durationDates = getDateByPeriod($filters['duration']);
    //         $activityListingQuery->where(DB::raw('DATE_FORMAT(activity.date_recorded, "%Y-%m-%d")'),'>=', $durationDates['fromDate']);
    //         $activityListingQuery->where(DB::raw('DATE_FORMAT(activity.date_recorded, "%Y-%m-%d")'),'<=', $durationDates['toDate']);
    //     }

    //     if ((isset($filters['duration_from']) && $filters['duration_from'] != "") && (isset($filters['duration_to']) && $filters['duration_to'] != ""))  {
    //         $fromDate = date('Y-m-d',strtotime($filters['duration_from']));
    //         $toDate = date('Y-m-d',strtotime($filters['duration_to']));
    //         $activityListingQuery->where(DB::raw('DATE_FORMAT(activity.date_recorded, "%Y-%m-%d")'),'>=', $fromDate);
    //         $activityListingQuery->where(DB::raw('DATE_FORMAT(activity.date_recorded, "%Y-%m-%d")'),'<=', $toDate);
    //     }

    //     if (isset($filters['type']) && $filters['type'] != "") {
    //         $activityListingQuery->where('activity.type', $filters['type']);
    //     }

    //     if (isset($filters['companies']) && $filters['companies'] != "") {
    //         // $activityListingQuery->where('activity.type', $filters['companies']);
    //     }

    //     foreach ($orderDataBy as $columnName => $orderBy) {
    //         $activityListingQuery->orderBy($columnName, $orderBy);
    //     }

    //     if ($length > 1) {

    //         $totalActivityListings = $activityListingQuery->get()->count();
    //         $activityListings       = $activityListingQuery->skip($skip)->take($length)->get();
    //     } else {
    //         $activityListings       = $activityListingQuery->get();
    //         $totalActivityListings = $activityListingQuery->count();
    //     }

    //     return ['totalActivityListings' => $totalActivityListings, 'list' => $activityListings];

    // }

    public function getFilteredActivityListing($filters, $skip, $length, $orderDataBy)
    {

        $whereStr         = '';
        $firmWhere        = '';
        $userWhere        = '';
        $parentChildFirms = '';
        $companyWhere     = '';
        $mainjoin         = '';
        $typeStr          = '';

        if (isset($filters['duration']) && $filters['duration'] != "") {
            $durationDates = getDateByPeriod($filters['duration']);
            $whereStr .= " and DATE_FORMAT(a1.date_recorded, '%Y-%m-%d') >= '" . $durationDates['fromDate'] . "'";
            $whereStr .= " and DATE_FORMAT(a1.date_recorded, '%Y-%m-%d') <= '" . $durationDates['toDate'] . "'";

        }

        if ((isset($filters['duration_from']) && $filters['duration_from'] != "") && (isset($filters['duration_to']) && $filters['duration_to'] != "")) {
            $fromDate = date('Y-m-d', strtotime($filters['duration_from']));
            $toDate   = date('Y-m-d', strtotime($filters['duration_to']));
            $whereStr .= " and DATE_FORMAT(a1.date_recorded, '%Y-%m-%d') >= '" . $fromDate . "'";
            $whereStr .= " and DATE_FORMAT(a1.date_recorded, '%Y-%m-%d') <= '" . $toDate . "'";
        }

        if (isset($filters['type']) && $filters['type'] != "") {
            $typeStr .= " and a1.type = '" . $filters['type'] . "'";
        }

        if (Auth::user()->hasPermissionTo('site_level_activity_feed')) {
            $parentChildFirms = '';
        } else if (Auth::user()->hasPermissionTo('firm_level_activity_feed')) {
            $userFirm = Auth::user()->firm_id;
            $firms    = Firm::where('parent_id', $userFirm)->pluck('id')->toArray();
            $firms[]  = $userFirm;

            if (count($firms) > 0) {
                $firmIds          = implode(',', $firms);
                $parentChildFirms = " and a1.secondary_item_id in (" . $firmIds . ") ";
            }

        }

        if (!Auth::user()->hasPermissionTo('manage_options')) {
            if ($typewhere == "") {
                $actret = $this->actGroupCapability();

                if ($actret != "") {
                    $typewhere = " and " . $actret;
                } else {
                    return array();
                }

            }
        }

        foreach ($orderDataBy as $columnName => $orderBy) {
            $orderby = " order by " . $columnName . " " . $orderBy;
        }

        $typeLists = DB::select("select distinct type from activity a1 where 1 " . $whereStr . $typeStr);

        $count             = 0;
        $union             = '';
        $activityListQuery = '';

        $queryCheck = [];

        foreach ($typeLists as $typeList) {

            if ($typeList->type == "") {
                continue;
            }

            if ($count != 0) {
                $union = " union ";
            }

            $mainselect = "select a1.id,a1.component,a1.type,a1.type as activitytype,a1.action,a1.content,a1.primary_link,a1.secondary_item_id";
            $maintable  = " from activity a1 ";
            $mainjoin   = " INNER JOIN firms p2 on p2.ID=a1.secondary_item_id";

            if (in_array($typeList->type, ['nominee_application', 'onfido_requested', 'onfido_confirmed', 'certification', 'registration', 'stage1_investor_registration', 'entrepreneur_account_registration', 'fundmanager_account_registration', 'successful_logins', 'download_client_registration_guide',
                'download_investor_csv', 'download_transfer_asset_guide',
                'download_vct_asset_transfer_form', 'download_single_company_asset_transfer_form', 'download_iht_product_asset_transfer_form', 'download_portfolio_asset_transfer_form', 'download_stock_transfer_form', 'submitted_transfers',
                'status_changes_for_asset_transfers', 'transfers_deleted',
                'start_adobe_sign', 'completed_adobe_sign',
                'external_downloads', 'stage_3_profile_details',
                'auth_fail', 'cash_withdrawl', 'cash_deposits'])) {

                // if (isset($queryCheck['section1'])) {
                //     continue;
                // }

                // $queryCheck['section1'] = true;
                $customfieldselect = " ,a1.item_id as user_id,'' as itemname,CONCAT(u1.first_name,' ',u1.last_name) as username ,u1.email as email ,'' as itemid,a1.date_recorded as date_recorded,'' as item_slug";
                $customjoin        = " LEFT OUTER JOIN users u1 on u1.ID=a1.item_id ";
                $customwhere       = $parentChildFirms;
                //overide the condition
                if (isset($filters['user_id']) && $filters['user_id'] != "") {
                    $userWhere = " and a1.item_id='" . $filters['user_id'] . "' ";
                }

                $mainjoin  = " LEFT OUTER JOIN business_listings p2 on p2.ID=a1.secondary_item_id";
                $mainwhere = " where a1.type = '" . $typeList->type . "'" . $userWhere . $whereStr . $firmWhere;
                $groupby   = "";

            } elseif (in_array($typeList->type, ['new_provider_added'])) {
                // if (isset($queryCheck['section2'])) {
                //     continue;
                // }

                // $queryCheck['section2'] = true;

                $customfieldselect = " ,a1.item_id as user_id,'' as itemname,CONCAT(u1.first_name,' ',u1.last_name) as username ,u1.email as email ,'' as itemid,a1.date_recorded as date_recorded,'' as item_slug";
                $customjoin        = " INNER JOIN users u1 on u1.ID=a1.user_id";
                $customwhere       = $parentChildFirms;
                //overide the condition
                if (isset($filters['user_id']) && $filters['user_id'] != "") {
                    $userWhere = " and a1.item_id='" . $filters['user_id'] . "' ";
                }

                $mainwhere = " where a1.type = '" . $typeList->type . "'" . $userWhere . $whereStr . $firmWhere;
                $groupby   = "";
            } elseif (in_array($typeList->type, ['investor_message', 'entrepreneur_message'])) {
                // if (isset($queryCheck['section3'])) {
                //     continue;
                // }

                // $queryCheck['section3'] = true;

                $customfieldselect = " ,a1.user_id as user_id,CONCAT(u1.first_name,' ',u1.last_name) as itemname,CONCAT(u2.first_name,' ',u2.last_name) as username ,u2.email as email,a1.item_id as itemid ,a1.date_recorded as date_recorded,'' as item_slug";
                $customjoin        = " INNER JOIN users u1 on u1.ID=a1.item_id INNER JOIN users u2 on u2.ID=a1.user_id";
                $customwhere       = $parentChildFirms;

                //overide the condition
                if (isset($filters['user_id']) && $filters['user_id'] != "") {
                    $userWhere = " and a1.item_id='" . $filters['user_id'] . "' ";
                }

                $mainwhere = " where a1.type = '" . $typeList->type . "'" . $userWhere . $whereStr . $firmWhere;
                $groupby   = "";

            } elseif (in_array($typeList->type, ['proposal_details_update', 'fund_details_update'])) {
                // if (isset($queryCheck['section4'])) {
                //     continue;
                // }

                // $queryCheck['section4'] = true;

                $customfieldselect = " ,a1.user_id as user_id,p1.title as itemname,CONCAT(u1.first_name,' ',u1.last_name) as username ,u1.email as email,a1.item_id as itemid,max(a1.date_recorded) as date_recorded,p1.slug as item_slug";
                $customjoin        = " INNER JOIN  users u1 on u1.ID=a1.user_id INNER JOIN business_listings p1 on p1.ID=a1.item_id";
                $customwhere       = $parentChildFirms;

                //overide the condition
                if (isset($filters['user_id']) && $filters['user_id'] != "") {
                    $userWhere = " and a1.user_id='" . $filters['user_id'] . "' ";
                }

                if (isset($filters['companies']) && $filters['companies'] != "") {
                    $companyWhere = " and a1.item_id='" . $filters['companies'] . "' ";
                }

                $mainwhere = " where a1.type = '" . $typeList->type . "'" . $userWhere . $companyWhere . $whereStr . $firmWhere;
                $groupby   = " group by a1.component,a1.type,date(a1.date_recorded),a1.secondary_item_id,a1.user_id,a1.item_id";
            } elseif (in_array($typeList->type, ['invested'])) {
                // if (isset($queryCheck['section5'])) {
                //     continue;
                // }

                // $queryCheck['section5'] = true;

                $customfieldselect = " ,a1.user_id as user_id,p1.title as itemname,CONCAT(u1.first_name,' ',u1.last_name) as username ,u1.email as email,a1.item_id as itemid,a1.date_recorded as date_recorded,p1.slug as item_slug";
                $customjoin        = " LEFT JOIN users u1 on u1.ID=a1.user_id
                         LEFT JOIN business_listings p1 on p1.ID=a1.item_id";
                $customwhere = $parentChildFirms;

                //overide the condition
                if (isset($filters['user_id']) && $filters['user_id'] != "") {
                    $userWhere = " and a1.user_id='" . $filters['user_id'] . "' ";
                }

                if (isset($filters['companies']) && $filters['companies'] != "") {
                    $companyWhere = " and a1.item_id='" . $filters['companies'] . "' ";
                }

                $mainwhere = " where a1.type = '" . $typeList->type . "'" . $userWhere . $companyWhere . $whereStr . $firmWhere;
                $groupby   = "";
            } else {
                // if (isset($queryCheck['section6'])) {
                //     continue;
                // }

                // $queryCheck['section6'] = true;

                $customfieldselect = " ,a1.user_id as user_id,p1.title as itemname,CONCAT(u1.first_name,' ',u1.last_name) as username ,u1.email as email,a1.item_id as itemid,a1.date_recorded as date_recorded,p1.slug as item_slug";
                $customjoin        = " INNER JOIN users u1 on u1.ID=a1.user_id
                         INNER JOIN business_listings p1 on p1.ID=a1.item_id";
                $customwhere = $parentChildFirms;

                //overide the condition
                if (isset($filters['user_id']) && $filters['user_id'] != "") {
                    $userwhere = " and a1.user_id='" . $filters['user_id'] . "' ";
                }

                if (isset($filters['companies']) && $filters['companies'] != "") {
                    $companyWhere = " and a1.item_id='" . $filters['companies'] . "' ";
                }

                $mainwhere = " where a1.type = '" . $typeList->type . "'" . $userWhere . $companyWhere . $whereStr . $firmWhere;
                $groupby   = "";
            }

            $activityListQuery .= $union . $mainselect . $customfieldselect . $maintable . $mainjoin . $customjoin . $mainwhere . $customwhere . $groupby;

            $count++;

        }

        if ($length > 1) {
            $totalActivityListings = count(DB::select(DB::raw($activityListQuery)));
            $activityListQuery .= $orderby . " limit " . $skip . ", " . $length;
        } else {

            $totalActivityListings = count(DB::select(DB::raw($activityListQuery)));
        }

        $activityListings = DB::select(DB::raw($activityListQuery));

        return ['totalActivityListings' => $totalActivityListings, 'list' => $activityListings];

    }

    public function exportInvestorsActivity(Request $request)
    {

        $data    = [];
        $filters = $request->all();

        $columnName = 'activity.date_recorded';
        $orderBy    = 'asc';

        $orderDataBy = [$columnName => $orderBy];

        $filterActivityListing = $this->getFilteredActivityListing($filters, 0, 0, $orderDataBy);
        $activityListings      = $filterActivityListing['list'];

        $fileName = 'all_investors_as_on_' . date('d-m-Y');
        $header   = ['Platform GI Code', 'Company', 'First Name', 'Last Name', 'Type of User', 'Activity Name', 'Date', 'Email', 'Telephone', 'Description'];
        $userData = [];

        $activityData     = [];
        $activityTypeList = activityTypeList();

        foreach ($activityListings as $key => $activityListing) {

            $userName                   = $activityListing->username;
            $userName                   = explode(' ', $userName);
            list($firstName, $lastName) = $userName;

            $activityId[]      = $activityListing->id;
            $userActivity      = Activity::find($activityListing->id);
            $investor          = $userActivity->user;
            $certificationName = (!empty($investor) && !empty($investor->userCertification()) && !empty($investor->getLastActiveCertification())) ? $investor->getLastActiveCertification()->certification()->name : '';
            $activityMeta      = (!empty($userActivity->meta()->first())) ? $userActivity->meta()->first()->meta_value : '';

            $activityData[] = [
                (!empty($investor)) ? $investor->gi_code : '',
                '',
                title_case($firstName),
                title_case($lastName),
                $certificationName,
                (isset($activityTypeList[$activityListing->type])) ? $activityTypeList[$activityListing->type] : '',
                (!empty($activityListing->date_recorded)) ? date('d/m/Y H:i:s', strtotime($activityListing->date_recorded)) : '',
                (!empty($investor)) ? $investor->email : '',
                (!empty($investor)) ? $investor->telephone_no : '',
                (isset($activityMeta['amount invested'])) ? $activityMeta['amount invested'] : '',

            ];
        }

        generateCSV($header, $activityData, $fileName);

        return true;

    }

    public function generateInvestorsActivityPdf(Request $request)
    {
        $data    = [];
        $filters = $request->all();

        $columnName = 'activity.date_recorded';
        $orderBy    = 'asc';

        $orderDataBy = [$columnName => $orderBy];

        $filterActivityListing = $this->getFilteredActivityListing($filters, 0, 0, $orderDataBy);
        $activityListings      = $filterActivityListing['list'];

        $args                     = array();
        $header_footer_start_html = getHeaderPageMarkup($args);

        $investorPdf = new InvestorPdfHtml();

        $html = $investorPdf->getInvestorsActivityHtml($activityListings);
        // echo $html; exit;

        $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', array(5, 5, 5, 5));
        $html2pdf->pdf->SetDisplayMode('fullpage');

        $html2pdf->writeHTML($html);
        $html2pdf->output();

        return true;

    }

    public function actGroupCapability()
    {
        $groupList       = ActivityGroup::where('deleted', '0')->get();
        $finalarraygroup = array();
        $typewhere       = "";
        foreach ($groupList as $gvalue) {
            if (Auth::user()->hasPermissionTo($gvalue->capability)) {
                $gvaluearray = $gvalue->activity_type_value;
                if (is_array($gvaluearray)) {
                    $finalarraygroup = array_merge($finalarraygroup, $gvaluearray);
                }

            }
        }

        if (is_array($finalarraygroup)) {
            if (!empty($finalarraygroup)) {
                $typewhere = " type in ('" . implode("','", $finalarraygroup) . "')";
            }

        }
        return $typewhere;
    }

    public function manageActivityFeedGroup()
    {

        $groupList = ActivityGroup::where('deleted', '0')->get();
        
        $breadcrumbs             = [];
        $breadcrumbs[]           = ['url' => url('backoffice/dashboard'), 'name' => "Dashboard"];
        $breadcrumbs[]           = ['url' => '', 'name' => 'Activity Feed Group'];
        $data['groupList']       = $groupList;
        $data['breadcrumbs']     = $breadcrumbs;
        $data['pageTitle']       = 'Activity Feed Group';
        $data['page_short_desc'] = '';
        $data['activeMenu']      = 'manage-acttivyt-feedgroup';

        return view('backoffice.manage.activity-feed-group')->with($data);

    }

    public function getActivityGroupType(Request $request){
    	$activityGroupId = $request->get('type_id');
    	$typeList  = activityTypeList();
    	$group = ActivityGroup::where('id', $activityGroupId)->first();
    	$html = '';
    	if(!empty($group)){
    		$groupActivityType = $group->activity_type_value;
    		foreach ($typeList as $typeId => $type) {
    			$checked = (!empty($groupActivityType) && in_array($typeId, $groupActivityType)) ? 'checked' :'';
    			
    			$html .= '<li><input type="checkbox" class="" value="'.$typeId.'" id="ch_'.$typeId.'" '.$checked.' name="activity_types[]">
                                                  <label class="" for="ch_'.$typeId.'">'.$type.'</label></li>';	 
    		}

    	}
    	 
    	return response()->json(['html'=>$html]);
    }

    public function saveActivityGroupType(Request $request){

    	$activityGroupId = $request->get('group_id');
    	$activityTypesStr = $request->get('activity_types');
    	$activityTypes = explode(',', $activityTypesStr);
    	$activityTypes = array_filter($activityTypes); 

    	$group = ActivityGroup::find($activityGroupId);
    	 
    	if(!empty($group)){
    		$success = true;
    		$group->activity_type_value = $activityTypes;
    		$group->save();

    	}
    	else
    		$success = false;
    	
    	 
    	return response()->json(['success'=>$success]);
    }
}
