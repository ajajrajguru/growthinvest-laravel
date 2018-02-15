<?php

namespace App\Http\Controllers;

use App\User;
use App\UserData;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;

class FundmanagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user         = new User;
        $fundmanagers = $user->getFundmanagers();
        $firmsList    = getModelList('App\Firm', [], 0, 0, ['name' => 'asc']);
        $firms        = $firmsList['list'];

        $breadcrumbs   = [];
        $breadcrumbs[] = ['url' => url('/'), 'name' => "Dashboard"];
        $breadcrumbs[] = ['url' => '', 'name' => 'Manage Clients'];
        $breadcrumbs[] = ['url' => '', 'name' => 'Manage Businesses'];
        $breadcrumbs[] = ['url' => '', 'name' => 'Fund Managers'];

        $data['firms']        = $firms;
        $data['fundmanagers'] = $fundmanagers;
        $data['breadcrumbs']  = $breadcrumbs;
        $data['pageTitle']    = 'Fund Managers';
        $data['activeMenu']   = 'manage_clients';

        return view('backoffice.clients.fundmanagers')->with($data);
    }

    public function getFundmanagerslist(Request $request)
    {
        $requestData = $request->all(); //dd($requestData);
        $data        = [];
        $skip        = $requestData['start'];
        $length      = $requestData['length'];
        $orderValue  = $requestData['order'][0];
        $filters     = $requestData['filters'];

        $columnOrder = array(
            '0' => 'users.first_name',
            '1' => 'users.email',
            '2' => 'firm_name',
            '3' => 'business',
            '4' => 'users.created_at',

        );

        $columnName = 'users.first_name';
        $orderBy    = 'asc';

        if (isset($columnOrder[$orderValue['column']])) {
            $columnName = $columnOrder[$orderValue['column']];
            $orderBy    = $orderValue['dir'];
        }

        $orderDataBy = [$columnName => $orderBy];

        $filter_fundamangers = $this->getFilteredFundmanagers($filters, $skip, $length, $orderDataBy);
        $fundmanagers        = $filter_fundamangers['list'];
        $total_fundmanagers  = $filter_fundamangers['total_fundmanagers'];

        $fundmanagers_data = [];

        foreach ($fundmanagers as $key => $fundmanager) {

            $nameHtml = '<b><a href=="#">' . $fundmanager->first_name . ' ' . $fundmanager->last_name . '</a>';

            $actionHtml = '<select data-id="" class="firm_actions" edit-url="#">
                                                <option>--select--</option>
                                                <option value="edit">Edit Profile</option>
                                                </select>';

            $source = "Self";
            if ($fundmanager->registered_by !== $fundmanager->id && $fundmanager->registered_by != 0) {
                $source = "Intermediary";
            }

            if (!is_null($fundmanager->invite_key) && $fundmanager->invite_key != "") {
                $source = "Invited";
            }

            $fundmanagers_data[] = [
                'name'            => $nameHtml,
                'email'           => $fundmanager->email,
                'firm'            => (!empty($fundmanager->firm)) ? $fundmanager->firm->name : '',
                'business'        => $fundmanager->business,
                'registered_date' => date('d/m/Y', strtotime($fundmanager->created_at)),
                'source'          => $source,
                'action'          => $actionHtml,

            ];

        }

        $json_data = array(
            "draw"            => intval($requestData['draw']),
            "recordsTotal"    => intval($total_fundmanagers),
            "recordsFiltered" => intval($total_fundmanagers),
            "data"            => $fundmanagers_data,
        );

        return response()->json($json_data);

    }

    public function getFilteredFundmanagers($filters = array(), $skip = 1, $length = 50, $orderDataBy = array())
    {

        $fundmanager_query = User::join('model_has_roles', function ($join) {
            $join->on('users.id', '=', 'model_has_roles.model_id')
                ->where('model_has_roles.model_type', 'App\User');
        })->join('roles', function ($join) {
            $join->on('model_has_roles.role_id', '=', 'roles.id')
                ->whereIn('roles.name', ['fundmanager']);
        })
            ->leftJoin('business_listings', function ($join) {
                $join->on('users.id', '=', 'business_listings.owner_id')
                    ->whereIn('business_listings.type', ['fund']);
            })
            ->leftJoin('business_listing_datas', function ($join) {
                $join->on('business_listings.id', '=', 'business_listing_datas.business_id')
                    ->where('business_listing_datas.data_key', 'fund_managername');
            })
            ->leftJoin('firms', function ($join) {
                $join->on('users.firm_id', '=', 'firms.id');
            });

       

        if (isset($filters['firm_name']) && $filters['firm_name'] != "") {
            $fundmanager_query->where('users.firm_id', $filters['firm_name']);
        }

       
        $fundmanager_query->groupBy('users.id');
        $fundmanager_query->select(\DB::raw("firms.name as firm_name, GROUP_CONCAT(business_listing_datas.data_value ) as business, users.*"));

        foreach ($orderDataBy as $columnName => $orderBy) {
            $fundmanager_query->orderBy($columnName, $orderBy);
        }

        if ($length > 1) {

            $total_fundmanagers = $fundmanager_query->get()->count();
            $fundmanagers       = $fundmanager_query->skip($skip)->take($length)->get();
        } else {
            $fundmanagers       = $fundmanager_query->get();
            $total_fundmanagers = $fundmanager_query->count();
        }

        return ['total_fundmanagers' => $total_fundmanagers, 'list' => $fundmanagers];

    }

    public function exportFundmanagers(Request $request)
    {

        $data    = [];
        $filters = $request->all();

        $columnName = 'users.first_name';
        $orderBy    = 'asc';

        $orderDataBy = [$columnName => $orderBy];

        $filterFundmanagers = $this->getFilteredFundmanagers($filters, 0, 0, $orderDataBy);
        $fundmanagers       = $filterFundmanagers['list'];

        $fileName = 'all_fundmanagers_as_on_' . date('d-m-Y');
        $header   = ['Platform GI Code', 'Name', 'Email ID', 'Firm', 'Funds', 'Introduced on', 'Source'];
        $userData = [];

         
        foreach ($fundmanagers as $fundmanager) {

            $source = "Self";
            if ($fundmanager->registered_by !== $fundmanager->id && $fundmanager->registered_by != 0) {
                $source = "Intermediary";
            }

            $userData[] = [$fundmanager->gi_code,
                title_case($fundmanager->first_name . ' ' . $fundmanager->last_name),
                $fundmanager->email,
                (!empty($fundmanager->firm)) ? $fundmanager->firm->name : '',
                $fundmanager->business,
                date('d/m/Y', strtotime($fundmanager->created_at)),
                $source,

            ];
        }

        generateCSV($header, $userData, $fileName);

        return true;

    }

    public function registration()
    {

        $user = Auth::user();

        $fundmanager = new User;
        $firmsList   = getModelList('App\Firm', [], 0, 0, ['name' => 'asc']);
        $firms       = $firmsList['list'];

        $breadcrumbs   = [];
        $breadcrumbs[] = ['url' => url('/'), 'name' => "Dashboard"];
        $breadcrumbs[] = ['url' => url('/backoffice/fundmanagers'), 'name' => 'Add Clients'];
        $breadcrumbs[] = ['url' => url('/backoffice/fundmanagers'), 'name' => 'Fundmanager'];
        $breadcrumbs[] = ['url' => '', 'name' => 'Registration'];

        $data['countyList']              = getCounty();
        $data['countryList']             = getCountry();
        $data['fundmanager']            = $fundmanager;
        $data['firms']                   = $firms;
        $data['investmentAccountNumber'] = '';
        $data['breadcrumbs']             = $breadcrumbs;
        $data['pageTitle']               = 'Add Fundmanager';
        $data['mode']                    = 'edit';
        $data['activeMenu']              = 'add_clients';
        $data['user_can_introduce']      = false;
        $data['type']                    = 'introduce';
        if ($user->can('edit introduce_business_owners_in_any_firm') || $user->can('edit introduce_business_owners_in_my_firm')) {
            $data['user_can_introduce'] = true;
        }
        return view('backoffice.clients.registration-fundmanager')->with($data);

    }

    public function saveRegistration(Request $request)
    {
        $requestData = $request->all();

        $firstName    = $requestData['first_name'];
        $lastName     = $requestData['last_name'];
        $email        = $requestData['email'];
        $telephone    = $requestData['telephone'];
        $password     = $requestData['password'];
        $addressLine1 = $requestData['address_line_1'];
        $addressLine2 = $requestData['address_line_2'];
        $townCity     = $requestData['town_city'];
        $county       = $requestData['county'];
        $postcode     = $requestData['postcode'];
        $country      = $requestData['country'];
        $firm         = $requestData['firm'];
        $company      = $requestData['company'];
        $website      = $requestData['website'];
        $isSuspended  = (isset($requestData['is_suspended'])) ? 1 : 0;
        $giCode       = $requestData['gi_code'];

        $userMeta['company'] = $company;
        $userMeta['website'] = $website;

        $giArgs = array('prefix' => "GIEN", 'min' => 20000001, 'max' => 30000000);

        if ($giCode == '') {

            if (isset($requestData['g-recaptcha-response'])) {

                $jsonResponse = recaptcha_validate($requestData['g-recaptcha-response']);

                if ($jsonResponse->success == '') {
                    Session::flash('error_message', 'Please verify that you are not a robot.');
                    return redirect()->back()->withInput();

                }
            } else {
                Session::flash('error_message', 'Please verify that you are not a robot.');
                return redirect()->back()->withInput();
            }

            $fundmanager = new User;

            if ($fundmanager->isUserAlreadyExists($email) == true) {
                Session::flash('error_message', 'User with email id already registered.');
                return redirect()->back()->withInput();
            }

            $giCode                     = generateGICode($fundmanager, 'gi_code', $giArgs);
            $fundmanager->gi_code       = $giCode;
            $fundmanager->registered_by = Auth::user()->id;
        } else {
            $fundmanager = User::where('gi_code', $giCode)->first();
        }

        $fundmanager->login_id = $email;
        $fundmanager->avatar   = '';

        $fundmanager->email        = $email;
        $fundmanager->first_name   = $firstName;
        $fundmanager->last_name    = $lastName;
        $fundmanager->password     = Hash::make($password);
        $fundmanager->status       = 0;
        $fundmanager->telephone_no = $telephone;
        $fundmanager->address_1    = $addressLine1;
        $fundmanager->address_2    = $addressLine2;
        $fundmanager->city         = $townCity;
        $fundmanager->postcode     = $postcode;
        $fundmanager->county       = $county;
        $fundmanager->country      = $country;
        $fundmanager->firm_id      = $firm;
        $fundmanager->suspended    = $isSuspended;
        $fundmanager->deleted      = 0;
        $fundmanager->save();

        $fundmanagerId = $fundmanager->id;

        $userMeta['company'] = $company;
        $userMeta['website'] = $website;

        $additionalInfo = $fundmanager->userAdditionalInfo();
        if (empty($additionalInfo)) {
            $additionalInfo           = new UserData;
            $additionalInfo->user_id  = $fundmanagerId;
            $additionalInfo->data_key = 'additional_info';
        }

        $additionalInfo->data_value = $userMeta;
        $additionalInfo->save();

        //assign role

        $roleName = $fundmanager->getRoleNames()->first();
        if (empty($roleName)) {
            $fundmanager->assignRole('business_owner');
        }

        Session::flash('success_message', 'Fund manager registered successfully');
        return redirect(url('backoffice/fundmanager/' . $giCode . "/registration"));
    }

    public function editRegistration($giCode)
    {
        $user        = Auth::user();
        $fundmanager = User::where('gi_code', $giCode)->first();

        if (empty($fundmanager)) {
            abort(404);
        }

        $firmsList = getModelList('App\Firm', [], 0, 0, ['name' => 'asc']);
        $firms     = $firmsList['list'];

        $breadcrumbs   = [];
        $breadcrumbs[] = ['url' => url('/'), 'name' => "Dashboard"];
        $breadcrumbs[] = ['url' => url('/backoffice/fundmanager'), 'name' => 'Add Clients'];
        $breadcrumbs[] = ['url' => url('/backoffice/fundmanager'), 'name' => 'Fundmanager'];
        $breadcrumbs[] = ['url' => '', 'name' => 'Registration'];

        $investmentAccountNumber         = $fundmanager->userInvestmentAccountNumber();
        $data['countyList']              = getCounty();
        $data['countryList']             = getCountry();
        $data['fundmanager']            = $fundmanager;
        $data['firms']                   = $firms;
        $data['breadcrumbs']             = $breadcrumbs;
        $data['investmentAccountNumber'] = (!empty($investmentAccountNumber)) ? $investmentAccountNumber->data_value : '';
        $data['pageTitle']               = 'Edit Fundmanager : Registration';
        $data['mode']                    = 'view';
        $data['activeMenu']              = 'add_clients';
        $data['user_can_introduce']      = false;
        $data['type']                    = 'introduce';
        if ($user->can('edit introduce_business_owners_in_any_firm') || $user->can('edit introduce_business_owners_in_my_firm')) {
            $data['user_can_introduce'] = true;
        }

        $additionalInfo         = $fundmanager->userAdditionalInfo();
        $data['additionalInfo'] = (!empty($additionalInfo)) ? $additionalInfo->data_value : [];

        return view('backoffice.clients.registration-fundmanager')->with($data);

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
