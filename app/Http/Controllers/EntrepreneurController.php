<?php

namespace App\Http\Controllers;

use App\User;
use App\UserData;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;

class EntrepreneurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user          = new User;
        $entrepreneurs = $user->getEntrepreneurs();
        $firmsList     = getModelList('App\Firm', [], 0, 0, ['name' => 'asc']);
        $firms         = $firmsList['list'];

        $breadcrumbs   = [];
        $breadcrumbs[] = ['url' => url('/'), 'name' => "Dashboard"];
        $breadcrumbs[] = ['url' => '', 'name' => 'Manage Clients'];
        $breadcrumbs[] = ['url' => '', 'name' => 'Manage Businesses'];
        $breadcrumbs[] = ['url' => '', 'name' => 'Entrepreneurs'];

        $data['firms']         = $firms;
        $data['entrepreneurs'] = $entrepreneurs;
        $data['breadcrumbs']   = $breadcrumbs;
        $data['pageTitle']     = 'Entrepreneurs';
        $data['activeMenu']    = 'manage_clients';

        return view('backoffice.clients.entrepreneurs')->with($data);
    }

    public function getEntrepreneurslist(Request $request)
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

        $filterEntrepreneurs = $this->getFilteredEntrepreneurs($filters, $skip, $length, $orderDataBy);
        $entrepreneurs       = $filterEntrepreneurs['list'];
        $totalEntrepreneurs  = $filterEntrepreneurs['TotalEntrepreneurs'];

        $entrepreneursData = [];

        foreach ($entrepreneurs as $key => $entrepreneur) {

            $nameHtml = '<b><a href=="#">' . $entrepreneur->first_name . ' ' . $entrepreneur->last_name . '</a>';

            $actionHtml = '<select data-id="" class="firm_actions" edit-url="#">
                                                <option>--select--</option>
                                                <option value="edit">Edit Profile</option>
                                                </select>';

            $source = "Self";
            if ($entrepreneur->registered_by !== $entrepreneur->id && $entrepreneur->registered_by != 0) {
                $source = "Intermediary";
            }

            $entrepreneursData[] = [
                'name'            => $nameHtml,
                'email'           => $entrepreneur->email,
                'firm'            => (!empty($entrepreneur->firm)) ? $entrepreneur->firm->name : '',
                'business'        => $entrepreneur->business,
                'registered_date' => date('d/m/Y', strtotime($entrepreneur->created_at)),
                'source'          => $source,
                'action'          => $actionHtml,

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

    public function getFilteredEntrepreneurs($filters = array(), $skip = 1, $length = 50, $orderDataBy = array())
    {

        $entrepreneurQuery = User::join('model_has_roles', function ($join) {
            $join->on('users.id', '=', 'model_has_roles.model_id')
                ->where('model_has_roles.model_type', 'App\User');
        })->join('roles', function ($join) {
            $join->on('model_has_roles.role_id', '=', 'roles.id')
                ->whereIn('roles.name', ['business_owner']);
        })
            ->leftJoin('business_listings', function ($join) {
                $join->on('users.id', '=', 'business_listings.owner_id')
                    ->whereIn('business_listings.type', ['proposal']);
            })
            ->leftJoin('firms', function ($join) {
                $join->on('users.firm_id', '=', 'firms.id');
            });

        if (isset($filters['firm_name']) && $filters['firm_name'] != "") {
            $entrepreneurQuery->where('users.firm_id', $filters['firm_name']);
        }

        $entrepreneurQuery->groupBy('users.id');
        $entrepreneurQuery->select(\DB::raw("firms.name as firm_name, GROUP_CONCAT(business_listings.title ) as business, users.*"));

        foreach ($orderDataBy as $columnName => $orderBy) {
            $entrepreneurQuery->orderBy($columnName, $orderBy);
        }

        if ($length > 1) {

            $totalEntrepreneurs = $entrepreneurQuery->get()->count();
            $entrepreneurs      = $entrepreneurQuery->skip($skip)->take($length)->get();
        } else {
            $entrepreneurs      = $entrepreneurQuery->get();
            $totalEntrepreneurs = $entrepreneurQuery->count();
        }

        return ['TotalEntrepreneurs' => $totalEntrepreneurs, 'list' => $entrepreneurs];

    }

    public function exportEntrepreneurs(Request $request)
    {

        $data    = [];
        $filters = $request->all();

        $columnName = 'users.first_name';
        $orderBy    = 'asc';

        $orderDataBy = [$columnName => $orderBy];

        $filterEntrepreneurs = $this->getFilteredEntrepreneurs($filters, 0, 0, $orderDataBy);
        $entrepreneurs       = $filterEntrepreneurs['list'];

        $fileName = 'all_entrepreneurs_as_on_' . date('d-m-Y');
        $header   = ['Platform GI Code', 'Entrepreneur Name', 'Email ID', 'Firm', 'Business Proposals', 'Registered Date', 'Source'];
        $userData = [];

        foreach ($entrepreneurs as $entrepreneur) {

            $source = "Self";
            if ($entrepreneur->registered_by !== $entrepreneur->id && $entrepreneur->registered_by != 0) {
                $source = "Intermediary";
            }
            if (!is_null($entrepreneur->invite_key) && $entrepreneur->invite_key != "") {
                $source = "Invited";
            }

            $userData[] = [$entrepreneur->gi_code,
                title_case($entrepreneur->first_name . ' ' . $entrepreneur->last_name),
                $entrepreneur->email,
                (!empty($entrepreneur->firm)) ? $entrepreneur->firm->name : '',
                $entrepreneur->business,
                date('d/m/Y', strtotime($entrepreneur->created_at)),
                $source,

            ];
        }

        generateCSV($header, $userData, $fileName);

        return true;

    }

    public function registration()
    {

        $user = Auth::user();

        $entrepreneur = new User;
        $firmsList    = getModelList('App\Firm', [], 0, 0, ['name' => 'asc']);
        $firms        = $firmsList['list'];

        $breadcrumbs   = [];
        $breadcrumbs[] = ['url' => url('/'), 'name' => "Dashboard"];
        $breadcrumbs[] = ['url' => url('/backoffice/entrepreneurs'), 'name' => 'Add Clients'];
        $breadcrumbs[] = ['url' => url('/backoffice/entrepreneurs'), 'name' => 'Entrepreneur'];
        $breadcrumbs[] = ['url' => '', 'name' => 'Registration'];

        $data['countyList']              = getCounty();
        $data['countryList']             = getCountry();
        $data['entrepreneur']            = $entrepreneur;
        $data['firms']                   = $firms;
        $data['investmentAccountNumber'] = '';
        $data['breadcrumbs']             = $breadcrumbs;
        $data['pageTitle']               = 'Add Entrepreneur';
        $data['mode']                    = 'edit';
        $data['activeMenu']              = 'add_clients';
        $data['user_can_introduce']      = false;
        $data['type']                    = 'introduce';
        if ($user->can('edit introduce_business_owners_in_any_firm') || $user->can('edit introduce_business_owners_in_my_firm')) {
            $data['user_can_introduce'] = true;
        }
        return view('backoffice.clients.registration-entrepreneur')->with($data);

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

            $entrepreneur = new User;

            if ($entrepreneur->isUserAlreadyExists($email) == true) {
                Session::flash('error_message', 'User with email id already registered.');
                return redirect()->back()->withInput();
            }

            $giCode                      = generateGICode($entrepreneur, 'gi_code', $giArgs);
            $entrepreneur->gi_code       = $giCode;
            $entrepreneur->registered_by = Auth::user()->id;
        } else {
            $entrepreneur = User::where('gi_code', $giCode)->first();
        }

        $entrepreneur->login_id = $email;
        $entrepreneur->avatar   = '';

        $entrepreneur->email        = $email;
        $entrepreneur->first_name   = $firstName;
        $entrepreneur->last_name    = $lastName;
        $entrepreneur->password     = Hash::make($password);
        $entrepreneur->status       = 0;
        $entrepreneur->telephone_no = $telephone;
        $entrepreneur->address_1    = $addressLine1;
        $entrepreneur->address_2    = $addressLine2;
        $entrepreneur->city         = $townCity;
        $entrepreneur->postcode     = $postcode;
        $entrepreneur->county       = $county;
        $entrepreneur->country      = $country;
        $entrepreneur->firm_id      = $firm;
        $entrepreneur->suspended    = $isSuspended;
        $entrepreneur->deleted      = 0;
        $entrepreneur->save();

        $entrepreneurId = $entrepreneur->id;

        $userMeta['company'] = $company;
        $userMeta['website'] = $website;

        $additionalInfo = $entrepreneur->userAdditionalInfo();
        if (empty($additionalInfo)) {
            $additionalInfo           = new UserData;
            $additionalInfo->user_id  = $entrepreneurId;
            $additionalInfo->data_key = 'additional_info';
        }

        $additionalInfo->data_value = $userMeta;
        $additionalInfo->save();

        //assign role

        $roleName = $entrepreneur->getRoleNames()->first();
        if (empty($roleName)) {
            $entrepreneur->assignRole('business_owner');
        }

        Session::flash('success_message', 'Entrepreneur registered successfully');
        return redirect(url('backoffice/entrepreneur/' . $giCode."/registration"));
    }

    public function editRegistration($giCode)
    {
        $user = Auth::user();
        $entrepreneur = User::where('gi_code', $giCode)->first();

        if (empty($entrepreneur)) {
            abort(404);
        }

        $firmsList = getModelList('App\Firm', [], 0, 0, ['name' => 'asc']);
        $firms     = $firmsList['list'];

        $breadcrumbs   = [];
        $breadcrumbs[] = ['url' => url('/'), 'name' => "Dashboard"];
        $breadcrumbs[] = ['url' => url('/backoffice/entrepreneur'), 'name' => 'Add Clients'];
        $breadcrumbs[] = ['url' => url('/backoffice/entrepreneur'), 'name' => 'Entrepreneur'];
        $breadcrumbs[] = ['url' => '', 'name' => 'Registration'];

        $investmentAccountNumber         = $entrepreneur->userInvestmentAccountNumber();
        $data['countyList']              = getCounty();
        $data['countryList']             = getCountry();
        $data['entrepreneur']            = $entrepreneur;
        $data['firms']                   = $firms;
        $data['breadcrumbs']             = $breadcrumbs;
        $data['investmentAccountNumber'] = (!empty($investmentAccountNumber)) ? $investmentAccountNumber->data_value : '';
        $data['pageTitle']               = 'Edit Entrepreneur : Registration';
        $data['mode']                    = 'view';
        $data['activeMenu']              = 'add_clients';
        $data['user_can_introduce']      = false;
        $data['type']                    = 'introduce';
        if ($user->can('edit introduce_business_owners_in_any_firm') || $user->can('edit introduce_business_owners_in_my_firm')) {
            $data['user_can_introduce'] = true;
        }

        $additionalInfo         = $entrepreneur->userAdditionalInfo();
        $data['additionalInfo'] = (!empty($additionalInfo)) ? $additionalInfo->data_value : [];

        return view('backoffice.clients.registration-entrepreneur')->with($data);

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
