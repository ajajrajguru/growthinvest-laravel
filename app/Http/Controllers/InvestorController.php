<?php

namespace App\Http\Controllers;

use App\Activity;
use App\ActivityGroup;
use App\AdobeSignature;
use App\BusinessListing;
use App\Comment;
use App\Defaults;
use App\DocumentFile;
use App\Firm;
use App\InvestorPdfHtml;
use App\NomineeApplication;
use App\User;
use App\UserData;
use App\UserHasCertification;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

//Importing laravel-permission models
use Session;
use Spipu\Html2Pdf\Html2Pdf;
use View;

//Enables us to output flash messaging

class InvestorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $user      = new User;
        $investors = $user->getInvestorUsers();

        $requestFilters = $request->all();

        $firmsList = getModelList('App\Firm', [], 0, 0, ['name' => 'asc']);
        $firms     = $firmsList['list'];

        $clientCategoriesList = getModelList('App\Defaults', ['type' => 'certification'], 0, 0, ['name' => 'asc']);
        $clientCategories     = $clientCategoriesList['list'];

        $certificationTypes = certificationTypes();

        $breadcrumbs   = [];
        $breadcrumbs[] = ['url' => url('/'), 'name' => "Manage"];
        $breadcrumbs[] = ['url' => '', 'name' => 'Manage Clients'];
        $breadcrumbs[] = ['url' => '', 'name' => 'Manage Investors'];

        $data['certificationTypes'] = $certificationTypes;
        $data['clientCategories']   = $clientCategories;
        $data['requestFilters']     = $requestFilters;
        $data['firms']              = $firms;
        $data['investors']          = $investors;
        $data['breadcrumbs']        = $breadcrumbs;
        $data['pageTitle']          = 'Investors';
        $data['activeMenu']         = 'manage_clients';

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

            $userCertification = $investor->userCertification()->orderBy('updated_at', 'desc')->orderBy('active', 'desc')->first();

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

            $nameHtml = '<b><a href="' . url('backoffice/investor/' . $investor->gi_code . '/investor-profile') . '">' . $investor->first_name . ' ' . $investor->last_name . '</a></b><br><a class="investor_email text-small" href="mailto: ' . $investor->email . '">' . $investor->email . '</a><br>' . $certificationName;

            $actionHtml = '<select class="form-control investor_actions form-control-sm" >
            <option id="select" value="">-Select-</option>
            <option value="edit_profile" edit-url="' . url('backoffice/investor/' . $investor->gi_code . '/investor-profile') . '">View Profile</option>
            <option value="view_portfolio">View Portfolio</option>
            <option value="manage_documents">View Investor Documents</option>
            <option value="message_board" edit-url="' . url('backoffice/investor/' . $investor->gi_code . '/investor-news-update') . '">View Message Board</option>
            <option value="nominee_application">Investment Account</option>
            <option value="investoffers" edit-url="' . url('backoffice/investor/' . $investor->gi_code . '/investor-invest') . '">Investment Offers</option>
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
            $join->on('model_has_roles.role_id', '=', 'roles.id');

        })->leftjoin('user_has_certifications', function ($join) {
            $join->on('users.id', 'user_has_certifications.user_id');
        })->whereIn('roles.name', ['investor', 'yet_to_be_approved_investor']);

        $investorQuery->whereIn('roles.name', ['investor', 'yet_to_be_approved_investor']);
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
            $investorQuery->where('users.current_certification', $filters['client_category']);

            // $investorQuery->whereIn('users.id', function ($query) use ($filters) {
            //     $query->select('user_id')
            //         ->from(with(new UserHasCertification)->getTable())
            //         ->where('certification_default_id', $filters['client_category'])
            //         ->orderBy('updated_at', 'desc')
            //         ->groupBy('user_id');
            // });

        }

        if (isset($filters['client_certification']) && $filters['client_certification'] != "") {
            if ($filters['client_certification'] == 'uncertified') {
                $investorQuery->where(function ($query) {
                    $query->whereNull('user_has_certifications.certification')->orWhere('user_has_certifications.certification', '');
                });
                // $investorQuery->whereNull('users.current_certification');

            } else {
                $investorQuery->where('user_has_certifications.certification', $filters['client_certification']);
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
        // $investorQuery->orderBy('user_has_certifications.updated_at', 'desc');
        // \DB::enableQueryLog();
        if ($length > 1) {

            $totalInvestors = $investorQuery->get()->count();
            $investors      = $investorQuery->skip($skip)->take($length)->get();
        } else {
            $investors      = $investorQuery->get();
            $totalInvestors = $investorQuery->count();
        }
        // dd(\DB::getQueryLog());
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

        $action = 'Download Investor CSV';
        $activity = saveActivityLog('User',Auth::user()->id,'download_investor_csv',Auth::user()->id,$action,'',Auth::user()->firm_id);

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

        $data['countyList']              = getCounty();
        $data['countryList']             = getCountry();
        $data['investor']                = $investor;
        $data['firms']                   = $firms;
        $data['investmentAccountNumber'] = '';
        $data['breadcrumbs']             = $breadcrumbs;
        $data['pageTitle']               = 'Add Investor';
        $data['mode']                    = 'edit';
        $data['activeMenu']              = 'add_clients';

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

        $investmentAccountNumber         = $investor->userInvestmentAccountNumber();
        $data['countyList']              = getCounty();
        $data['countryList']             = getCountry();
        $data['investor']                = $investor;
        $data['firms']                   = $firms;
        $data['breadcrumbs']             = $breadcrumbs;
        $data['investmentAccountNumber'] = (!empty($investmentAccountNumber)) ? $investmentAccountNumber->data_value : '';
        $data['pageTitle']               = 'Add Investor : Registration';
        $data['mode']                    = 'view';
        $data['activeMenu']              = 'add_clients';

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

        $giArgs   = array('prefix' => "GIIN", 'min' => 10000001, 'max' => 20000000);
        $sendmail = false;
        if ($giCode == '') {
            $sendmail = true;

            $userExist = User::where('email', $email)->first();

            if (!empty($userExist)) {
                Session::flash('error_message', 'Investor with ' . $email . ' already exist.');
                return redirect()->back()->withInput();
            }

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

        $investorData = $investor->userInvestmentAccountNumber();
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

        if ($sendmail) {
            $firmName = (!empty($investor->firm)) ? $investor->firm->name : 'N/A';

            $data                  = [];
            $data['from']          = config('constants.email_from');
            $data['name']          = config('constants.email_from_name');
            $data['to']            = [$email];
            $data['cc']            = [];
            $data['subject']       = "You have been registered on " . $firmName;
            $data['template_data'] = ['name' => $investor->displayName(), 'firmName' => $firmName, 'email' => $email, 'password' => $password];
            sendEmail('add-investor', $data);

            $recipients = getRecipientsByCapability([], array('manage_backoffice'));
            if (!empty($investor->registeredBy)) {
                $registeredBy = ($investor->registered_by == $investor->id) ? 'Self' : $investor->registeredBy->displayName();
            } else {
                $registeredBy = 'N/A';
            }

            $data            = [];
            $data['from']    = config('constants.email_from');
            $data['name']    = config('constants.email_from_name');
            $data['cc']      = [];
            $data['subject'] = "Notification: New Investor added under " . $firmName . " by " . $registeredBy . ".";

            foreach ($recipients as $recipientEmail => $recipientName) {
                $data['to']            = [$recipientEmail];
                $data['template_data'] = ['toName' => $recipientName, 'name' => $investor->displayName(), 'firmName' => $firmName, 'email' => $email, 'telephone' => $investor->telephone_no, 'address' => $investor->address_1, 'registeredBy' => $registeredBy, 'registeredBy' => $registeredBy, 'giCode' => $investor->gi_code];
                sendEmail('investor-register-notification', $data);
            }

            $data                  = [];
            $data['from']          = config('constants.email_from');
            $data['name']          = config('constants.email_from_name');
            $data['to']            = ['x+197408276330232@mail.asana.com'];
            $data['cc']            = [];
            $data['subject']       = $investor->displayName() . " added " . date('d/m/Y') . " by " . $registeredBy . ".";
            $data['template_data'] = ['name' => $investor->displayName(), 'firmName' => $firmName, 'email' => $email, 'telephone' => $investor->telephone_no, 'registeredBy' => $registeredBy];
            sendEmail('investor-reg-automated', $data);

            $action="New Registration on ".$firmName;
            saveActivityLog('User',Auth::user()->id,'stage1_investor_registration',$investorId,$action,'',$investor->firm_id);
        }

        $successMessage = (Auth::user()->hasPermissionTo('is_wealth_manager')) ? 'Your client registration details added successfully and being redirected to certification stage.' : 'You are being redirected to certification page';
        Session::flash('success_message', $successMessage);

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

        $investorCertification = $investor->getLastActiveCertification();

        $investorFai = $investor->userFinancialAdvisorInfo();

        $data['investor']                = $investor;
        $data['countyList']              = getCounty();
        $data['countryList']             = getCountry();
        $data['clientCategories']        = $clientCategories;
        $data['certificationTypes']      = certificationTypes();
        $data['investorCertification']   = $investorCertification;
        $data['investorFai']             = (!empty($investorFai)) ? $investorFai->data_value : [];
        $data['activeCertificationData'] = (!empty($investorCertification)) ? $investorCertification->certification() : null;
        $data['breadcrumbs']             = $breadcrumbs;
        $data['pageTitle']               = 'Add Investor : Client Categorisation';
        $data['mode']                    = 'view';
        $data['activeMenu']              = 'add_clients';

        return view('backoffice.clients.client-categorisation')->with($data);

    }

    public function saveClientCategorisation(Request $request, $giCode)
    {

        $investor = User::where('gi_code', $giCode)->first();

        if (empty($investor)) {
            abort(404);
        }

        $requestData         = $request->all();
        $invHasCertification = false;

        $activeCertification = $investor->getActiveCertification();
        if (!empty($activeCertification)) {
            $activeCertification->active      = 0;
            $activeCertification->last_active = 0;
            $activeCertification->save();
            $invHasCertification = true;
        } else {
            if ($investor->userCertification()->count()) {
                $invHasCertification = true;
            }
        }

        $details = [];
        $addData = [];
        $certificationName = '';
        if ($requestData['save-type'] == 'retail') {
            $details = $this->getRetailData($requestData);
            $addData = ['client_category_id' => $requestData['client_category_id']];
            $certificationName='retail Restricted investor';

        } elseif ($requestData['save-type'] == 'sophisticated') {
            $details = $this->getSophisticatedData($requestData);
            $certificationName='sophisticated investor';

        } elseif ($requestData['save-type'] == 'high_net_worth') {
            $details = $this->getHighNetWorthData($requestData);
            $certificationName='high net worth individual';

        } elseif ($requestData['save-type'] == 'professsional_investors') {
            $details = $this->getProfessionalInvData($requestData);
            $certificationName='professional investor';
        } elseif ($requestData['save-type'] == 'advice_investors') {
            $reqDetails = $this->getAdviceInvestorsData($requestData);

            $details['conditions'] = $reqDetails['conditions'];
            $financialAdvInfoData  = $reqDetails['financial_advisor_info'];

            $financialAdvInfo = $investor->userFinancialAdvisorInfo();
            if (empty($financialAdvInfo)) {
                $financialAdvInfo           = new UserData;
                $financialAdvInfo->user_id  = $investor->id;
                $financialAdvInfo->data_key = 'financial_advisor_info';
            }
            $financialAdvInfo->data_value = $financialAdvInfoData;
            $financialAdvInfo->save();

            $certificationName='Advised investor';

        } elseif ($requestData['save-type'] == 'elective_prof') {
            $details = $this->getElectiveProfData($requestData);
            $addData = ['client_category_id' => $requestData['client_category_id']];
            $certificationName='elective professional investor';
        }

        $fileId = $this->generateInvestorCertificationPdf($requestData['save-type'], $details, $investor, $addData);

        $hasCertification  = $investor->userCertification()->where('certification_default_id', $requestData['client_category_id'])->first();
        $certificationDate = date('Y-m-d H:i:s');
        if (empty($hasCertification)) {
            $hasCertification                           = new UserHasCertification;
            $hasCertification->user_id                  = $investor->id;
            $hasCertification->certification_default_id = $requestData['client_category_id'];

        }

        $hasCertification->file_id       = $fileId;
        $hasCertification->certification = $requestData['certification_type'];
        $hasCertification->active        = 1;
        $hasCertification->last_active   = 1;
        $hasCertification->details       = $details;
        $hasCertification->created_at    = $certificationDate;
        $hasCertification->save();

        if (!$investor->hasRole('investor')) {
            $investor->removeRole('yet_to_be_approved_investor');
            $investor->assignRole('investor');
        }

        $certificationvalidityHtml = genActiveCertificationValidityHtml($hasCertification, $fileId, $investor);
        $isWealthManager           = (Auth::user()->hasPermissionTo('is_wealth_manager')) ? true : false;

        //send mail

        if (env('APP_ENV') == 'local') {
            $expiryDate = date('Y-m-d', strtotime($certificationDate . '+1 day'));
        } else {
            $expiryDate = date('Y-m-d', strtotime($certificationDate . '+1 year'));
        }

        if (!empty($investor->firm)) {
            $firmName = $investor->firm->name;
            $firmId   = $investor->firm_id;
        } else {
            $firmName = 'N/A';
            $firmName = 0;
        }

        $recipients = getRecipientsByCapability([], array('view_all_investors'));
        $recipients = getRecipientsByCapability($recipients, array('view_firm_investors'), $firmId);
        if (!empty($investor->registeredBy)) {
            $registeredBy = ($investor->registered_by == $investor->id) ? 'Self' : $investor->registeredBy->displayName();
        } else {
            $registeredBy = 'N/A';
        }

        $certification = $hasCertification->certification()->name;

        //new certification
        if (!$invHasCertification) {
            $subject            = 'Notification: Certification of ' . $registeredBy . ' of Firm ' . $firmName . ' has been confirmed.';
            $subjectForinvestor = 'Welcome Investor to ' . $firmName;

            $template            = 'investor-confirmed-certification';
            $templateForinvestor = 'confirmed-certification-to-investor';

        } else {
            //re certification
            $subject            = 'Notification: Re-Certification of ' . $registeredBy . ' of Firm ' . $firmName . ' has been confirmed.';
            $subjectForinvestor = 'Re-Certification confirmed on ' . $firmName;

            $template            = 'investor-confirmed-certification';
            $templateForinvestor = 'confirmed-certification-to-investor';
        }

        $data            = [];
        $data['from']    = config('constants.email_from');
        $data['name']    = config('constants.email_from_name');
        $data['cc']      = [];
        $data['subject'] = $subject;

        foreach ($recipients as $recipientEmail => $recipientName) {
            $data['to']            = [$recipientEmail];
            $data['template_data'] = ['toName' => $recipientName, 'name' => $investor->displayName(), 'firmName' => $firmName, 'registeredBy' => $registeredBy, 'registeredBy' => $registeredBy, 'certification' => $certification, 'giCode' => $investor->gi_code, 'certificationDate' => $certificationDate, 'certificationExpiryDate' => $expiryDate, 'invHasCertification' => $invHasCertification];
            sendEmail($template, $data);
        }

        $data                  = [];
        $data['from']          = config('constants.email_from');
        $data['name']          = config('constants.email_from_name');
        $data['cc']            = [];
        $data['subject']       = $subjectForinvestor;
        $data['to']            = [$investor->email];
        $data['template_data'] = ['name' => $investor->displayName(), 'firmName' => $firmName, 'invHasCertification' => $invHasCertification];

        if ($fileId) {
            $filename        = DocumentFile::find($fileId)->file_url;
            $destination_dir = public_path() . '/userdocs/';

            $filePath       = $destination_dir . '/' . $filename;
            $ext            = pathinfo($filePath, PATHINFO_EXTENSION);
            $mimeType       = getFileMimeType($ext);
            $file           = \File::get($filePath);
            $data['attach'] = [['file' => base64_encode($file), 'as' => $filename, 'mime' => $mimeType]];
        }
        sendEmail($templateForinvestor, $data);


        $action="Completed Certification ".$certificationName;
        $activity = saveActivityLog('User',Auth::user()->id,'certification',$investor->id,$action,'',$investor->firm_id);
        $metaData=array('certification'=>$certificationName);
        saveActivityMeta($activity->id,'details',$metaData);


        return response()->json(['success' => true, 'file_id' => $fileId, 'html' => $certificationvalidityHtml, 'isWealthManager' => $isWealthManager]);

    }

    public function getRetailData($requestData)
    {
        $data                 = [];
        $retailCkStr          = $requestData['conditions'];
        $retailCkExp          = explode(',', $retailCkStr);
        $data['conditions']   = array_filter($retailCkExp);
        $data['quiz_answers'] = $requestData['quiz_answers'];

        return $data;
    }

    public function getSophisticatedData($requestData)
    {
        $data          = [];
        $termsStr      = $requestData['terms'];
        $termsExp      = explode(',', $termsStr);
        $data['terms'] = array_filter($termsExp);

        $conditionStr       = $requestData['conditions'];
        $conditionExp       = explode(',', $conditionStr);
        $data['conditions'] = array_filter($conditionExp);

        return $data;
    }

    public function getHighNetWorthData($requestData)
    {
        $data          = [];
        $termsStr      = $requestData['terms'];
        $termsExp      = explode(',', $termsStr);
        $data['terms'] = array_filter($termsExp);

        $conditionStr       = $requestData['conditions'];
        $conditionExp       = explode(',', $conditionStr);
        $data['conditions'] = array_filter($conditionExp);

        return $data;
    }

    public function getProfessionalInvData($requestData)
    {
        $data               = [];
        $conditionStr       = $requestData['conditions'];
        $conditionExp       = explode(',', $conditionStr);
        $data['conditions'] = array_filter($conditionExp);

        return $data;
    }

    public function getAdviceInvestorsData($requestData)
    {
        $data               = [];
        $conditionStr       = $requestData['conditions'];
        $conditionExp       = explode(',', $conditionStr);
        $data['conditions'] = array_filter($conditionExp);

        if (!isset($requestData['financial_advisor_info']['havefinancialadvisor'])) {
            $requestData['financial_advisor_info']['havefinancialadvisor'] = '';
        }

        if (!isset($requestData['financial_advisor_info']['requireadviceseedeisoreis'])) {
            $requestData['financial_advisor_info']['requireadviceseedeisoreis'] = '';
        }

        if (!isset($requestData['financial_advisor_info']['advicefromauthorised'])) {
            $requestData['financial_advisor_info']['advicefromauthorised'] = '';
        }

        $data['financial_advisor_info'] = $requestData['financial_advisor_info'];

        return $data;
    }

    public function getElectiveProfData($requestData)
    {
        $data                       = [];
        $data['quiz_answers']       = $requestData['quiz_answers'];
        $data['investor_statement'] = $requestData['investor_statement'];

        return $data;
    }

    public function generateInvestorCertificationPdf($type, $submissionData, $investor, $addData = [])
    {

        $args                     = array();
        $header_footer_start_html = getHeaderPageMarkup($args);

        $html = '<style type="text/css"></style>' . $header_footer_start_html;
        $html .= '<style>
                .w100per {
                  width:100%;
                }

                .img-sec {
                    background-color: #1C719C;
                    color: #fff;
                    text-align: center;
                }

                .text-center {
                    text-align: center;
                }

                .primary-col {
                    color: #1C719C;
                }

                p {
                    font-size: 15px;
                }
                </style>';

        $investorPdf = new InvestorPdfHtml();
        if ($type == 'retail') {
            $html .= $investorPdf->retailInvestorsHtml($submissionData, $investor, $addData);
            $fileDiaplayName = "Statement for Retail (Restricted) Investor Certification";

        } elseif ($type == 'sophisticated') {
            $html .= $investorPdf->sophisticatedCertificationHtml($submissionData, $investor);
            $fileDiaplayName = "Statement for Sophisticated Investor Certification";

        } elseif ($type == 'high_net_worth') {
            $html .= $investorPdf->highNetWorthHtml($submissionData, $investor);
            $fileDiaplayName = "Statement for High Net Worth Individual Certification";

        } elseif ($type == 'professsional_investors') {
            $html .= $investorPdf->professionInvHtml($submissionData, $investor);
            $fileDiaplayName = "Statement for Professional Investor Certification";

        } elseif ($type == 'advice_investors') {
            $investorFai                              = $investor->userFinancialAdvisorInfo();
            $submissionData['financial_advisor_info'] = (!empty($investorFai)) ? $investorFai->data_value : [];
            $html .= $investorPdf->adviceInvestorsHtml($submissionData, $investor);
            $fileDiaplayName = "Statement for Advised Investor Certification";

        } elseif ($type == 'elective_prof') {
            $html .= $investorPdf->getElectiveProfHtml($submissionData, $investor, $addData);
            $fileDiaplayName = "Statement for Elective Professional Investor Certification";
        }

        $html = str_replace('background-color:transparent', '', $html);

        $html = str_replace('transparent', '#ffffff', $html);

        $html = str_replace('background-color:#a9d0f5', '', $html);

        $html .= "</page>";

        $filename = uniqid("ab1234cde_folder1_a932_");

        $destination_dir = public_path() . '/userdocs/';

        if (!file_exists($destination_dir)) {
            mkdir($destination_dir);
        }

        $outputLink = $destination_dir . '/' . $filename . '.pdf';

        $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', array(0, 0, 0, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');

        $html2pdf->writeHTML($html);
        // $html2pdf->output();
        $html2pdf->output($outputLink, 'F');

        $pdfName = str_replace(' ', '-', $fileDiaplayName);
        $pattern = '/&([#0-9A-Za-z]+);/';
        $pdfName = preg_replace($pattern, '', $pdfName);

        $docmentFile                = new DocumentFile;
        $docmentFile->name          = $pdfName . '.pdf';
        $docmentFile->file_url      = $filename . '.pdf';
        $docmentFile->uploaded_by   = Auth::user()->id;
        $docmentFile->document_type = "userdocs";
        $docmentFile->object_id     = $investor->id;
        $docmentFile->object_type   = 'App\User';
        $docmentFile->folder_id     = 1;
        $docmentFile->save();

        return $docmentFile->id;

    }

    public function downloadCertification($fileId)
    {
        $docmentFile = DocumentFile::find($fileId);
        if (empty($docmentFile)) {
            abort(404);
        }

        $filePath = public_path() . '/userdocs/' . $docmentFile->file_url;
        $filename = $docmentFile->name;
        header('Content-type: text/csv');
        header('Content-Length: ' . filesize($filePath));
        header('Content-Disposition: attachment; filename=' . $filename);
        while (ob_get_level()) {
            ob_end_clean();
        }
        readfile($filePath);

        exit();
    }

    public function additionalInformation($giCode)
    {

        $investor = User::where('gi_code', $giCode)->first();

        if (empty($investor)) {
            abort(404);
        }

        $breadcrumbs   = [];
        $breadcrumbs[] = ['url' => url('/'), 'name' => "Dashboard"];
        $breadcrumbs[] = ['url' => url('/backoffice/investor'), 'name' => 'Add Clients'];
        $breadcrumbs[] = ['url' => url('/backoffice/investor'), 'name' => 'Investor'];
        $breadcrumbs[] = ['url' => '', 'name' => 'Additional Information'];

        $investorFai    = $investor->userFinancialAdvisorInfo();
        $additionalInfo = $investor->userAdditionalInfo();
        $sectors        = getSectors();
        sort($sectors);

        $data['countyList']     = getCounty();
        $data['countryList']    = getCountry();
        $data['investor']       = $investor;
        $data['investorFai']    = (!empty($investorFai)) ? $investorFai->data_value : [];
        $data['additionalInfo'] = (!empty($additionalInfo)) ? $additionalInfo->data_value : [];
        $data['sectors']        = $sectors;
        $data['breadcrumbs']    = $breadcrumbs;
        $data['pageTitle']      = 'Add Investor : Additional Information';
        $data['mode']           = (empty($additionalInfo)) ? 'edit' : 'view';
        $data['activeMenu']     = 'add_clients';

        return view('backoffice.clients.additional-information')->with($data);

    }

    public function saveAdditionalInformation(Request $request)
    {
        $requestData = $request->all();

        $giCode = $requestData['gi_code'];

        $investor = User::where('gi_code', $giCode)->first();

        $investorId = $investor->id;

        if (empty($investor)) {
            Session::flash('error_message', 'Error while saving data.');
            return redirect()->back()->withInput();
        }

        $investorFai['companyname']               = $requestData['companyname'];
        $investorFai['fcanumber']                 = $requestData['fcanumber'];
        $investorFai['principlecontact']          = $requestData['principlecontact'];
        $investorFai['primarycontactfca']         = $requestData['primarycontactfca'];
        $investorFai['email']                     = $requestData['email'];
        $investorFai['telephone']                 = $requestData['telephone'];
        $investorFai['address']                   = $requestData['address'];
        $investorFai['address2']                  = $requestData['address2'];
        $investorFai['city']                      = $requestData['city'];
        $investorFai['county']                    = $requestData['county'];
        $investorFai['postcode']                  = $requestData['postcode'];
        $investorFai['country']                   = $requestData['country'];
        $investorFai["havefinancialadvisor"]      = (isset($requestData["havefinancialadvisor"])) ? $requestData["havefinancialadvisor"] : '';
        $investorFai["requireadviceseedeisoreis"] = (isset($requestData["requireadviceseedeisoreis"])) ? $requestData["requireadviceseedeisoreis"] : '';
        $investorFai["advicefromauthorised"]      = (isset($requestData["advicefromauthorised"])) ? $requestData["advicefromauthorised"] : '';

        $userMeta["skypeid"]                           = $requestData["skypeid"];
        $userMeta["linkedin"]                          = $requestData["linkedin"];
        $userMeta["facebook"]                          = $requestData["facebook"];
        $userMeta["twitter"]                           = $requestData["facebook"];
        $userMeta["employmenttype"]                    = (isset($requestData["employmenttype"])) ? $requestData["employmenttype"] : '';
        $userMeta["totalannualincome"]                 = $requestData["totalannualincome"];
        $userMeta["possibleannualinvestment"]          = $requestData["possibleannualinvestment"];
        $userMeta["maximuminvestmentinanyoneproject"]  = $requestData["maximuminvestmentinanyoneproject"];
        $userMeta["investortype"]                      = (isset($requestData["investortype"])) ? $requestData["investortype"] : '';
        $userMeta["specificinterestinbussinesssector"] = $requestData["specificinterestinbussinesssector"];
        $userMeta["investedinanunlistedcompany"]       = $requestData["investedinanunlistedcompany"];
        $userMeta["comfortablewithliquidityissues"]    = (isset($requestData["comfortablewithliquidityissues"])) ? $requestData["comfortablewithliquidityissues"] : '';
        $userMeta["investorlookingfor"]                = $requestData["investorlookingfor"];
        $userMeta["requireassistance"]                 = (isset($requestData["requireassistance"])) ? $requestData["requireassistance"] : '';
        $userMeta["investas"]                          = (isset($requestData["investas"])) ? $requestData["investas"] : '';
        $userMeta["haveanycompanieslookingforfunding"] = (isset($requestData["haveanycompanieslookingforfunding"])) ? $requestData["haveanycompanieslookingforfunding"] : '';
        $userMeta["usedeisorventurecapitaltrusts"]     = (isset($requestData["usedeisorventurecapitaltrusts"])) ? $requestData["usedeisorventurecapitaltrusts"] : '';
        $userMeta["numcompaniesinvested2yr_seis"]      = $requestData["numcompaniesinvested2yr_seis"];
        $userMeta["totalinvestedinseis"]               = $requestData["totalinvestedinseis"];
        $userMeta["usedeis"]                           = (isset($requestData["usedeis"])) ? $requestData["usedeis"] : '';
        $userMeta["numcompaniesinvested2yr_eis"]       = $requestData["numcompaniesinvested2yr_eis"];
        $userMeta["totalinvestedeis"]                  = $requestData["totalinvestedeis"];
        $userMeta["usedvct"]                           = (isset($requestData["usedvct"])) ? $requestData["usedvct"] : '';
        $userMeta["numcompaniesinvested2yr_vct"]       = $requestData["numcompaniesinvested2yr_vct"];
        $userMeta["totalinvestedvct"]                  = $requestData["totalinvestedvct"];
        $userMeta["hearaboutsite"]                     = $requestData["hearaboutsite"];
        $userMeta["marketingmail"]                     = (isset($requestData["marketingmail"])) ? $requestData["marketingmail"] : '';
        $userMeta["marketingmail_party"]               = (isset($requestData["marketingmail_party"])) ? $requestData["marketingmail_party"] : '';
        $userMeta["plansforusingsite"]                 = $requestData["plansforusingsite"];
        $userMeta["angelskills"]                       = $requestData["angelskills"];
        $userMeta["angelexpertise"]                    = $requestData["angelexpertise"];

        $additionalInfo = $investor->userAdditionalInfo();
        if (empty($additionalInfo)) {
            $additionalInfo           = new UserData;
            $additionalInfo->user_id  = $investorId;
            $additionalInfo->data_key = 'additional_info';
        }

        $additionalInfo->data_value = $userMeta;
        $additionalInfo->save();

        $financialAdvInfo = $investor->userFinancialAdvisorInfo();
        if (empty($financialAdvInfo)) {
            $financialAdvInfo           = new UserData;
            $financialAdvInfo->user_id  = $investorId;
            $financialAdvInfo->data_key = 'financial_advisor_info';
        }

        $financialAdvInfo->data_value = $investorFai;
        $financialAdvInfo->save();

        $successMessage = (Auth::user()->hasPermissionTo('is_wealth_manager')) ? 'Your client Additional Information has successfully been added.' : 'Thank you. The Additional Information page has now been successfully updated';
        Session::flash('success_message', $successMessage);


        $action="Stage 3 Profile Details";
        $activity = saveActivityLog('User',Auth::user()->id,'stage_3_profile_details',$investor->id,$action,'',$investor->firm_id);

        return redirect(url('backoffice/investor/' . $giCode . '/additional-information'));

    }

    public function investmentAccount($giCode)
    {

        $investor = User::where('gi_code', $giCode)->first();
        if (empty($investor)) {
            abort(404);
        }

        $breadcrumbs   = [];
        $breadcrumbs[] = ['url' => url('/'), 'name' => "Dashboard"];
        $breadcrumbs[] = ['url' => url('/backoffice/investor'), 'name' => 'Add Clients'];
        $breadcrumbs[] = ['url' => url('/backoffice/investor'), 'name' => 'Investor'];
        $breadcrumbs[] = ['url' => '', 'name' => 'Client Investment Account'];

        $nomineeApplication = $investor->investorNomineeApplication();

        if (!empty($nomineeApplication)) {
            $investorFai = $nomineeApplication->chargesfinancial_advisor_details;
        } else {
            $investorFai = $investor->userFinancialAdvisorInfo();
            $investorFai = (!empty($investorFai)) ? $investorFai->data_value : [];

        }

        $data['countyList']           = getCounty();
        $data['countryList']          = getCountry();
        $data['investor']             = $investor;
        $data['taxCertificateSentTo'] = (!empty($nomineeApplication)) ? $nomineeApplication->tax_certificate_sent_to : '';
        $data['idVerificationStatus'] = (!empty($nomineeApplication)) ? $nomineeApplication->id_verification_status : '';
        $data['isUsPerson']           = (!empty($nomineeApplication)) ? $nomineeApplication->is_us_person : '';
        $data['nomineeDetails']       = (!empty($nomineeApplication)) ? $nomineeApplication->details : [];
        $data['adobeDocKey']          = (!empty($nomineeApplication)) ? $nomineeApplication->adobe_doc_key : '';
        $data['signedUrl']            = (!empty($nomineeApplication)) ? $nomineeApplication->signed_url : '';
        $data['investorFai']          = $investorFai;
        $data['breadcrumbs']          = $breadcrumbs;
        $data['pageTitle']            = 'Add Investor : Client Investment Account';
        $data['mode']                 = (empty($nomineeApplication)) ? 'edit' : 'view';
        $data['activeMenu']           = 'add_clients';

        return view('backoffice.clients.investment-account')->with($data);

    }

    public function saveInvestmentAccount(Request $request)
    {
        $requestData = $request->all();

        $giCode = $requestData['gi_code'];

        $investor = User::where('gi_code', $giCode)->first();

        $investorId = $investor->id;

        if (empty($investor)) {
            Session::flash('error_message', 'Error while saving data.');
            return redirect()->back()->withInput();
        }

        $sendtaxcertificateto = $requestData['sendtaxcertificateto'];
        $nomineeverification  = (isset($requestData['nomineeverification'])) ? $requestData['nomineeverification'] : '';
        $areuspersonal        = $requestData['areuspersonal'];

        $investorFai['companyname']       = $requestData['companyname'];
        $investorFai['fcanumber']         = $requestData['fcanumber'];
        $investorFai['principlecontact']  = $requestData['principlecontact'];
        $investorFai['primarycontactfca'] = $requestData['primarycontactfca'];
        $investorFai['email']             = $requestData['email'];
        $investorFai['telephone']         = $requestData['telephone'];
        $investorFai['address']           = $requestData['address'];
        $investorFai['address2']          = $requestData['address2'];
        $investorFai['city']              = $requestData['city'];
        $investorFai['county']            = $requestData['county'];
        $investorFai['postcode']          = $requestData['postcode'];
        $investorFai['country']           = $requestData['country'];

        $nomineeDetails['title']                              = $requestData['title'];
        $nomineeDetails['surname']                            = $requestData['surname'];
        $nomineeDetails['forename']                           = $requestData['forename'];
        $nomineeDetails['dateofbirth']                        = $requestData['dateofbirth'];
        $nomineeDetails['nationalinsuranceno']                = $requestData['nationalinsuranceno'];
        $nomineeDetails['nonationalinsuranceno']              = (isset($requestData['nonationalinsuranceno'])) ? $requestData['nonationalinsuranceno'] : '';
        $nomineeDetails['nationality']                        = $requestData['nationality'];
        $nomineeDetails['domiciled']                          = $requestData['domiciled'];
        $nomineeDetails['tinnumber']                          = $requestData['tinnumber'];
        $nomineeDetails['city']                               = $requestData['account_city'];
        $nomineeDetails['country']                            = $requestData['account_country'];
        $nomineeDetails['telephone']                          = $requestData['account_telephone'];
        $nomineeDetails['address']                            = $requestData['account_address'];
        $nomineeDetails['postcode']                           = $requestData['account_postcode'];
        $nomineeDetails['email']                              = $requestData['account_email'];
        $nomineeDetails['txcertificatefirmname']              = $requestData['txcertificatefirmname'];
        $nomineeDetails['txcertificatecontact']               = $requestData['txcertificatecontact'];
        $nomineeDetails['txcertificatetelephone']             = $requestData['txcertificatetelephone'];
        $nomineeDetails['txcertificateemail']                 = $requestData['txcertificateemail'];
        $nomineeDetails['txcertificateaddress']               = $requestData['txcertificateaddress'];
        $nomineeDetails['bankaccntholder1']                   = $requestData['bankaccntholder1'];
        $nomineeDetails['bankaccntholder2']                   = $requestData['bankaccntholder2'];
        $nomineeDetails['bankname']                           = $requestData['bankname'];
        $nomineeDetails['bankaccntnumber']                    = $requestData['bankaccntnumber'];
        $nomineeDetails['bankaccntsortcode']                  = $requestData['bankaccntsortcode'];
        $nomineeDetails['bankaddress']                        = $requestData['bankaddress'];
        $nomineeDetails['clientbankpostcode']                 = $requestData['clientbankpostcode'];
        $nomineeDetails['adviserinitialinvestpercent']        = $requestData['adviserinitialinvestpercent'];
        $nomineeDetails['adviserinitialinvestfixedamnt']      = $requestData['adviserinitialinvestfixedamnt'];
        $nomineeDetails['adviservattobeapplied']              = (isset($requestData['adviservattobeapplied'])) ? $requestData['adviservattobeapplied'] : '';
        $nomineeDetails['advdetailsnotapplicable']            = (isset($requestData['advdetailsnotapplicable'])) ? $requestData['advdetailsnotapplicable'] : '';
        $nomineeDetails['ongoingadvinitialinvestpercent']     = $requestData['ongoingadvinitialinvestpercent'];
        $nomineeDetails['ongoingadvinitialinvestfixedamnt']   = $requestData['ongoingadvinitialinvestfixedamnt'];
        $nomineeDetails['ongoingadvchargesvatyettobeapplied'] = (isset($requestData['ongoingadvchargesvatyettobeapplied'])) ? $requestData['ongoingadvchargesvatyettobeapplied'] : '';
        $nomineeDetails['intermediaryinitialinvestpercent']   = $requestData['intermediaryinitialinvestpercent'];
        $nomineeDetails['intermediaryvattobeapplied']         = (isset($requestData['intermediaryvattobeapplied'])) ? $requestData['intermediaryvattobeapplied'] : '';
        $nomineeDetails['intermediaryinitialinvestfixedamnt'] = $requestData['intermediaryinitialinvestfixedamnt'];
        $nomineeDetails['agreeclientdeclaration']             = (isset($requestData['agreeclientdeclaration'])) ? $requestData['agreeclientdeclaration'] : '';
        $nomineeDetails['nomverificationwithoutface']         = (isset($requestData['nomverificationwithoutface'])) ? $requestData['nomverificationwithoutface'] : '';
        $nomineeDetails['verdisplaystatus']                   = $requestData['verdisplaystatus'];
        $nomineeDetails['transfer_at_later_stage']            = (isset($requestData['transfer_at_later_stage'])) ? $requestData['transfer_at_later_stage'] : '';
        $nomineeDetails['subscriptioninvamntbank']            = $requestData['subscriptioninvamntbank'];
        $nomineeDetails['subscriptiontransferdate']           = $requestData['subscriptiontransferdate'];
        $nomineeDetails['subscriptioninvamntcheq']            = $requestData['subscriptioninvamntcheq'];
        $nomineeDetails['subscriptionbankname']               = $requestData['subscriptionbankname'];
        $nomineeDetails['subscriptionsortcode']               = $requestData['subscriptionsortcode'];
        $nomineeDetails['subscriptionaccountname']            = $requestData['subscriptionaccountname'];
        $nomineeDetails['subscriptionaccountno']              = $requestData['subscriptionaccountno'];
        $nomineeDetails['subscriptionreffnamelname']          = $requestData['subscriptionreffnamelname'];
        $nomineeDetails['section_status']                     = $requestData['section_status'];

        $sendSignature = $requestData['send_signature'];

        $nomineeApplication = $investor->investorNomineeApplication();
        if (empty($nomineeApplication)) {
            $nomineeApplication          = new NomineeApplication;
            $nomineeApplication->user_id = $investorId;
        }

        $nomineeApplication->tax_certificate_sent_to          = $sendtaxcertificateto;
        $nomineeApplication->id_verification_status           = $nomineeverification;
        $nomineeApplication->is_us_person                     = $areuspersonal;
        $nomineeApplication->details                          = $nomineeDetails;
        $nomineeApplication->chargesfinancial_advisor_details = $investorFai;
        $nomineeApplication->save();

        $successMessage = (Auth::user()->hasPermissionTo('is_wealth_manager')) ? 'Your client account details have been successfully saved.' : 'Account Details have been successfully saved';

        $this->onfidoRequest($investor, $sendSignature, $nomineeverification);
        if ($nomineeApplication->adobe_doc_key == '' && $sendSignature == 'yes') {

            $this->adobeSignataureEmail($investor);

            $successMessage = 'Thank you for your submission to the Investment Account. One of our client services team will be in touch shortly to confirm any additional information that we require.';
        }

        $action="Nominee Application Submitted";
        $activity = saveActivityLog('User',Auth::user()->id,'nominee_application',$investor->id,$action,'',$investor->firm_id);

        Session::flash('success_message', $successMessage);

        return redirect(url('backoffice/investor/' . $giCode . '/investment-account'));

    }

    public function downloadInvestorNominee($giCode)
    {
        $investor = User::where('gi_code', $giCode)->first();
        if (empty($investor)) {
            abort(404);
        }

        $this->getInvestorNomineePdf($investor);

    }

    public function getInvestorNomineePdf($investor)
    {
        $investorPdf                 = new InvestorPdfHtml();
        $dataInvestorNomination      = $investor->getInvestorNomineeData();
        $additionalArgs['pdfaction'] = '';
        $html                        = $investorPdf->getHtmlForNominationApplicationformPdf($dataInvestorNomination, 'nomination', '', $additionalArgs);
        $now_date                    = date('d-m-Y', time());

        $file_name = 'GrowthInvest Client Application Form of ' . $dataInvestorNomination['display_name'] . '  - ' . $now_date . '.pdf';

        $pdf_title = 'GrowthInvest One Client Application Form ';

        $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', array(0, 0, 0, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($html, isset($_GET['vuehtml']));

        $html2pdf->Output($file_name);

    }

    public function onfidoRequest($investor, $sendSignature, $nomineeverification)
    {
        $curInvOnfidoReports = $investor->userOnfidoApplicationReports();

        if (empty($curInvOnfidoReports)) {

            if ((Auth::user()->id == $investor->id && ($nomineeverification == 'yes' || $nomineeverification == "requested")) || (Auth::user()->id != $investor->id && $nomineeverification == "requested")) {

                $onfidoApplicantId = $investor->userOnfidoApplicationId();

                if (empty($onfidoApplicantId)) {

                    if ($sendSignature == 'yes') {
                        $result_onfido = createOnfidoApplicant($investor);

                        $applicant_id = $result_onfido['applicant_id'];

                        if ($applicant_id == '' || $applicant_id == false || is_null($applicant_id)) {
                            $success = false;
                            return $result_onfido;
                        } else {

                            $onfidoApplicantId = $investor->userOnfidoApplicationId();

                            if (empty($onfidoApplicantId)) {
                                $onfidoApplicantId           = new \App\UserData;
                                $onfidoApplicantId->user_id  = $investor->id;
                                $onfidoApplicantId->data_key = 'onfido_applicant_id';
                            }

                            $onfidoApplicantId->data_value = $applicant_id;
                            $onfidoApplicantId->save();

                            $success = true;

                            //add and update report details for the onfido applicant check
                            $check_report_result = $result_onfido['result']['create_checkreports_result'];

                            add_update_onfido_reports_meta($applicant_id, $investor, $check_report_result);
                            if ($result_onfido['onfido_error'] == "yes") {
                                $success = false;
                                return $result_onfido;
                            }

                        }

                    }

                } else {
                    $report_args = array('identity_report_status' => $nomineeverification,
                        'aml_report_status'                           => $nomineeverification,
                    );

                    update_onfido_reports_status($investor, $report_args);
                }

            }

        } else if ($nomineeverification == "completed" || $nomineeverification == "pending_evidence" || $nomineeverification == "manual_kyc") {

            $report_args = array('identity_report_status' => $nomineeverification,
                'aml_report_status'                           => $nomineeverification,
            );

            update_onfido_reports_status($user_id, $report_args);

        }

    }

    public function adobeSignataureEmail($investor)
    {
        $nomineeApplication = $investor->investorNomineeApplication();
        if ($nomineeApplication->adobe_doc_key == false || $nomineeApplication->adobe_doc_key == "") {
            $investorPdf                 = new InvestorPdfHtml();
            $dataInvestorNomination      = $investor->getInvestorNomineeData();
            $additionalArgs['pdfaction'] = 'esign';
            $html                        = $investorPdf->getHtmlForNominationApplicationformPdf($dataInvestorNomination, 'nomination', '', $additionalArgs);
            $now_date                    = date('d-m-Y', time());

            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', array(0, 0, 0, 0));
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($html, isset($_GET['vuehtml']));

            $tmp_foldername = "tmp_nominee_applications";

            $foldername = uniqid("ab1234cde_folder1_a932_");

            if (!file_exists(public_path() . '/userdocs/' . $tmp_foldername)) {

                mkdir(public_path() . '/userdocs/' . $tmp_foldername);

            }

            $destination_dir = public_path() . '/userdocs/' . $tmp_foldername . '/' . $foldername;

            if (!file_exists($destination_dir)) {

                mkdir($destination_dir);
            }

            $output_link       = $destination_dir . '/nominee_application_pdf_' . $now_date . '.pdf';
            $callbackurl       = url('investor/adobe/signed-doc-callback') . '?type=nominee_application';
            $adobesign_message = "Please sign GrownthInvest application form document";
            $adobesign_name    = "GrownthInvest Application Form";

            $html2pdf->Output($output_link, 'F');

            $adobe_sign_args = array(
                'pdf_url'         => $output_link,
                'name'            => $adobesign_name,
                'message'         => $adobesign_message,
                'recipient_email' => $investor->email,
                'ccs'             => 'cinthia@ajency.in',
                'callbackInfo'    => $callbackurl,
            );

            $adobe_echo_sign = new AdobeSignature();
            $dockeyvalue     = $adobe_echo_sign->sendPdfForSignature($adobe_sign_args);

            $nominee_db_dockey = $adobe_echo_sign->getAdobeDocKeys('nominee');

            $nomineeApplication                = $investor->investorNomineeApplication();
            $nomineeApplication->adobe_doc_key = $dockeyvalue;
            $nomineeApplication->save();

        }
    }

    public function updateInvestorNomineePdf(Request $request)
    {
        $eventType = $request->input("eventType");

        if ($eventType == "ESIGNED") {
            $dockey = $request->input("documentKey");

            $response_data   = '';
            $returnd_doc_key = '';

            $type          = 'nominee';
            $adobeechosign = new AdobeSignature();

            $nomineeData = NomineeApplication::where('adobe_doc_key', $dockey)->first();

            if (!empty($nomineeData)) {
                $dockeyUrl                    = $adobeechosign->getAdobeDocUrlByDocKey($dockey);
                $nomineeData->signed_url      = $dockeyUrl;
                $nomineeData->doc_signed_date = date('Y-m-d H:i:s');
                $nomineeData->save();
            }

        }

    }

    public function onfidoWebhook(Request $request)
    {

        $onfidoRequest = $request->all();
        $isReport      = false;
        $isCheck       = false;
        if (isset($onfidoRequest['payload'])) {
            $onfidoPayload = $onfidoRequest['payload'];

            if ($onfidoPayload['resource_type'] == "report" && $onfidoPayload['action'] == "report.completed") {
                //check for response is for report completed
                $reportObj = $onfidoPayload['object'];
                $reportId  = $reportObj['id'];
                $isReport  = true;
                $userData  = UserData::where('data_key', 'onfido_reports')->where('data_value', 'like', '%' . $reportId . '%')->get();

            } else if ($onfidoPayload['resource_type'] == "check" && $onfidoPayload['action'] == "check.completed") {
                $checkObj = $onfidoPayload['object'];
                $checkId  = $checkObj['id'];
                $isCheck  = true;
                $userData = UserData::where('data_key', 'onfido_reports')->where('data_value', 'like', '%' . $checkId . '%')->get();
            }

            foreach ($userData as $userDataValue) {

                $userId         = $userDataValue->user_id;
                $user           = User::find($userId);
                $reportVal      = $userDataValue->data_value;
                $applicantId    = $reportVal['applicant_id'];
                $applicantCheck = $reportVal['check'];

                $applicantCheckDownloadUrl = $applicantCheck['check_download_url'];
                $applicantReports          = $applicantCheck['reports'];

                $applicantReportsUpdated = array();

                if ($isReport) {
                    foreach ($applicantReports as $applicantReport) {

                        if ($reportId == $applicantReport->id) {

                            $newReportStatus = 'completed';

                            $applicantReport->status_growthinvest = $newReportStatus;
                            $reportValName                        = $applicantReport->name;
                        }

                        $applicantReportsUpdated[] = $applicantReport;
                        $reportVal['reports']      = $applicantReportsUpdated;

                    }

                    $userDataValue->data_value = $reportVal;
                    $userDataValue->save();

                } else if ($isCheck) {

                    if ($applicantCheck['id'] == $checkId) {

                        foreach ($applicantReports as $applicantReport) {

                            $newReportStatus                      = 'completed';
                            $applicantReport->status_growthinvest = $newReportStatus;
                            $applicantReportsUpdated[]            = $applicantReport;
                            $reportValNameAr[]                    = $applicantReport->name;
                        }

                        $reportVal['reports']      = $applicantReportsUpdated;
                        $userDataValue->data_value = $reportVal;
                        $userDataValue->save();

                    }

                }

                //update url
                $onfidoInfoReqUrl = $user->userOnfidoInfoReqUrl();
                if (empty($onfidoInfoReqUrl)) {
                    $onfidoInfoReqUrl           = new \App\UserData;
                    $onfidoInfoReqUrl->user_id  = $userId;
                    $onfidoInfoReqUrl->data_key = 'onfido_info_req_url';
                }

                $onfidoInfoReqUrl->data_value = $applicantCheckDownloadUrl;
                $onfidoInfoReqUrl->save();

            }

        }

        return response()->json(['success' => true]);

    }

    public function investorProfile($giCode)
    {
        $investor = User::where('gi_code', $giCode)->first();
        if (empty($investor)) {
            abort(404);
        }

        $investorCertification = $investor->getActiveCertification();

        $breadcrumbs   = [];
        $breadcrumbs[] = ['url' => url('/backoffice/dashboard'), 'name' => "Dashboard"];
        $breadcrumbs[] = ['url' => url('/backoffice/investor'), 'name' => 'Manage Clients'];
        $breadcrumbs[] = ['url' => '', 'name' => 'Manage Investors'];
        $breadcrumbs[] = ['url' => '', 'name' => $investor->displayName()];
        $breadcrumbs[] = ['url' => '', 'name' => 'View Profile'];

        $data['investor']              = $investor;
        $data['investorCertification'] = (!empty($investorCertification)) ? $investorCertification->certification()->name : '';
        $data['breadcrumbs']           = $breadcrumbs;
        $data['pageTitle']             = 'View Profile';
        $data['activeMenu']            = 'manage_clients';

        return view('backoffice.clients.investor-profile')->with($data);

    }

    public function investorInvest(Request $request, $giCode)
    {
        $investor = User::where('gi_code', $giCode)->first();
        if (empty($investor)) {
            abort(404);
        }

        $requestFilters = $request->all();
        if (isset($requestFilters['status'])) {
            $status                   = explode(',', $requestFilters['status']);
            $requestFilters['status'] = array_filter($status);

        }
        //dd($requestFilters);
        $businessListings = new BusinessListing;
        $companyNames     = $businessListings->getCompanyNames();
        $sectors          = getBusinessSectors();
        $managers         = [];
        if (!empty($companyNames)) {
            $compManagers = collect($companyNames->toArray());
            $managers     = $compManagers->pluck('manager')->unique();
            $managers     = array_filter($managers->toArray());
        }

        $breadcrumbs   = [];
        $breadcrumbs[] = ['url' => url('/backoffice/dashboard'), 'name' => "Dashboard"];
        $breadcrumbs[] = ['url' => url('/backoffice/investor'), 'name' => 'Manage Clients'];
        $breadcrumbs[] = ['url' => '', 'name' => 'Manage Investors'];
        $breadcrumbs[] = ['url' => '', 'name' => $investor->displayName()];
        $breadcrumbs[] = ['url' => '', 'name' => 'View Invest Listings'];

        $data['investor']            = $investor;
        $data['companyNames']        = (!empty($companyNames)) ? $companyNames : [];
        $data['investmentOfferType'] = investmentOfferType();
        $data['sectors']             = $sectors;
        $data['managers']            = $managers;
        $data['requestFilters']      = $requestFilters;
        $data['breadcrumbs']         = $breadcrumbs;
        $data['pageTitle']           = 'View Invest Listings';
        $data['activeMenu']          = 'manage_clients';

        return view('backoffice.clients.investor-invest')->with($data);

    }

    public function getInvestorInvest(Request $request)
    {

        $requestData = $request->all(); //dd($requestData);
        $data        = [];
        $skip        = $requestData['start'];
        $length      = $requestData['length'];
        $orderValue  = $requestData['order'][0];
        $filters     = $requestData['filters'];

        $columnOrder = array(
            '0' => 'business_listings.title',
            '1' => 'business_listings.manager',
            '3' => 'business_listings.type',
            '4' => 'business_listings.investment_objective',
            '5' => 'business_listings.target_amount',
            '6' => 'business_listings.minimum_investment',
            '7' => 'amount_raised',
        );

        $columnName = 'business_listings.title';
        $orderBy    = 'asc';

        if (isset($columnOrder[$orderValue['column']])) {
            $columnName = $columnOrder[$orderValue['column']];
            $orderBy    = $orderValue['dir'];
        }

        $orderDataBy = [$columnName => $orderBy];

        $filterBusinessListing = $this->getFilteredBusinessListing($filters, $skip, $length, $orderDataBy);
        $businessListings      = $filterBusinessListing['list'];
        $totalBusinessListings = $filterBusinessListing['totalBusinessListings'];
        $investmentOfferType   = investmentOfferType();

        $businessListingData = [];

        foreach ($businessListings as $key => $businessListing) {

            $businessListingData[] = [
                'offer'       => '<a href="">' . ucfirst($businessListing->title) . '</a>',
                'manager'     => ucfirst($businessListing->manager),
                'tax_status'  => $businessListing->tax_status,
                'type'        => (isset($investmentOfferType[$businessListing->type])) ? ucfirst($investmentOfferType[$businessListing->type]) : '',
                'focus'       => $businessListing->investment_objective,
                'taget_raise' => format_amount($businessListing->target_amount, 0, true),
                'min_inv'     => format_amount($businessListing->minimum_investment, 0, true),
                'amt_raised'  => format_amount($businessListing->amount_raised, 0, true),
                'invest'      => '<a href="#" class="btn btn-primary">Invest</a>',
                'download'    => '<a href="#" class="btn btn-link">Download</a>',

            ];

        }

        $json_data = array(
            "draw"            => intval($requestData['draw']),
            "recordsTotal"    => intval($totalBusinessListings),
            "recordsFiltered" => intval($totalBusinessListings),
            "data"            => $businessListingData,
        );

        return response()->json($json_data);

    }

    public function getFilteredBusinessListing($filters, $skip, $length, $orderDataBy)
    {

        $businessListingQuery = BusinessListing::select(\DB::raw('business_listings.*, SUM(business_investments.amount) as amount_raised'))->where('business_listings.invest_listing', 'yes')->where('business_listings.status', 'publish')->leftjoin('business_investments', function ($join) {
            $join->on('business_listings.id', 'business_investments.business_id');
        })->whereIn('business_investments.status', ['pledged', 'funded']);

        if (isset($filters['company']) && $filters['company'] != "") {
            $businessListingQuery->where('business_listings.id', $filters['company']);
        }

        if (isset($filters['sector']) && $filters['sector'] != "") {
            $businessListingQuery->leftjoin('business_has_defaults', function ($join) {
                $join->on('business_listings.id', 'business_has_defaults.business_id');
            })->where('business_has_defaults.default_id', $filters['sector']);
        }

        if (isset($filters['type']) && $filters['type'] != "") {
            $businessListingQuery->where('business_listings.type', $filters['type']);
        }

        if (isset($filters['manager']) && $filters['manager'] != "") {
            $businessListingQuery->where('business_listings.manager', $filters['manager']);
        }

        if (isset($filters['tax_status']) && $filters['tax_status'] != "") {
            $taxStatus = $filters['tax_status'];
            $taxStatus = explode(',', $taxStatus);
            $taxStatus = array_filter($taxStatus);

            if (in_array('all', $taxStatus)) {
                $taxStatus = array_keys(investmentTaxStatus());
            }

            // $taxStatus = json_encode($taxStatus);
            // echo "JSON_CONTAINS(business_listings.tax_status, '".$taxStatus."' )";
            // $businessListingQuery->whereRaw("JSON_CONTAINS(business_listings.tax_status->status, '".$taxStatus."' )");
            //
            // $businessListingQuery->whereIn("business_listings.tax_status->status", $taxStatus);
            //
            $businessListingQuery->where(function ($bQuery) use ($taxStatus) {
                foreach ($taxStatus as $key => $status) {
                    $statusArr   = [];
                    $statusArr[] = $status;
                    $taxStatus   = json_encode($statusArr);
                    if ($key == 0) {
                        $bQuery->whereRaw("JSON_CONTAINS(business_listings.tax_status, '" . $taxStatus . "' )");
                    } else {
                        $bQuery->orWhereRaw("JSON_CONTAINS(business_listings.tax_status, '" . $taxStatus . "' )");
                    }

                }

            });
        }

        $businessListingQuery->groupBy('business_listings.id');

        foreach ($orderDataBy as $columnName => $orderBy) {
            $businessListingQuery->orderBy($columnName, $orderBy);
        }

        if ($length > 1) {

            $totalBusinessListings = $businessListingQuery->get()->count();
            $businessListing       = $businessListingQuery->skip($skip)->take($length)->get();
        } else {
            $businessListing       = $businessListingQuery->get();
            $totalBusinessListings = $businessListingQuery->count();
        }

        return ['totalBusinessListings' => $totalBusinessListings, 'list' => $businessListing];

    }

    public function investorNewsUpdate($giCode)
    {
        $investor = User::where('gi_code', $giCode)->first();
        if (empty($investor)) {
            abort(404);
        }

        $breadcrumbs   = [];
        $breadcrumbs[] = ['url' => url('/backoffice/dashboard'), 'name' => "Dashboard"];
        $breadcrumbs[] = ['url' => url('/backoffice/investor'), 'name' => 'Manage Clients'];
        $breadcrumbs[] = ['url' => '', 'name' => 'Manage Investors'];
        $breadcrumbs[] = ['url' => '', 'name' => $investor->displayName()];
        $breadcrumbs[] = ['url' => '', 'name' => 'View News/Updates'];

        $data['comments']    = getObjectComments("App\User", $investor->id, 0);
        $data['investor']    = $investor;
        $data['breadcrumbs'] = $breadcrumbs;
        $data['pageTitle']   = 'View News/Updates';
        $data['activeMenu']  = 'manage_clients';

        return view('backoffice.clients.investor-news-update')->with($data);

    }

    public function saveInvestorNewsUpdate(Request $request)
    {
        $requestData = $request->all();
        $query       = $requestData['query'];
        $parentId    = $requestData['parentId'];
        $type        = $requestData['type'];
        $objectType  = $requestData['object-type'];
        $objectId    = $requestData['object-id'];

        $user = Auth::user();

        $comment               = new Comment;
        $comment->data         = $query;
        $comment->author_name  = $user->first_name . '' . $user->last_name;
        $comment->author_email = $user->email;
        $comment->user_id      = $user->id;
        $comment->object_id    = $objectId;
        $comment->object_type  = $objectType;
        $comment->type         = $type;
        $comment->parent       = $parentId;
        $comment->approved     = 1;
        $comment->save();

        $commentView = View::make('backoffice.clients.news-update-content', compact('comment'))->render();
        $json_data   = array(
            'status'       => true,
            'comment_html' => $commentView,

        );

        return response()->json($json_data);
    }

    public function deleteInvestorNewsUpdate(Request $request)
    {
        $requestData = $request->all();

        $commentId = $requestData['commentId'];

        $comment = Comment::find($commentId);

        if (!empty($comment)) {
            $comment->delete();
            $success = true;
        } else {
            $success = false;
        }

        $json_data = array(
            'status' => $success,

        );

        return response()->json($json_data);
    }

    public function investorActivity($giCode)
    {
        $investor = User::where('gi_code', $giCode)->first();
        if (empty($investor)) {
            abort(404);
        }

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
            // '0' => 'business_listings.title',
            // '1' => 'business_listings.manager',
            // '3' => 'business_listings.type',
            // '4' => 'business_listings.investment_objective',
            // '5' => 'business_listings.target_amount',
            // '6' => 'business_listings.minimum_investment',
            // '7' => 'amount_raised',
        );

        $columnName = 'activity.date_recorded';
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
                'user'           => (!empty($activityListing->username)) ? $activityListing->username : '',
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
            $whereStr .= ' and DATE_FORMAT(a1.date_recorded, "%Y-%m-%d") >= "' . $durationDates['fromDate'] . '"';
            $whereStr .= ' and DATE_FORMAT(a1.date_recorded, "%Y-%m-%d") <= "' . $durationDates['toDate'] . '"';

        }

        if ((isset($filters['duration_from']) && $filters['duration_from'] != "") && (isset($filters['duration_to']) && $filters['duration_to'] != "")) {
            $fromDate = date('Y-m-d', strtotime($filters['duration_from']));
            $toDate   = date('Y-m-d', strtotime($filters['duration_to']));
            $whereStr .= ' and DATE_FORMAT(a1.date_recorded, "%Y-%m-%d") >= "' . $fromDate . '"';
            $whereStr .= ' and DATE_FORMAT(a1.date_recorded, "%Y-%m-%d") <= "' . $whereStr . '"';
        }

        if (isset($filters['type']) && $filters['type'] != "") {
            $typeStr .= ' and a1.type = "' . $filters['type'] . '"';
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

        $typeLists = DB::select("select distinct type from activity a1 where 1 " . $whereStr . $typeStr);

        $count             = 0;
        $union             = '';
        $activityListQuery = '';

        $queryCheck = [];

        //for testing
        $filters['user_id'] = 2557;
        foreach ($typeLists as $typeList) {

            if ($typeList->type == "") {
                continue;
            }

            if ($count != 0) {
                $union = " union ";
            }

            $mainselect = "select a1.id,a1.component,a1.type,a1.action,a1.content,a1.primary_link,a1.secondary_item_id";
            $maintable  = " from activity a1 ";
            $orderby    = " order by date_recorded desc";

            if (in_array($typeList->type, ['nominee_application', 'onfido_requested', 'onfido_confirmed', 'certification', 'registration', 'stage1_investor_registration', 'entrepreneur_account_registration', 'fundmanager_account_registration', 'successful_logins', 'download_client_registration_guide',
                'download_investor_csv', 'download_transfer_asset_guide',
                'download_vct_asset_transfer_form', 'download_single_company_asset_transfer_form', 'download_iht_product_asset_transfer_form', 'download_portfolio_asset_transfer_form', 'download_stock_transfer_form', 'submitted_transfers',
                'status_changes_for_asset_transfers', 'transfers_deleted',
                'start_adobe_sign', 'completed_adobe_sign',
                'external_downloads', 'stage_3_profile_details',
                'auth_fail', 'cash_withdrawl', 'cash_deposits'])) {

                if (isset($queryCheck['section1'])) {
                    continue;
                }

                $queryCheck['section1'] = true;
                $customfieldselect      = " ,a1.item_id as user_id,'' as itemname,CONCAT(u1.first_name,' ',u1.last_name) as username ,u1.email as email ,'' as itemid,a1.date_recorded as date_recorded,'' as item_slug";
                $customjoin             = " LEFT OUTER JOIN users u1 on u1.ID=a1.item_id ";
                $customwhere            = $parentChildFirms;
                //overide the condition
                if (isset($filters['user_id']) && $filters['user_id'] != "") {
                    $userWhere = " and a1.item_id='" . $filters['user_id'] . "' ";
                }

                if (isset($filters['type']) && $filters['type'] != "") {
                    $whereStr .= ' and a1.type = "' . $typeList->type . '"';
                }

                $mainjoin  = " LEFT OUTER JOIN business_listings p2 on p2.ID=a1.secondary_item_id";
                $mainwhere = " where 1" . $userWhere . $whereStr . $firmWhere;
                $groupby   = "";

            } elseif (in_array($typeList->type, ['new_provider_added'])) {
                if (isset($queryCheck['section2'])) {
                    continue;
                }

                $queryCheck['section2'] = true;

                $customfieldselect = " ,a1.item_id as user_id,'' as itemname,CONCAT(u1.first_name,' ',u1.last_name) as username ,u1.email as email ,'' as itemid,a1.date_recorded as date_recorded,'' as item_slug";
                $customjoin        = " INNER JOIN users u1 on u1.ID=a1.user_id";
                $customwhere       = $parentChildFirms;
                //overide the condition
                if (isset($filters['user_id']) && $filters['user_id'] != "") {
                    $userwhere = " and a1.item_id='" . $filters['user_id'] . "' ";
                }

                if (isset($filters['type']) && $filters['type'] != "") {
                    $whereStr .= ' and a1.type = "' . $typeList->type . '"';
                }

                $mainwhere = " where 1" . $userWhere . $whereStr . $firmWhere;
                $groupby   = "";
            } elseif (in_array($typeList->type, ['investor_message', 'entrepreneur_message'])) {
                if (isset($queryCheck['section3'])) {
                    continue;
                }

                $queryCheck['section3'] = true;

                $customfieldselect = " ,a1.user_id as user_id,CONCAT(u1.first_name,' ',u1.last_name) as itemname,CONCAT(u2.first_name,' ',u2.last_name) as username ,u2.email as email,a1.item_id as itemid ,a1.date_recorded as date_recorded,'' as item_slug";
                $customjoin        = " INNER JOIN users u1 on u1.ID=a1.item_id INNER JOIN users u2 on u2.ID=a1.user_id";
                $customwhere       = $parentChildFirms;

                //overide the condition
                if (isset($filters['user_id']) && $filters['user_id'] != "") {
                    $userwhere = " and a1.item_id='" . $filters['user_id'] . "' ";
                }

                if (isset($filters['type']) && $filters['type'] != "") {
                    $whereStr .= ' and a1.type = "' . $typeList->type . '"';
                }

                $mainwhere = " where 1" . $userWhere . $whereStr . $firmWhere;
                $groupby   = "";

            } elseif (in_array($typeList->type, ['proposal_details_update', 'fund_details_update'])) {
                if (isset($queryCheck['section4'])) {
                    continue;
                }

                $queryCheck['section4'] = true;

                $customfieldselect = " ,a1.user_id as user_id,p1.title as itemname,CONCAT(u1.first_name,' ',u1.last_name) as username ,u1.email as email,a1.item_id as itemid,max(a1.date_recorded) as date_recorded,p1.slug as item_slug";
                $customjoin        = " INNER JOIN  users u1 on u1.ID=a1.user_id INNER JOIN business_listings p1 on p1.ID=a1.item_id";
                $customwhere       = $parentChildFirms;

                //overide the condition
                if (isset($filters['user_id']) && $filters['user_id'] != "") {
                    $userwhere = " and a1.user_id='" . $filters['user_id'] . "' ";
                }

                if (isset($filters['companies']) && $filters['companies'] != "") {
                    $companyWhere = " and a1.item_id='" . $filters['companies'] . "' ";
                }

                if (isset($filters['type']) && $filters['type'] != "") {
                    $whereStr .= ' and a1.type = "' . $typeList->type . '"';
                }

                $mainwhere = " where  1 " . $userWhere . $companyWhere . $whereStr . $firmWhere;
                $groupby   = " group by a1.component,a1.type,date(a1.date_recorded),a1.secondary_item_id,a1.user_id,a1.item_id";
            } elseif (in_array($typeList->type, ['invested'])) {
                if (isset($queryCheck['section5'])) {
                    continue;
                }

                $queryCheck['section5'] = true;

                $customfieldselect = " ,a1.user_id as user_id,p1.title as itemname,CONCAT(u1.first_name,' ',u1.last_name) as username ,u1.email as email,a1.item_id as itemid,a1.date_recorded as date_recorded,p1.slug as item_slug";
                $customjoin        = " LEFT JOIN users u1 on u1.ID=a1.user_id
                         LEFT JOIN business_listings p1 on p1.ID=a1.item_id";
                $customwhere = $parentChildFirms;

                //overide the condition
                if (isset($filters['user_id']) && $filters['user_id'] != "") {
                    $userwhere = " and a1.user_id='" . $filters['user_id'] . "' ";
                }

                if (isset($filters['companies']) && $filters['companies'] != "") {
                    $companyWhere = " and a1.item_id='" . $filters['companies'] . "' ";
                }

                if (isset($filters['type']) && $filters['type'] != "") {
                    $whereStr .= ' and a1.type = "' . $typeList->type . '"';
                }

                $mainwhere = " where 1 " . $userWhere . $companyWhere . $whereStr . $firmWhere;
                $groupby   = "";
            } else {
                if (isset($queryCheck['section6'])) {
                    continue;
                }

                $queryCheck['section6'] = true;

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

                if (isset($filters['type']) && $filters['type'] != "") {
                    $whereStr .= ' and a1.type = "' . $typeList->type . '"';
                }

                $mainwhere = " where 1 " . $userWhere . $companyWhere . $whereStr . $firmWhere;
                $groupby   = "";
            }

            $activityListQuery .= $union . $mainselect . $customfieldselect . $maintable . $mainjoin . $customjoin . $mainwhere . $customwhere . $groupby;

            $count++;
        }

        if ($length > 1) {
            $totalActivityListings = count(DB::select(DB::raw($activityListQuery)));
            $activityListQuery .= " limit " . $skip . ", " . $length;
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

            $activityId[$activityListing->id] = $activityListing->id;
            $userActivity                     = Activity::find($activityListing->id);
            $investor                         = $userActivity->user;
            $certificationName                = (!empty($investor) && !empty($investor->userCertification()) && !empty($investor->getLastActiveCertification())) ? $investor->getLastActiveCertification()->certification()->name : '';
            $activityMeta                     = (!empty($userActivity->meta()->first())) ? $userActivity->meta()->first()->meta_value : '';

            $activityData[] = [
                (!empty($investor)) ? $investor->gi_code : '',
                '',
                (!empty($investor)) ? title_case($investor->first_name) : '',
                (!empty($investor)) ? title_case($investor->last_name) : '',
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
        $groupList       = ActivityGroup::where('delete', '0')->get();
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

}
