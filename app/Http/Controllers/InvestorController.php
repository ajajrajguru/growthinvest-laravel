<?php

namespace App\Http\Controllers;

use App\Defaults;
use App\User;
use App\UserData;
use App\UserHasCertification;
use Auth;
use Illuminate\Http\Request;

//Importing laravel-permission models
use Illuminate\Support\Facades\Hash;
use Session;

//Enables us to output flash messaging

class InvestorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user      = new User;
        $investors = $user->getInvestorUsers();

        $firmsList = getModelList('App\Firm', [], 0, 0, ['name' => 'asc']);
        $firms     = $firmsList['list'];

        $clientCategoriesList = getModelList('App\Defaults', ['type' => 'certification'], 0, 0, ['name' => 'asc']);
        $clientCategories     = $clientCategoriesList['list'];

        $certificationTypes = certificationTypes();

        $breadcrumbs   = [];
        $breadcrumbs[] = ['url' => url('/'), 'name' => "Manage"];
        $breadcrumbs[] = ['url' => '', 'name' => 'Manage Clients'];
        $breadcrumbs[] = ['url' => '', 'name' => 'Investors'];

        $data['certificationTypes'] = $certificationTypes;
        $data['clientCategories']   = $clientCategories;
        $data['firms']              = $firms;
        $data['investors']          = $investors;
        $data['breadcrumbs']        = $breadcrumbs;
        $data['pageTitle']          = 'Investors';

        return view('backoffice.clients.investors')->with($data);
    }

    public function getInvestors(Request $request)
    {

        $requestData = $request->all(); //dd($requestData);
        $data        = [];
        $skip        = $requestData['start'];
        $length      = $requestData['length'];
        $orderValue  = $requestData['order'][0];
        $filters     = $requestData['filters'];

        $columnOrder = array(
            '1' => 'users.first_name',
            '2' => 'user_has_certifications.created_at',
            '3' => 'user_has_certifications.active',
        );

        $columnName = 'users.first_name';
        $orderBy    = 'asc';

        if (isset($columnOrder[$orderValue['column']])) {
            $columnName = $columnOrder[$orderValue['column']];
            $orderBy    = $orderValue['dir'];
        }

        $orderDataBy = [$columnName => $orderBy];

        $filterInvestors = $this->getFilteredInvestors($filters, $skip, $length, $orderDataBy);
        $investors       = $filterInvestors['list'];
        $totalInvestors  = $filterInvestors['totalInvestors'];

        $investorsData = [];
        $certification = [];
        foreach ($investors as $key => $investor) {

            $userCertification = $investor->userCertification()->orderBy('created_at', 'desc')->first();

            $certificationName = 'Uncertified Investors';
            $certificationDate = '-';

            if (!empty($userCertification)) {

                if (isset($certification[$userCertification->certification_default_id])) {
                    $certificationName = $certification[$userCertification->certification_default_id];
                } else {
                    $certificationName                                           = Defaults::find($userCertification->certification_default_id)->name;
                    $certification[$userCertification->certification_default_id] = $certificationName;
                }

                $certificationDate = date('d/m/Y', strtotime($userCertification->created_at));
            }

            $nameHtml = '<b><a href=="">' . $investor->first_name . ' ' . $investor->last_name . '</a></b><br><a class="investor_email text-small" href="mailto: ' . $investor->email . '">' . $investor->email . '</a><br>' . $certificationName;

            $actionHtml = '<select class="form-control form-control-sm">
            <option id="select" value="">-Select-</option>
            <option value="edit_profile">View Profile</option>
            <option value="view_portfolio">View Portfolio</option>
            <option value="manage_documents">View Investor Documents</option>
            <option value="message_board">View Message Board</option>
            <option value="nominee_application">Investment Account</option>
            <option value="investoffers">Investment Offers</option>
            </select>';

            $active = (!empty($userCertification) && $userCertification->active) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Not Active</span>';

            $investorsData[] = [
                '#'                     => '<div class="custom-checkbox custom-control"><input type="checkbox" value="' . $investor->id . '" class="custom-control-input ck_investor" name="ck_investor" id="ch' . $investor->id . '"><label class="custom-control-label" for="ch' . $investor->id . '"></label></div> ',
                'name'                  => $nameHtml,
                'certification_date'    => $certificationDate,
                'client_categorisation' => $active,
                'parent_firm'           => (!empty($investor->firm)) ? $investor->firm->name : '',
                'registered_date'       => date('d/m/Y', strtotime($investor->created_at)),
                'action'                => $actionHtml,

            ];

        }

        $json_data = array(
            "draw"            => intval($requestData['draw']),
            "recordsTotal"    => intval($totalInvestors),
            "recordsFiltered" => intval($totalInvestors),
            "data"            => $investorsData,
        );

        return response()->json($json_data);

    }

    public function getFilteredInvestors($filters, $skip, $length, $orderDataBy)
    {

        $investorQuery = User::join('model_has_roles', function ($join) {
            $join->on('users.id', '=', 'model_has_roles.model_id')
                ->where('model_has_roles.model_type', 'App\User');
        })->join('roles', function ($join) {
            $join->on('model_has_roles.role_id', '=', 'roles.id')
                ->whereIn('roles.name', ['investor', 'yet_to_be_approved_investor']);
        })->leftjoin('user_has_certifications', function ($join) {
            $join->on('users.id', 'user_has_certifications.user_id');
        });

        if (isset($filters['firm_name']) && $filters['firm_name'] != "") {
            $investorQuery->where('users.firm_id', $filters['firm_name']);
        }

        if (isset($filters['user_ids']) && $filters['user_ids'] != "") {
            $userIds = explode(',', $filters['user_ids']);
            $userIds = array_filter($userIds);

            $investorQuery->whereIn('users.id', $userIds);
        }

        if (isset($filters['investor_name']) && $filters['investor_name'] != "") {
            $investorQuery->where('users.id', $filters['investor_name']);
        }

        if (isset($filters['client_category']) && $filters['client_category'] != "") {
            $investorQuery->where('user_has_certifications.certification_default_id', $filters['client_category']);
        }

        if (isset($filters['client_certification']) && $filters['client_certification'] != "") {
            if ($filters['client_certification'] == 'uncertified') {
                $investorQuery->whereNull('user_has_certifications.created_at');
            }

        }

        $nomineeJoin = false;
        if (isset($filters['investor_nominee']) && $filters['investor_nominee'] != "") {
            $investorQuery->leftjoin('nominee_applications', 'users.id', '=', 'nominee_applications.user_id');
            $nomineeJoin = true;
            if ($filters['investor_nominee'] == 'nominee') {
                $investorQuery->whereNotNull('nominee_applications.user_id');
            } else {
                $investorQuery->whereNull('nominee_applications.user_id');
            }

        }

        if (isset($filters['idverified']) && $filters['idverified'] != "") {
            if (!$nomineeJoin) {
                $investorQuery->leftjoin('nominee_applications', 'users.id', '=', 'nominee_applications.user_id');
            }

            if ($filters['idverified'] == 'no') {
                $verificationStatus = ['no', 'progress', 'requested', 'not_yet_requested'];
            } else {
                $verificationStatus = ['yes', 'completed'];
            }

            $investorQuery->whereIn('nominee_applications.id_verification_status', $verificationStatus);
        }

        $investorQuery->groupBy('users.id')->select('users.*');

        foreach ($orderDataBy as $columnName => $orderBy) {
            $investorQuery->orderBy($columnName, $orderBy);
        }

        if ($length > 1) {

            $totalInvestors = $investorQuery->get()->count();
            $investors      = $investorQuery->skip($skip)->take($length)->get();
        } else {
            $investors      = $investorQuery->get();
            $totalInvestors = $investorQuery->count();
        }

        return ['totalInvestors' => $totalInvestors, 'list' => $investors];

    }

    public function exportInvestors(Request $request)
    {

        $data    = [];
        $filters = $request->all();

        $columnName = 'users.first_name';
        $orderBy    = 'asc';

        $orderDataBy = [$columnName => $orderBy];

        $filterInvestors = $this->getFilteredInvestors($filters, 0, 0, $orderDataBy);
        $investors       = $filterInvestors['list'];

        $fileName = 'all_investors_as_on_' . date('d-m-Y');
        $header   = ['Platform GI Code', 'Investor Name', 'Email ID', 'Certification Role', 'Certification Date', 'Client Categorisation', 'Parent Firm', 'Registered Date'];
        $userData = [];

        $certification = [];
        foreach ($investors as $investor) {

            $userCertification = $investor->userCertification()->orderBy('created_at', 'desc')->first();

            $certificationName = 'Uncertified Investors';
            $certificationDate = '-';

            if (!empty($userCertification)) {

                if (isset($certification[$userCertification->certification_default_id])) {
                    $certificationName = $certification[$userCertification->certification_default_id];
                } else {
                    $certificationName                                           = Defaults::find($userCertification->certification_default_id)->name;
                    $certification[$userCertification->certification_default_id] = $certificationName;
                }

                $certificationDate = date('d/m/Y', strtotime($userCertification->created_at));
            }

            $active = (!empty($userCertification) && $userCertification->active) ? 'Active' : 'Not Active';

            $userData[] = [$investor->gi_code,
                title_case($investor->first_name . ' ' . $investor->last_name),
                $investor->email,
                $certificationName,
                $certificationDate,
                $active,
                (!empty($investor->firm)) ? $investor->firm->name : '',
                date('d/m/Y', strtotime($investor->created_at)),

            ];
        }

        generateCSV($header, $userData, $fileName);

        return true;

    }

    public function registration()
    {

        $investor  = new User;
        $firmsList = getModelList('App\Firm', [], 0, 0, ['name' => 'asc']);
        $firms     = $firmsList['list'];

        $breadcrumbs   = [];
        $breadcrumbs[] = ['url' => url('/'), 'name' => "Dashboard"];
        $breadcrumbs[] = ['url' => url('/backoffice/investor'), 'name' => 'Add Clients'];
        $breadcrumbs[] = ['url' => url('/backoffice/investor'), 'name' => 'Investor'];
        $breadcrumbs[] = ['url' => '', 'name' => 'Registration'];

        $data['countyList']  = getCounty();
        $data['countryList'] = getCountry();
        $data['investor']    = $investor;
        $data['firms']       = $firms;
        $data['breadcrumbs'] = $breadcrumbs;
        $data['pageTitle']   = 'Add Investor';
        $data['mode']        = 'edit';

        return view('backoffice.clients.registration')->with($data);

    }

    public function editRegistration($giCode)
    {
        $investor = User::where('gi_code', $giCode)->first();

        if (empty($investor)) {
            abort(404);
        }

        $firmsList = getModelList('App\Firm', [], 0, 0, ['name' => 'asc']);
        $firms     = $firmsList['list'];

        $breadcrumbs   = [];
        $breadcrumbs[] = ['url' => url('/'), 'name' => "Dashboard"];
        $breadcrumbs[] = ['url' => url('/backoffice/investor'), 'name' => 'Add Clients'];
        $breadcrumbs[] = ['url' => url('/backoffice/investor'), 'name' => 'Investor'];
        $breadcrumbs[] = ['url' => '', 'name' => 'Registration'];

        $data['countyList']  = getCounty();
        $data['countryList'] = getCountry();
        $data['investor']    = $investor;
        $data['firms']       = $firms;
        $data['breadcrumbs'] = $breadcrumbs;
        $data['pageTitle']   = 'Add Investor : Registration';
        $data['mode']        = 'view';

        return view('backoffice.clients.registration')->with($data);

    }

    public function saveRegistration(Request $request)
    {
        $requestData             = $request->all();
        $title                   = $requestData['title'];
        $firstName               = $requestData['first_name'];
        $lastName                = $requestData['last_name'];
        $email                   = $requestData['email'];
        $telephone               = $requestData['telephone'];
        $password                = $requestData['password'];
        $addressLine1            = $requestData['address_line_1'];
        $addressLine2            = $requestData['address_line_2'];
        $townCity                = $requestData['town_city'];
        $county                  = $requestData['county'];
        $postcode                = $requestData['postcode'];
        $country                 = $requestData['country'];
        $firm                    = $requestData['firm'];
        $investmentAccountNumber = $requestData['investment_account_number'];
        $isSuspended             = (isset($requestData['is_suspended'])) ? 1 : 0;
        $giCode                  = $requestData['gi_code'];

        $giArgs = array('prefix' => "GIIM", 'min' => 20000001, 'max' => 30000000);

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

            $investor                = new User;
            $giCode                  = generateGICode($investor, 'gi_code', $giArgs);
            $investor->gi_code       = $giCode;
            $investor->registered_by = Auth::user()->id;
        } else {
            $investor = User::where('gi_code', $giCode)->first();
        }

        $investor->login_id     = $email;
        $investor->avatar       = '';
        $investor->title        = $title;
        $investor->email        = $email;
        $investor->first_name   = $firstName;
        $investor->last_name    = $lastName;
        $investor->password     = Hash::make($password);
        $investor->status       = 0;
        $investor->telephone_no = $telephone;
        $investor->address_1    = $addressLine1;
        $investor->address_2    = $addressLine2;
        $investor->city         = $townCity;
        $investor->postcode     = $postcode;
        $investor->county       = $county;
        $investor->country      = $country;
        $investor->firm_id      = $firm;
        $investor->suspended    = $isSuspended;
        $investor->deleted      = 0;
        $investor->save();

        $investorId = $investor->id;

        $investorData = $investor->userAdditionalInfo();
        if (empty($investorData)) {
            $investorData           = new UserData;
            $investorData->user_id  = $investorId;
            $investorData->data_key = 'p1code';
        }

        $investorData->data_value = $investmentAccountNumber;
        $investorData->save();

        //assign role

        $roleName = $investor->getRoleNames()->first();
        if (empty($roleName)) {
            $investor->assignRole('yet_to_be_approved_investor');
        }

        Session::flash('success_message', 'Your client registration details added successfully and being redirected to certification stage');
        return redirect(url('backoffice/investor/' . $giCode . '/client-categorisation'));
    }

    public function clientCategorisation($giCode)
    {
        $investor = User::where('gi_code', $giCode)->first();

        if (empty($investor)) {
            abort(404);
        }
        
        $clientCategoriesList = getModelList('App\Defaults', ['type' => 'certification'], 0, 0, ['name' => 'asc']);
        $clientCategories     = $clientCategoriesList['list'];

        $breadcrumbs   = [];
        $breadcrumbs[] = ['url' => url('/'), 'name' => "Dashboard"];
        $breadcrumbs[] = ['url' => url('/backoffice/investor'), 'name' => 'Add Clients'];
        $breadcrumbs[] = ['url' => url('/backoffice/investor'), 'name' => 'Investor'];
        $breadcrumbs[] = ['url' => '', 'name' => 'Client Categorisation'];
        
        $data['investor']    = $investor;
        $data['countyList']  = getCounty();
        $data['countryList'] = getCountry();
        $data['clientCategories']    = $clientCategories;
        $data['certificationTypes']    = certificationTypes();
        $data['investorCertification']    = $investor->getActiveCertification();  
        $data['breadcrumbs'] = $breadcrumbs;
        $data['pageTitle']   = 'Add Investor : Client Categorisation';
        $data['mode']        = 'view';

        return view('backoffice.clients.client-categorisation')->with($data);

    }

    public function saveClientCategorisation(Request $request,$giCode){

        $investor = User::where('gi_code', $giCode)->first();

        if (empty($investor)) {
            abort(404);
        }

        $requestData = $request->all();

        $activeCertification = $investor->getActiveCertification();
        if(!empty($activeCertification)){
            $activeCertification->active = 0;
            $activeCertification->save();
        }
        

        $details = [];
        if($requestData['save-type'] == 'retail'){
            $details = $this->getRetailData($requestData);
        }
        elseif($requestData['save-type'] == 'sophisticated'){
            $details = $this->getSophisticatedData($requestData);
        }
        elseif($requestData['save-type'] == 'high_net_worth'){
            $details = $this->getHighNetWorthData($requestData);
        }
        elseif($requestData['save-type'] == 'professsional_investors'){
            $details = $this->getProfessionalInvData($requestData);
        }
        elseif($requestData['save-type'] == 'advice_investors'){
            $details = $this->getAdviceInvestorsData($requestData);
        }
        elseif($requestData['save-type'] == 'elective_prof'){
            $details = $this->getElectiveProfData($requestData);
        }

       

        $hasCertification = $investor->userCertification()->where('certification_default_id',$requestData['client_category_id'])->first();
        if(empty($hasCertification)){
            $hasCertification = new UserHasCertification;
            $hasCertification->user_id = $investor->id;
            $hasCertification->certification_default_id = $requestData['client_category_id'];
            $hasCertification->file_id = 0;
        }
        
        $hasCertification->certification = $requestData['certification_type'];;
        $hasCertification->active = 1;
        $hasCertification->details = $details;
        $hasCertification->save(); 

        if(!$investor->hasRole('investor')){
            $investor->removeRole('yet_to_be_approved_investor');
            $investor->assignRole('investor');
        }
 
        return response()->json(['success'=>true]);

    }

    public function getRetailData($requestData){
        $data = [];
        $retailCkStr = $requestData['conditions'];
        $retailCkExp = explode(',', $retailCkStr);
        $data['conditions'] = array_filter($retailCkExp);
        $data['quiz_answers'] = $requestData['quiz_answers'];

        return $data;
    }

    public function getSophisticatedData($requestData){ 
        $data = [];
        $termsStr = $requestData['terms'];
        $termsExp = explode(',', $termsStr);
        $data['terms'] = array_filter($termsExp);

        $conditionStr = $requestData['conditions'];
        $conditionExp = explode(',', $conditionStr);
        $data['conditions'] = array_filter($conditionExp);

        return $data;
    }

    public function getHighNetWorthData($requestData){ 
        $data = [];
        $termsStr = $requestData['terms'];
        $termsExp = explode(',', $termsStr);
        $data['terms'] = array_filter($termsExp);

        $conditionStr = $requestData['conditions'];
        $conditionExp = explode(',', $conditionStr);
        $data['conditions'] = array_filter($conditionExp);

        return $data;
    }

    public function getProfessionalInvData($requestData){ 
        $data = [];
        $conditionStr = $requestData['conditions'];
        $conditionExp = explode(',', $conditionStr);
        $data['conditions'] = array_filter($conditionExp);

        return $data;
    }

    public function getAdviceInvestorsData($requestData){ 
        $data = [];
        $conditionStr = $requestData['conditions'];
        $conditionExp = explode(',', $conditionStr);
        $data['conditions'] = array_filter($conditionExp);
        $data['financial_advisor_info'] = $requestData['financial_advisor_info'];

        return $data;
    }

    public function getElectiveProfData($requestData){
        $data = [];
        $data['quiz_answers'] = $requestData['quiz_answers'];
        $data['investor_statement'] = $requestData['investor_statement'];

        return $data;
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
