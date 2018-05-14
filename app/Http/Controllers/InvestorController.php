<?php

namespace App\Http\Controllers;

use App\AdobeSignature;
use App\BusinessInvestment;
use App\BusinessListing;
use App\Comment;
use App\Defaults;
use App\Firm;
use App\InvestorPdfHtml;
use App\NomineeApplication;
use App\User;
use App\UserData;
use App\UserHasCertification;
use Auth;
use DB;
use File;
use Illuminate\Http\Request;

//Importing laravel-permission models
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
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
        $data['firm_ids']           = [];
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
            '5' => 'users.created_at',
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

            $firmLink = (!empty($investor->firm)) ? '<a href="' . url('backoffice/firms/' . $investor->firm->gi_code) . '" target="_blank">' . title_case($investor->firm->name) . '</a>' : '';

            $investorsData[] = [
                '#'                     => '<div class="custom-checkbox custom-control"><input type="checkbox" value="' . $investor->id . '" class="custom-control-input ck_investor" name="ck_investor" id="ch' . $investor->id . '"><label class="custom-control-label" for="ch' . $investor->id . '"></label></div> ',
                'name'                  => $nameHtml,
                'certification_date'    => $certificationDate,
                'client_categorisation' => $active,
                'parent_firm'           => $firmLink,
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

        if (isset($filters['firm_ids']) && $filters['firm_ids'] != "") {
            $firmIds = explode(',', $filters['firm_ids']);
            $investorQuery->whereIn('users.firm_id', $firmIds);
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
            $investorQuery->where('user_has_certifications.last_active', '1')->where('user_has_certifications.certification_default_id', $filters['client_category']);

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
                    $query->whereNull('user_has_certifications.certification');
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

        $action   = 'Download Investor CSV';
        $activity = saveActivityLog('User', Auth::user()->id, 'download_investor_csv', Auth::user()->id, $action, '', Auth::user()->firm_id);

        generateCSV($header, $userData, $fileName);

        return true;

    }

    public function registration($firmGiCode = '')
    {

        $investor  = new User;
        $firmCond  = ($firmGiCode != '') ? ['gi_code' => $firmGiCode] : [];
        $firmsList = getModelList('App\Firm', $firmCond, 0, 0, ['name' => 'asc']);
        $firms     = $firmsList['list'];

        $breadcrumbs = [];
        if ($firmGiCode == '') {
            $breadcrumbs[] = ['url' => url('/'), 'name' => "Dashboard"];
            $breadcrumbs[] = ['url' => url('/backoffice/investor'), 'name' => 'Add Clients'];
            $breadcrumbs[] = ['url' => url('/backoffice/investor'), 'name' => 'Investor'];
            $breadcrumbs[] = ['url' => '', 'name' => 'Registration'];

            $data['is_firm_investor'] = 'no';
            $viewFile                 = 'backoffice.clients.registration';
        } else {
            $firm          = Firm::where('gi_code', $firmGiCode)->first();
            $breadcrumbs[] = ['url' => url('/'), 'name' => "Manage"];
            $breadcrumbs[] = ['url' => '/backoffice/firm', 'name' => 'Firm'];
            $breadcrumbs[] = ['url' => '', 'name' => $firm->name];
            $breadcrumbs[] = ['url' => '', 'name' => 'Add User'];

            $data['firm']             = $firm;
            $data['is_firm_investor'] = 'yes';
            $data['firmActiveMenu']   = 'investors';
            $viewFile                 = 'backoffice.firm.investor-registration';
        }

        $data['countyList']              = getCounty();
        $data['countryList']             = getCountry();
        $data['investor']                = $investor;
        $data['firms']                   = $firms;
        $data['investmentAccountNumber'] = '';
        $data['breadcrumbs']             = $breadcrumbs;
        $data['pageTitle']               = 'Add Investor';
        $data['mode']                    = 'edit';
        $data['activeMenu']              = 'add_clients';

        return view($viewFile)->with($data);

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

            $action = "New Registration on " . $firmName;
            saveActivityLog('User', Auth::user()->id, 'stage1_investor_registration', $investorId, $action, '', $investor->firm_id);
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

        $details           = [];
        $addData           = [];
        $certificationName = '';
        if ($requestData['save-type'] == 'retail') {
            $details           = $this->getRetailData($requestData);
            $addData           = ['client_category_id' => $requestData['client_category_id']];
            $certificationName = 'retail Restricted investor';

        } elseif ($requestData['save-type'] == 'sophisticated') {
            $details           = $this->getSophisticatedData($requestData);
            $certificationName = 'sophisticated investor';

        } elseif ($requestData['save-type'] == 'high_net_worth') {
            $details           = $this->getHighNetWorthData($requestData);
            $certificationName = 'high net worth individual';

        } elseif ($requestData['save-type'] == 'professsional_investors') {
            $details           = $this->getProfessionalInvData($requestData);
            $certificationName = 'professional investor';
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

            $certificationName = 'Advised investor';

        } elseif ($requestData['save-type'] == 'elective_prof') {
            $details           = $this->getElectiveProfData($requestData);
            $addData           = ['client_category_id' => $requestData['client_category_id']];
            $certificationName = 'elective professional investor';
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

        $investor->current_certification = $hasCertification->certification_default_id;
        $investor->save();

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
            $registeredBy = $investor->registeredBy->displayName();
        } else {
            $registeredBy = 'N/A';
        }

        $certificationOf = (Auth::user()->id == $investor->id) ? 'Self' : $investor->displayName();
        $certificationBy = (Auth::user()->id == $investor->id) ? 'Self' : Auth::user()->displayName();

        $certification = $hasCertification->certification()->name;

        //new certification
        if (!$invHasCertification) {
            $subject            = 'Notification: Certification of ' . $certificationOf . ' of Firm ' . $firmName . ' has been confirmed.';
            $subjectForinvestor = 'Welcome Investor to ' . $firmName;

            $template            = 'investor-confirmed-certification';
            $templateForinvestor = 'confirmed-certification-to-investor';

        } else {
            //re certification
            $subject            = 'Notification: Re-Certification of ' . $certificationOf . ' of Firm ' . $firmName . ' has been confirmed.';
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
            $data['template_data'] = ['toName' => $recipientName, 'name' => $investor->displayName(), 'firmName' => $firmName, 'registeredBy' => $registeredBy, 'certificationOf' => $certificationOf, 'certificationBy' => $certificationBy, 'certification' => $certification, 'giCode' => $investor->gi_code, 'certificationDate' => $certificationDate, 'certificationExpiryDate' => $expiryDate, 'invHasCertification' => $invHasCertification];
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
            // $filename        = DocumentFile::find($fileId)->file_url;
            // $destination_dir = public_path() . '/userdocs/';

            // $filePath       = $destination_dir . '/' . $filename;
            // $ext            = pathinfo($filePath, PATHINFO_EXTENSION);
            // $mimeType       = getFileMimeType($ext);
            // $file           = \File::get($filePath);

            $certification = $investor->getFiles('certification');
            $filePath      = '';
            $filename      = '';
            $fileid        = '';
            foreach ($certification as $key => $file) {
                $fileid   = $file['id'];
                $filePath = $file['url'];
                $filename = $file['name'];
                $hasImage = true;

            }

            $ext      = pathinfo($filePath, PATHINFO_EXTENSION);
            $mimeType = getFileMimeType($ext);
            $file     = $investor->getSingleFile($fileid);

            $data['attach'] = [['file' => base64_encode($file), 'as' => $filename, 'mime' => $mimeType]];
        }
        sendEmail($templateForinvestor, $data);

        $action   = "Completed Certification " . $certificationName;
        $activity = saveActivityLog('User', Auth::user()->id, 'certification', $investor->id, $action, '', $investor->firm_id);
        $metaData = array('certification' => $certificationName);
        saveActivityMeta($activity->id, 'details', $metaData);

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

        // $docmentFile                = new DocumentFile;
        // $docmentFile->name          = $pdfName . '.pdf';
        // $docmentFile->file_url      = $filename . '.pdf';
        // $docmentFile->uploaded_by   = Auth::user()->id;
        // $docmentFile->document_type = "userdocs";
        // $docmentFile->object_id     = $investor->id;
        // $docmentFile->object_type   = 'App\User';
        // $docmentFile->folder_id     = 1;
        // $docmentFile->save();

        // return $docmentFile->id;

        $uploadedFile = new UploadedFile($outputLink, $filename . '.pdf');

        $id = $investor->uploadFile($uploadedFile, false, $pdfName . '.pdf');
        $investor->remapFiles([$id], 'certification');

        //delete temp file
        if (File::exists($outputLink)) {
            File::delete($outputLink);
        }

        return $id;

    }

    // public function downloadCertification($fileId)
    // {

    //     $docmentFile = DocumentFile::find($fileId);
    //     if (empty($docmentFile)) {
    //         abort(404);
    //     }

    //     $filePath = public_path() . '/userdocs/' . $docmentFile->file_url;
    //     $filename = $docmentFile->name;
    //     header('Content-type: text/csv');
    //     header('Content-Length: ' . filesize($filePath));
    //     header('Content-Disposition: attachment; filename=' . $filename);
    //     while (ob_get_level()) {
    //         ob_end_clean();
    //     }
    //     readfile($filePath);

    //     exit();
    // }

    public function downloadCertification($giCode)
    {

        $investor      = User::where('gi_code', $giCode)->first();
        $certification = $investor->getFiles('certification');
        $filePath      = '';
        $filename      = '';
        $fileid        = '';
        foreach ($certification as $key => $file) {
            $fileid   = $file['id'];
            $filePath = $file['url'];
            $filename = $file['name'];
            $hasImage = true;

        }

        $ext      = pathinfo($filePath, PATHINFO_EXTENSION);
        $mimeType = getFileMimeType($ext);
        $file     = $investor->getSingleFile($fileid);

        return response($file)
            ->header('Content-Type', $mimeType)
            ->header('Content-Description', 'File Transfer')
            ->header('Content-Disposition', "attachment; filename={$filename}")
            ->header('Filename', $filename);
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

        $profilePic             = $investor->getProfilePicture('medium_1x1');
        $data['profilePic']     = $profilePic['url'];
        $data['hasProfilePic']  = $profilePic['hasImage'];
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

        $action   = "Stage 3 Profile Details";
        $activity = saveActivityLog('User', Auth::user()->id, 'stage_3_profile_details', $investor->id, $action, '', $investor->firm_id);

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

        $action   = "Nominee Application Submitted";
        $activity = saveActivityLog('User', Auth::user()->id, 'nominee_application', $investor->id, $action, '', $investor->firm_id);

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

                            addUpdateOnfidoReportsMeta($applicant_id, $investor, $check_report_result);
                            if ($result_onfido['onfido_error'] == "yes") {
                                $success = false;
                                return $result_onfido;
                            }

                        }

                        $action   = "Onfido - Requested";
                        $activity = saveActivityLog('User', Auth::user()->id, 'onfido_requested', $investor->id, $action, '', $investor->firm_id);

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

            $action   = 'Start Adobe Sign';
            $activity = saveActivityLog('User', Auth::user()->id, 'start_adobe_sign', $investor->id, $action, '', $investor->firm_id);

            //delete temp file
            if (File::exists($output_link)) {
                File::delete($output_link);
            }

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

            $action   = 'Completed Adobe Sign';
            $activity = saveActivityLog('User', Auth::user()->id, 'completed_adobe_sign', $nomineeData->user_id, $action);

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

            $action   = 'Onfido - Confirmed';
            $activity = saveActivityLog('User', Auth::user()->id, 'onfido_confirmed', $nomineeData->user_id, $action);

        }

        return response()->json(['success' => true]);

    }

    public function saveOnfidoReportStatus(Request $request)
    {

        $onfidoRequest = $request->all();

        $investor_id             = $onfidoRequest['investor_id'];
        $identity_report_status  = $onfidoRequest['identity_report_status'];
        $aml_report_status       = $onfidoRequest['aml_report_status'];
        $watchlist_report_status = $onfidoRequest['watchlist_report_status'];

        $reports  = array();
        $investor = User::where('gi_code', $investor_id)->first();

        if (empty($investor)) {
            return response()->json(['success' => false]);
        }

        $args = array('identity_report_status' => $identity_report_status,
            'aml_report_status'                    => $aml_report_status,
            'watchlist_report_status'              => $watchlist_report_status,
        );

        $onfido_report_meta = $investor->userOnfidoApplicationReports();

        if (empty($onfido_report_meta)) {

            //echo "one ";

            $investor_onfido_applicant_id = $investor->userOnfidoApplicationId();

            if (!empty($investor_onfido_applicant_id)) {
                // If there is associated applicant id, retrieve check and reports and update the meta
                //echo "two ";
                $investor_onfido_applicant_id = $investor_onfido_applicant_id->data_value;
                $report_data                  = get_onfido_reports_meta_by_applicant_id($investor_onfido_applicant_id, $args);

                if (isset($report_data['check']['reports']) && empty($report_data['check']['reports'])) {

                    $reports                         = createOnfidoReportObject([], $args);
                    $report_data['check']['reports'] = $reports;
                }

                if (isset($report_data['reports']) && empty($report_data['reports'])) {
                    $reports                = createOnfidoReportObject([], $args);
                    $report_data['reports'] = $reports;
                } elseif (!isset($report_data['reports'])) {
                    $reports                = createOnfidoReportObject([], $args);
                    $report_data['reports'] = $reports;
                }

            } else {

                $reports = createOnfidoReportObject([], $args);

                $report_data = array('applicant_id' => '',
                    'check'                             => array('id' => '',
                        'check_status'                                    => '',
                        'check_type'                                      => '',
                        'check_result_url'                                => '',
                        'check_download_url'                              => '',
                        'check_form_url'                                  => '',
                        'check_paused'                                    => '',
                        'reports'                                         => $reports,
                    ),
                    'reports'                           => $reports,
                );

            }

        } // END if($onfido_report_meta==false){
        else {

            $reports = array();

            //echo "four ";

            $report_data = (!empty($onfido_report_meta)) ? $onfido_report_meta->data_value : [];
            // dd($report_data);

            $onfido_check            = $report_data['check'];
            $onfido_reports          = $onfido_check['reports'];
            $watchlist_report_exists = false;

            foreach ($onfido_reports as $key => $value) {

                if ($value->name == "watchlist") {
                    $watchlist_report_exists = true;
                }

                $reports[] = update_onfido_report_status($value, $args);

            }

            if ($watchlist_report_exists == false) {

                $watchlist_report_obj                      = new \stdClass;
                $watchlist_report_obj->name                = 'watchlist';
                $watchlist_report_obj->variant             = 'full';
                $watchlist_report_obj->id                  = '';
                $watchlist_report_obj->status_growthinvest = $watchlist_report_status;
                $reports[]                                 = $watchlist_report_obj;

            }

            $onfido_check['reports'] = $reports;
            $report_data['check']    = $onfido_check;
            $report_data['reports']  = $reports;

        }

        $onfido_report_meta = $investor->userOnfidoApplicationReports();

        if (empty($onfido_report_meta)) {
            $onfido_report_meta           = new \App\UserData;
            $onfido_report_meta->user_id  = $investor->id;
            $onfido_report_meta->data_key = 'onfido_reports';
        }

        $onfido_report_meta->data_value = $report_data;
        $onfido_report_meta->save();

        return response()->json(['success' => true]);

    }

    public function investorProfile($giCode)
    {
        $investor = User::where('gi_code', $giCode)->first();
        if (empty($investor)) {
            abort(404);
        }

        $investorCertification = $investor->getActiveCertification();
        $onfidoReportMeta      = $investor->userOnfidoApplicationReports();
        $onfidoReport          = (!empty($onfidoReportMeta)) ? $onfidoReportMeta->data_value : [];

        $breadcrumbs   = [];
        $breadcrumbs[] = ['url' => url('/backoffice/dashboard'), 'name' => "Dashboard"];
        $breadcrumbs[] = ['url' => url('/backoffice/investor'), 'name' => 'Manage Clients'];
        $breadcrumbs[] = ['url' => '', 'name' => 'Manage Investors'];
        $breadcrumbs[] = ['url' => '', 'name' => $investor->displayName()];
        $breadcrumbs[] = ['url' => '', 'name' => 'View Profile'];

        $profilePic                    = $investor->getProfilePicture('thumb_1x1');
        $data['profilePic']            = $profilePic['url'];
        $data['investor']              = $investor;
        $data['investorCertification'] = (!empty($investorCertification)) ? $investorCertification->certification()->name : '';
        $data['onfidoReports']         = (isset($onfidoReport['check']['reports']) && !empty($onfidoReport['check']['reports'])) ? $onfidoReport['check']['reports'] : [];
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

            $plegedAmount          = BusinessInvestment::select(\DB::raw('SUM(amount) as total_pledged_amount'))->where('status', 'pledged')->where('business_id', $businessListing->id)->groupBy('business_id')->first();
            $totalPledgedAmount    = (!empty($plegedAmount)) ? $plegedAmount->total_pledged_amount : 0;
            $businessListingData[] = [
                'offer'                => '<a href="">' . ucfirst($businessListing->title) . '</a>',
                'manager'              => ucfirst($businessListing->manager),
                'tax_status'           => $businessListing->tax_status,
                'type'                 => (isset($investmentOfferType[$businessListing->type])) ? ucfirst($investmentOfferType[$businessListing->type]) : '',
                'focus'                => $businessListing->investment_objective,
                'taget_raise'          => format_amount($businessListing->target_amount, 0, true),
                'min_inv'              => format_amount($businessListing->minimum_investment, 0, true),
                'amt_raised'           => format_amount($businessListing->amount_raised, 0, true),
                'total_pledged_amount' => format_amount($totalPledgedAmount, 0),
                'invest'               => '<a href="#" class="btn btn-primary">Invest</a>',
                'download'             => '<a href="#" class="btn btn-link">Download</a>',

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

        $businessListingQuery = BusinessListing::select(\DB::raw('business_listings.*, SUM(business_investments.amount) as amount_raised'))->leftjoin('business_investments', function ($join) {
            $join->on('business_listings.id', 'business_investments.business_id')->whereIn('business_investments.status', ['pledged', 'funded']);
        })->where('business_listings.invest_listing', 'yes')->where('business_listings.status', 'publish');

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

        if (isset($filters['investor']) && $filters['investor'] != "") {
            $businessListingQuery->where('business_investments.investor_id', $filters['investor']);
        }

        if (isset($filters['firm']) && $filters['firm'] != "") {
            $businessListingQuery->leftjoin('users', function ($join) {
                $join->on('business_listings.owner_id', 'users.id');
            })->where('users.firm_id', $filters['firm']);
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

    public function investmentOffers(Request $request){
        $requestFilters = $request->all();
        if (isset($requestFilters['status'])) {
            $status                   = explode(',', $requestFilters['status']);
            $requestFilters['status'] = array_filter($status);

        }
        $investor      = new User;
        $investors = $investor->getInvestorUsers();
        $firmsList = getModelList('App\Firm', [], 0, 0, ['name' => 'asc']);
        $firms     = $firmsList['list'];
 
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
        $breadcrumbs[] = ['url' => url('/'), 'name' => "Manage"];
        $breadcrumbs[] = ['url' => '', 'name' => 'Investment Offers'];

        $data['investor']            = $investor;
        $data['companyNames']        = (!empty($companyNames)) ? $companyNames : [];
        $data['investmentOfferType'] = investmentOfferType();
        $data['sectors']             = $sectors;
        $data['managers']            = $managers;
        $data['requestFilters']      = $requestFilters;
        $data['firms']              = $firms;
        $data['investors']          = $investors;
        $data['breadcrumbs']         = $breadcrumbs;
        $data['pageTitle']           = 'Investment Offers';
        $data['activeMenu']          = 'investment_offers';

        return view('backoffice.investments.investments')->with($data);

    }

}
