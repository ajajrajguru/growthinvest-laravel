<?php

namespace App\Http\Controllers;

use App\BusinessListing;
use Illuminate\Http\Request;

/* use App\Firm; */

class BusinessListingController extends Controller
{
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

        $filterEntrepreneurs = $this->getFilteredBusinessListings($filters, $skip, $length, $orderDataBy);
        $entrepreneurs       = $filterEntrepreneurs['list'];
        $totalEntrepreneurs  = $filterEntrepreneurs['TotalEntrepreneurs'];

        $entrepreneursData = [];

        foreach ($entrepreneurs as $key => $business_listing) {

            $name_html ="<b>".title_case($business_listing->title)."</b><br/>(".$business_listing->type.")
                                                <br/>
                                                ".(!empty($business_listing->owner) ? $business_listing->owner->email:'') ;
            $biz_status_display = implode(' ', array_map('ucfirst', explode('_', $business_listing->business_status)));  
            $actionHtml = $biz_status_display.'<br/><select data-id="" class="firm_actions" edit-url="#">
                                                <option>--select--</option>
                                                <option value="edit">View</option>
                                                </select>';

            
            
            $entrepreneursData[] = [
                'logo'              => '',
                'name'              => $name_html ,
                'duediligence'      => '',
                'created_date'      => date('d/m/Y', strtotime($business_listing->created_at)),
                'modified_date'     => date('d/m/Y', strtotime($business_listing->updated_at)),
                'firmtoraise'       => (!empty($business_listing->owner)?$business_listing->owner->firm['name']:'').'<br/>&pound'.$business_listing->target_amount,
                'activity_sitewide' => '',
                'activity_firmwide' => '',
                'action'            => $actionHtml,

            ];

        }

        $json_data = array(
            "draw"            => intval($requestData['draw']),
            "recordsTotal"    => intval($totalEntrepreneurs),
            "recordsFiltered" => intval($totalEntrepreneurs),
            "data"            => $entrepreneursData,
        );

        return response()->json($json_data);

    }

    public function getFilteredBusinessListings($filters = array(), $skip = 1, $length = 50, $orderDataBy = array())
    {

        $business_listings_query = BusinessListing::where(['status' => 'publish']);

        /*->where($cond)->select("users.*")*/

        /* $entrepreneurQuery = User::join('model_has_roles', function ($join) {
        $join->on('users.id', '=', 'model_has_roles.model_id')
        ->where('model_has_roles.model_type', 'App\User');
        })->join('roles', function ($join) {
        $join->on('model_has_roles.role_id', '=', 'roles.id')
        ->whereIn('roles.name', ['business_owner']);
        })->leftjoin('user_has_certifications', function ($join) {
        $join->on('users.id', 'user_has_certifications.user_id');
        });*/

        if (isset($filters['firm_name']) && $filters['firm_name'] != "") {
            $business_listings_query->where('business_listings.owner.firm.id', $filters['firm_name']);
        }

        /* if (isset($filters['user_ids']) && $filters['user_ids'] != "") {
        $userIds = explode(',', $filters['user_ids']);
        $userIds = array_filter($userIds);

        $entrepreneurQuery->whereIn('users.id', $userIds);
        }

        if (isset($filters['investor_name']) && $filters['investor_name'] != "") {
        $entrepreneurQuery->where('users.id', $filters['investor_name']);
        }*/

        /////////////////// $entrepreneurQuery->groupBy('users.id')->select('users.*');
        $business_listings_query->groupBy('business_listings.id')->select('business_listings.*');
        //$entrepreneurQuery->select(\DB::raw("GROUP_CONCAT(business_listings.title ) as business, users.*"));

        foreach ($orderDataBy as $columnName => $orderBy) {
            $business_listings_query->orderBy($columnName, $orderBy);
        }

        if ($length > 1) {

            $total_etrepreneurs = $business_listings_query->get()->count();
            $entrepreneurs      = $business_listings_query->skip($skip)->take($length)->get();
        } else {
            $entrepreneurs      = $business_listings_query->get();
            $total_etrepreneurs = $business_listings_query->count();
        }

        /*  echo "<pre>";
        print_r($entrepreneurs);
        die();*/

        return ['TotalEntrepreneurs' => $total_etrepreneurs, 'list' => $entrepreneurs];

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
