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
use View;

class ActivityController extends Controller
{

    public function activitySummary(Request $request)
    {
        $requestFilters = $request->all();

        $breadcrumbs    = [];
        $breadcrumbs[]  = ['url' => url('/backoffice/dashboard'), 'name' => "Dashboard"];
        $breadcrumbs[]  = ['url' => '', 'name' => 'Activity Analysis'];
        $activityGroups = ActivityGroup::where('deleted', '0')->get();
        $firmsList      = getModelList('App\Firm', [], 0, 0, ['name' => 'asc']);
        $firms          = $firmsList['list'];

        $user           = new User;
        $backofficeUser = $user->backofficeUsers();

        $groupActivities = [];
        foreach ($activityGroups as $key => $activityGroup) {
            $groupActivities[$activityGroup->group_name] = $activityGroup->activity_type_value;
        }

        $businessListing          = BusinessListing::where('status', 'publish')->where('status', 'publish')->get();
        $data['businessListings'] = $businessListing;
        $data['activityTypes']    = activityTypeList();
        $data['durationType']     = durationType();
        $data['breadcrumbs']      = $breadcrumbs;
        $data['requestFilters']   = $requestFilters;
        $data['activityGroups']   = $activityGroups;
        $data['groupActivities']  = $groupActivities;
        $data['backofficeUsers']  = $backofficeUser;
        $data['firms']            = $firms;
        $data['pageTitle']        = 'View Activity';
        $data['activeMenu']       = 'activity';

        return view('backoffice.activity.view')->with($data);

    }
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
            '1'  => 'itemname',
            '2'  => 'username',
            '4'  => 'firm',
            '5'  => 'gi_code',
            '6'  => 'email',
            '7'  => 'telephone',
            '9'  => 'date_recorded',
            '10' => 'activitytype',
        );

        $columnName = 'date_recorded';
        $orderBy    = 'desc';

        if (isset($columnOrder[$orderValue['column']])) {
            $columnName = $columnOrder[$orderValue['column']];
            $orderBy    = $orderValue['dir'];
        }

        $orderDataBy = [$columnName => $orderBy];

        $filterActivityListing = $this->getFilteredActivityListing('list', $filters, $skip, $length, $orderDataBy);

        $activityListings      = $filterActivityListing['list'];
        $totalActivityListings = $filterActivityListing['totalActivityListings'];

        $activityListingData = [];
        $activityTypeList    = activityTypeList();
        $userObj             = [];

        foreach ($activityListings as $key => $activityListing) {
            if (isset($userObj[$activityListing->user_id])) {
                $user = $userObj[$activityListing->user_id];
            } else {
                $user                               = User::find($activityListing->user_id);
                $userObj[$activityListing->user_id] = $user;
            }
            $userType = (!empty($user) && !empty($user->roles())) ? title_case($user->roles()->pluck('display_name')->implode(' ')) : '';

            $activityId[$activityListing->id] = $activityListing->id;
            $userActivity                     = Activity::find($activityListing->id);
            $activityMeta                     = (!empty($userActivity->meta()->first())) ? $userActivity->meta()->first()->meta_value : '';

            if (isset($activityTypeList[$activityListing->type])) {
                $activity = $activityTypeList[$activityListing->type];

                if ($activityListing->type == 'certification' && !empty($activityMeta)) {
                    $activity .= ' ' . title_case($activityMeta['certification']);
                }
            } else {
                $activity = '';
            }
            $activityListingData[] = [
                'logo'           => '',
                'proposal_funds' => title_case($activityListing->itemname),
                'user'           => (!empty($activityListing->username)) ? title_case($activityListing->username) : '',
                'user_type'      => $userType,
                'firm'           => (!empty($activityListing->firmname)) ? title_case($activityListing->firmname) : '',
                'gi_code'        => (!empty($activityListing->gi_platform_code)) ? strtoupper($activityListing->gi_platform_code) : '',
                'email'          => (!empty($activityListing->email)) ? $activityListing->email : '',
                'telephone'      => (!empty($user)) ? title_case($user->telephone_no) : '',
                'description'    => (isset($activityMeta['amount invested'])) ? $activityMeta['amount invested'] : '',
                'date'           => (!empty($activityListing->date_recorded)) ? date('d/m/Y H:i:s', strtotime($activityListing->date_recorded)) : '',
                'activity'       => $activity,

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

    public function getActivitySummary(Request $request)
    {

        $filters = $request->all();

        if (isset($filters['duration']) && $filters['duration'] != "") {
            $durationDates = getDateByPeriod($filters['duration']);
            $fromDate      = $durationDates['fromDate'];
            $toDate        = $durationDates['toDate'];
        }

        if ((isset($filters['duration_from']) && $filters['duration_from'] != "") && (isset($filters['duration_to']) && $filters['duration_to'] != "")) {
            $fromDate = date('Y-m-d', strtotime($filters['duration_from']));
            $toDate   = date('Y-m-d', strtotime($filters['duration_to']));
        }

        $isTypeInWhere     = false;
        $activityGroupName = '';
        if (isset($filters['activity_group']) && $filters['activity_group'] != "") {

            $activityGroup     = ActivityGroup::find($filters['activity_group']);
            $activityGroupName = $activityGroup->group_name;

        }

        $columnName            = 'date_recorded';
        $orderBy               = 'desc';
        $orderDataBy           = [$columnName => $orderBy];
        $filterActivityListing = $this->getFilteredActivityListing('summary', $filters, 0, 0, $orderDataBy);

        $groupActs        = $this->getActivitiesByGroup();
        $finalarr         = array();
        $activityTypeList = activityTypeList();
        $activityLogs     = $filterActivityListing['list'];

        $ckIfAddedToList = [];
        foreach ($activityLogs as $activityLog) {
            if (array_key_exists($activityLog->type, $activityTypeList)) {

                $groupname = (!isset($groupActs[$activityLog->type]) || $groupActs[$activityLog->type] == "") ? "Others" : $groupActs[$activityLog->type];

                if ($activityGroupName == $groupname || $activityGroupName == '') {
                    $typetitle                           = $activityTypeList[$activityLog->type];
                    $ckIfAddedToList[$activityLog->type] = $activityLog->type;
                    $finalarr[]                          = array('typetitle' => $typetitle,
                        'type'                                                   => $activityLog->type,
                        'count'                                                  => $activityLog->count,
                        'typetitle_count'                                        => $typetitle . ' (' . $activityLog->count . ')',
                        'group_name'                                             => $groupname,
                    );
                }

            }
        }

        /**
         * [$typetitle is array of activities]
         * code to add entries for zero activity type
         */

        foreach ($activityTypeList as $typetitlekey => $typetitlevalue) {

            if (!isset($ckIfAddedToList[$typetitlekey])) {

                $groupname1 = (!isset($groupActs[$typetitlekey]) || $groupActs[$typetitlekey] == "") ? "Others" : $groupActs[$typetitlekey];
                if ($activityGroupName == $groupname1 || $activityGroupName == '') {
                    $ckIfAddedToList[$typetitlekey] = $typetitlekey;
                    $finalarr[]                     = array(
                        'typetitle'       => $typetitlevalue,
                        'type'            => $typetitlekey,
                        'count'           => 0,
                        'typetitle_count' => $typetitlevalue . '(0)',
                        'group_name'      => (!isset($groupActs[$typetitlekey]) || $groupActs[$typetitlekey] == "") ? "Others" : $groupActs[$typetitlekey],
                    );
                }

            }
        }
        asort($finalarr);
        $activityCountSummary = array_values($finalarr);

        $dataProvider = [];
        $graphs       = [];
        $countData    = [];
        foreach ($activityCountSummary as $activityCount) {
            if (isset($countData[$activityCount['group_name']])) {
                $countData[$activityCount['group_name']] += $activityCount['count'];
            } else {
                $countData[$activityCount['group_name']] = $activityCount['count'];
            }

            if ($activityCount['count'] > 0) {
                $dataProvider[] = ['activity' => $activityCount['typetitle_count'], 'count' => $activityCount['count']];
            }

        }

        $graphs[] = ['balloonText' => '<span style=\'font-size:13px;\'>[[title]] in [[category]]:<b>[[value]]</b></span>',
            'title'                    => 'Count',
            'type'                     => 'column',
            'fillAlphas'               => 0.8,
            'valueField'               => 'count',
        ];

        $activityCountSummaryView = View::make('backoffice.activity.activity-group-count', compact('countData'))->render();

        $json_data = array(
            "activityCountSummaryView" => $activityCountSummaryView,
            "dataProvider"             => json_encode($dataProvider, true),
            "graphs"                   => json_encode($graphs),
            "fromDate"                 => $fromDate,
            "toDate"                   => $toDate,
        );

        return response()->json($json_data);

    }

    public function getActivitiesByGroup()
    {
        $activitiesWithGroup = [];
        $activityGroups      = ActivityGroup::where('deleted', 0)->get();
        foreach ($activityGroups as $key => $activityGroup) {
            $activities2 = $activityGroup->activity_type_value;

            if (!empty($activities2)) {
                foreach ($activities2 as $key2 => $value2) {
                    $activitiesWithGroup[$value2] = $activityGroup->group_name;
                }

            }
        }

        return $activitiesWithGroup;
    }

    public function getFilteredActivityListing($type, $filters, $skip, $length, $orderDataBy)
    {

        $whereStr         = '';
        $firmWhere        = '';
        $userWhere        = '';
        $parentChildFirms = '';
        $companyWhere     = '';
        $compWhere        = '';
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

        $isTypeInWhere = false;
        if (isset($filters['activity_group']) && $filters['activity_group'] != "") {

            $activityGroup = ActivityGroup::find($filters['activity_group']);
            if (!empty($activityGroup)) {
                $actTypes = $activityGroup->activity_type_value;
                if (isset($filters['type']) && $filters['type'] != "") {
                    $actTypes[]    = $filters['type'];
                    $isTypeInWhere = true;
                }
                $typeStr .= (!empty($actTypes)) ? " and a1.type IN ('" . implode("','", $actTypes) . "')" : '';
            }

        }

        if (isset($filters['type']) && $filters['type'] != "" && !$isTypeInWhere) {
            $typeStr .= " and a1.type = '" . $filters['type'] . "'";
        }

        if (isset($filters['firmid']) && $filters['firmid'] != "") {
            $firmWhere = " and a1.secondary_item_id=" . $filters['firmid'];
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
        //group required activity togather
        $groupTypeList = (!empty($typeLists)) ? groupTypeList($typeLists) : [];

        $count                 = 0;
        $union                 = '';
        $activityListQuery     = '';
        $totalActivityListings = 0;
        $activityListings      = [];

        $queryCheck = [];
        if (!empty($groupTypeList)) {

            foreach ($groupTypeList as $typeList) {
                $activityType = $typeList[0];

                if ($count != 0) {
                    $union = " union ";
                }

                if ($type == 'list') {
                    $mainselect = "select a1.gi_platform_code,a1.id,a1.component,a1.type,a1.type as activitytype,a1.action,a1.content,a1.primary_link,f1.name as firmname,a1.secondary_item_id";
                } else {
                    $mainselect = "select count(*) as count,a1.type as type ";
                }

                $maintable = " from activity a1 ";
                $mainjoin  = " INNER JOIN firms f1 on f1.id=a1.secondary_item_id";

                if (in_array($activityType, ['nominee_application', 'onfido_requested', 'onfido_confirmed', 'certification', 'registration', 'stage1_investor_registration', 'entrepreneur_account_registration', 'fundmanager_account_registration', 'successful_logins', 'download_client_registration_guide',
                    'download_investor_csv', 'download_transfer_asset_guide',
                    'download_vct_asset_transfer_form', 'download_single_company_asset_transfer_form', 'download_iht_product_asset_transfer_form', 'download_portfolio_asset_transfer_form', 'download_stock_transfer_form', 'submitted_transfers',
                    'status_changes_for_asset_transfers', 'transfers_deleted',
                    'start_adobe_sign', 'completed_adobe_sign',
                    'external_downloads', 'stage_3_profile_details',
                    'auth_fail', 'cash_withdrawl', 'cash_deposits'])) {

                    $customfieldselect = ($type == 'list') ? " ,a1.item_id as user_id,'' as itemname,CONCAT(u1.first_name,' ',u1.last_name) as username ,u1.email as email ,'' as itemid,a1.date_recorded as date_recorded,'' as item_slug" : '';
                    $customjoin        = " LEFT OUTER JOIN users u1 on u1.ID=a1.item_id ";
                    $customwhere       = $parentChildFirms;
                    //overide the condition
                    if (isset($filters['user_id']) && $filters['user_id'] != "") {
                        $userWhere = " and a1.item_id='" . $filters['user_id'] . "' ";
                    }

                    if (isset($filters['exclude_platform_admin_activity']) && $filters['exclude_platform_admin_activity'] == "1") {
                        $excludeUserIds = User::permission('manage_options')->pluck('id')->toArray();
                        $userWhere .= " and a1.item_id NOT IN (" . implode(",", $excludeUserIds) . ")";
                    }

                    $mainjoin  = " LEFT OUTER JOIN firms f1 on f1.id=a1.secondary_item_id";
                    $mainwhere = " where a1.type IN ('" . implode("','", $typeList) . "') " . $userWhere . $whereStr . $firmWhere;
                    $groupby   = ($type == 'list') ? "" : "group by a1.type";

                } elseif (in_array($activityType, ['new_provider_added'])) {

                    $customfieldselect = ($type == 'list') ? " ,a1.item_id as user_id,'' as itemname,CONCAT(u1.first_name,' ',u1.last_name) as username ,u1.email as email ,'' as itemid,a1.date_recorded as date_recorded,'' as item_slug" : '';
                    $customjoin        = " INNER JOIN users u1 on u1.id=a1.user_id";
                    $customwhere       = $parentChildFirms;
                    //overide the condition
                    if (isset($filters['user_id']) && $filters['user_id'] != "") {
                        $userWhere = " and a1.item_id='" . $filters['user_id'] . "' ";
                    }
                    if (isset($filters['exclude_platform_admin_activity']) && $filters['exclude_platform_admin_activity'] == "1") {
                        $excludeUserIds = User::permission('manage_options')->pluck('id')->toArray();
                        $userWhere .= " and a1.item_id NOT IN (" . implode(",", $excludeUserIds) . ")";
                    }

                    $mainwhere = " where a1.type IN ('" . implode("','", $typeList) . "') " . $userWhere . $whereStr . $firmWhere;
                    $groupby   = ($type == 'list') ? "" : "group by a1.type";

                } elseif (in_array($activityType, ['investor_message', 'entrepreneur_message'])) {

                    $customfieldselect = ($type == 'list') ? " ,a1.user_id as user_id,CONCAT(u1.first_name,' ',u1.last_name) as itemname,CONCAT(u2.first_name,' ',u2.last_name) as username ,u2.email as email,a1.item_id as itemid ,a1.date_recorded as date_recorded,'' as item_slug" : '';
                    $customjoin        = " INNER JOIN users u1 on u1.id=a1.item_id INNER JOIN users u2 on u2.id=a1.user_id";
                    $customwhere       = $parentChildFirms;

                    //overide the condition
                    if (isset($filters['user_id']) && $filters['user_id'] != "") {
                        $userWhere = " and a1.item_id='" . $filters['user_id'] . "' ";
                    }
                    if (isset($filters['exclude_platform_admin_activity']) && $filters['exclude_platform_admin_activity'] == "1") {
                        $excludeUserIds = User::permission('manage_options')->pluck('id')->toArray();
                        $userWhere .= " and a1.item_id NOT IN (" . implode(",", $excludeUserIds) . ")";
                    }

                    $mainwhere = " where a1.type IN ('" . implode("','", $typeList) . "') " . $userWhere . $whereStr . $firmWhere;
                    $groupby   = ($type == 'list') ? "" : "group by a1.type";

                } elseif (in_array($activityType, ['proposal_details_update', 'fund_details_update'])) {

                    $customfieldselect = ($type == 'list') ? " ,a1.user_id as user_id,p1.title as itemname,CONCAT(u1.first_name,' ',u1.last_name) as username ,u1.email as email,a1.item_id as itemid,max(a1.date_recorded) as date_recorded,p1.slug as item_slug" : '';
                    $customjoin        = " INNER JOIN  users u1 on u1.id=a1.user_id INNER JOIN business_listings p1 on p1.id=a1.item_id";
                    $customwhere       = $parentChildFirms;

                    //overide the condition
                    if (isset($filters['user_id']) && $filters['user_id'] != "") {
                        $userWhere = " and a1.user_id='" . $filters['user_id'] . "' ";
                    }
                    if (isset($filters['exclude_platform_admin_activity']) && $filters['exclude_platform_admin_activity'] == "1") {
                        $excludeUserIds = User::permission('manage_options')->pluck('id')->toArray();
                        $userWhere .= " and a1.user_id NOT IN (" . implode(",", $excludeUserIds) . ")";
                    }

                    if (isset($filters['companies']) && $filters['companies'] != "") {
                        $companyWhere = " and a1.item_id='" . $filters['companies'] . "' ";
                    }

                    $mainwhere = " where a1.type IN ('" . implode("','", $typeList) . "') " . $userWhere . $companyWhere . $whereStr . $firmWhere;
                    $groupby   = ($type == 'list') ? " group by a1.component,a1.type,date(a1.date_recorded),a1.secondary_item_id,a1.user_id,a1.item_id" : "group by a1.type";
                } elseif (in_array($activityType, ['invested'])) {

                    $customfieldselect = ($type == 'list') ? " ,a1.user_id as user_id,p1.title as itemname,CONCAT(u1.first_name,' ',u1.last_name) as username ,u1.email as email,a1.item_id as itemid,a1.date_recorded as date_recorded,p1.slug as item_slug" : '';
                    $customjoin        = " LEFT JOIN users u1 on u1.id=a1.user_id
                             LEFT JOIN business_listings p1 on p1.id=a1.item_id";
                    $customwhere = $parentChildFirms;

                    //overide the condition
                    if (isset($filters['user_id']) && $filters['user_id'] != "") {
                        $userWhere = " and a1.user_id='" . $filters['user_id'] . "' ";
                    }

                    if (isset($filters['exclude_platform_admin_activity']) && $filters['exclude_platform_admin_activity'] == "1") {
                        $excludeUserIds = User::permission('manage_options')->pluck('id')->toArray();
                        $userWhere .= " and a1.user_id NOT IN (" . implode(",", $excludeUserIds) . ")";
                    }

                    if (isset($filters['companies']) && $filters['companies'] != "") {
                        $companyWhere = " and a1.item_id='" . $filters['companies'] . "' ";
                    }

                    $mainwhere = " where a1.type IN ('" . implode("','", $typeList) . "') " . $userWhere . $companyWhere . $whereStr . $firmWhere;
                    $groupby   = ($type == 'list') ? "" : "group by a1.type";
                } else {

                    $customfieldselect = ($type == 'list') ? " ,a1.user_id as user_id,p1.title as itemname,CONCAT(u1.first_name,' ',u1.last_name) as username ,u1.email as email,a1.item_id as itemid,a1.date_recorded as date_recorded,p1.slug as item_slug" : '';
                    $customjoin        = " INNER JOIN users u1 on u1.id=a1.user_id INNER JOIN business_listings p1 on p1.id=a1.item_id";
                    $customwhere       = $parentChildFirms;

                    //overide the condition
                    if (isset($filters['user_id']) && $filters['user_id'] != "") {
                        $userwhere = " and a1.user_id='" . $filters['user_id'] . "' ";
                    }

                    if (isset($filters['exclude_platform_admin_activity']) && $filters['exclude_platform_admin_activity'] == "1") {
                        $excludeUserIds = User::permission('manage_options')->pluck('id')->toArray();
                        $userWhere .= " and a1.user_id NOT IN (" . implode(",", $excludeUserIds) . ")";
                    }

                    if (isset($filters['companies']) && $filters['companies'] != "") {
                        $companyWhere = " and a1.item_id='" . $filters['companies'] . "' ";
                    }

                    $mainwhere = " where a1.type IN ('" . implode("','", $typeList) . "') " . $userWhere . $companyWhere . $whereStr . $firmWhere;
                    $groupby   = ($type == 'list') ? "" : "group by a1.type";
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
        }

        return ['totalActivityListings' => $totalActivityListings, 'list' => $activityListings];

    }

    public function exportInvestorsActivity(Request $request)
    {

        $data    = [];
        $filters = $request->all();

        $columnName = 'activity.date_recorded';
        $orderBy    = 'desc';

        $orderDataBy = [$columnName => $orderBy];

        $filterActivityListing = $this->getFilteredActivityListing('list', $filters, 0, 0, $orderDataBy);
        $activityListings      = $filterActivityListing['list'];

        $fileName = 'all_investors_as_on_' . date('d-m-Y');
        $header   = ['Platform GI Code', 'Company', 'First Name', 'Last Name', 'Type of User', 'Activity Name', 'Date', 'Email', 'Telephone', 'Description'];
        $userData = [];

        $activityData     = [];
        $activityTypeList = activityTypeList();
        $userObj          = [];

        foreach ($activityListings as $key => $activityListing) {
            if (isset($userObj[$activityListing->user_id])) {
                $user = $userObj[$activityListing->user_id];
            } else {
                $user                               = User::find($activityListing->user_id);
                $userObj[$activityListing->user_id] = $user;
            }
            $userType = (!empty($user) && !empty($user->roles())) ? title_case($user->roles()->pluck('display_name')->implode(' ')) : '';

            $activityId[$activityListing->id] = $activityListing->id;
            $userActivity                     = Activity::find($activityListing->id);
            $activityMeta                     = (!empty($userActivity->meta()->first())) ? $userActivity->meta()->first()->meta_value : '';

            if (isset($activityTypeList[$activityListing->type])) {
                $activity = $activityTypeList[$activityListing->type];

                if ($activityListing->type == 'certification' && !empty($activityMeta)) {
                    $activity .= ' ' . title_case($activityMeta['certification']);
                }
            } else {
                $activity = '';
            }
            $activityListingData[] = [
                'logo'           => '',
                'proposal_funds' => title_case($activityListing->itemname),
                'user'           => (!empty($activityListing->username)) ? title_case($activityListing->username) : '',
                'user_type'      => $userType,
                'firm'           => (!empty($activityListing->firmname)) ? title_case($activityListing->firmname) : '',
                'gi_code'        => (!empty($activityListing->gi_platform_code)) ? strtoupper($activityListing->gi_platform_code) : '',
                'email'          => (!empty($activityListing->email)) ? $activityListing->email : '',
                'telephone'      => (!empty($user)) ? title_case($user->telephone_no) : '',
                'description'    => (isset($activityMeta['amount invested'])) ? $activityMeta['amount invested'] : '',
                'date'           => (!empty($activityListing->date_recorded)) ? date('d/m/Y H:i:s', strtotime($activityListing->date_recorded)) : '',
                'activity'       => $activity,

            ];

        }

        foreach ($activityListings as $key => $activityListing) {

            if (isset($userObj[$activityListing->user_id])) {
                $user = $userObj[$activityListing->user_id];
            } else {
                $user                               = User::find($activityListing->user_id);
                $userObj[$activityListing->user_id] = $user;
            }
            $firstName = '';
            $lastName  = '';

            $userName = $activityListing->username;
            if (trim($userName) != "") {
                $splitUserName = explode(' ', $userName);
                if (count($splitUserName) >= 2) {
                    list($firstName, $lastName) = $splitUserName;
                } else {
                    $firstName = $userName;
                }

            }

            $activityId[] = $activityListing->id;
            $userActivity = Activity::find($activityListing->id);

            // $certificationName = (!empty($user) && !empty($user->userCertification()) && !empty($user->getLastActiveCertification())) ? $user->getLastActiveCertification()->certification()->name : '';
            $userType     = (!empty($user) && !empty($user->roles())) ? title_case($user->roles()->pluck('display_name')->implode(' ')) : '';
            $activityMeta = (!empty($userActivity->meta()->first())) ? $userActivity->meta()->first()->meta_value : '';

            $activityData[] = [
                $activityListing->gi_platform_code,
                title_case($activityListing->itemname),
                title_case($firstName),
                title_case($lastName),
                $userType,
                (isset($activityTypeList[$activityListing->type])) ? $activityTypeList[$activityListing->type] : '',
                (!empty($activityListing->date_recorded)) ? date('d/m/Y H:i:s', strtotime($activityListing->date_recorded)) : '',
                $activityListing->email,
                (!empty($user)) ? $user->telephone_no : '',
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

        $filterActivityListing = $this->getFilteredActivityListing('list', $filters, 0, 0, $orderDataBy);
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

    public function getActivityGroupType(Request $request)
    {
        $activityGroupId = $request->get('type_id');
        $typeList        = activityTypeList();
        $group           = ActivityGroup::where('id', $activityGroupId)->first();
        $html            = '';
        if (!empty($group)) {
            $groupActivityType = $group->activity_type_value;
            foreach ($typeList as $typeId => $type) {
                $checked = (!empty($groupActivityType) && in_array($typeId, $groupActivityType)) ? 'checked' : '';

                $html .= '<li><input type="checkbox" class="" value="' . $typeId . '" id="ch_' . $typeId . '" ' . $checked . ' name="activity_types[]">
                                                  <label class="" for="ch_' . $typeId . '">' . $type . '</label></li>';
            }

        }

        return response()->json(['html' => $html]);
    }

    public function saveActivityGroupType(Request $request)
    {

        $activityGroupId  = $request->get('group_id');
        $activityTypesStr = $request->get('activity_types');
        $activityTypes    = explode(',', $activityTypesStr);
        $activityTypes    = array_filter($activityTypes);

        $group = ActivityGroup::find($activityGroupId);

        if (!empty($group)) {
            $success                    = true;
            $group->activity_type_value = $activityTypes;
            $group->save();

        } else {
            $success = false;
        }

        return response()->json(['success' => $success]);
    }
}
