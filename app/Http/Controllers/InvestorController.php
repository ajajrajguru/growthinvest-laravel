<?php

namespace App\Http\Controllers;

use App\Defaults;
use App\DocumentFile;
use App\User;
use App\UserData;
use App\UserHasCertification;
use Auth;
use Illuminate\Http\Request;

//Importing laravel-permission models
use Illuminate\Support\Facades\Hash;
use Session;
use Spipu\Html2Pdf\Html2Pdf;

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
        $breadcrumbs[] = ['url' => '', 'name' => 'Manage Investors'];

        $data['certificationTypes'] = $certificationTypes;
        $data['clientCategories']   = $clientCategories;
        $data['firms']              = $firms;
        $data['investors']          = $investors;
        $data['breadcrumbs']        = $breadcrumbs;
        $data['pageTitle']          = 'Investors';
        $data['activeMenu']          = 'manage_clients';

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

            $userCertification = $investor->userCertification()->orderBy('created_at', 'desc')->orderBy('active', 'desc')->first();

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
            // $investorQuery->where('user_has_certifications.certification_default_id', $filters['client_category']);

            $investorQuery->whereIn('users.id', function($query)use($filters){
                                $query->select('user_id')
                                ->from(with(new UserHasCertification)->getTable())
                                ->where('certification_default_id', $filters['client_category'])
                                ->orderBy('created_at', 'desc')
                                ->groupBy('user_id');
                            });
            

        }

        if (isset($filters['client_certification']) && $filters['client_certification'] != "") {
            if ($filters['client_certification'] == 'uncertified') {
                // $investorQuery->whereNull('user_has_certifications.created_at');
                $investorQuery->whereNull('user_has_certifications.certification')->orWhere('user_has_certifications.certification','');
            }
            else
            {
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
        $investorQuery->orderBy('user_has_certifications.created_at', 'desc');
        

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

        $data['countyList']              = getCounty();
        $data['countryList']             = getCountry();
        $data['investor']                = $investor;
        $data['firms']                   = $firms;
        $data['investmentAccountNumber'] = '';
        $data['breadcrumbs']             = $breadcrumbs;
        $data['pageTitle']               = 'Add Investor';
        $data['mode']                    = 'edit';
        $data['activeMenu']          = 'add_clients';

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

        $investorCertification           = $investor->getActiveCertification();
        $investorFai = $investor->userFinancialAdvisorInfo();

        $data['investor']                = $investor;
        $data['countyList']              = getCounty();
        $data['countryList']             = getCountry();
        $data['clientCategories']        = $clientCategories;
        $data['certificationTypes']      = certificationTypes();
        $data['investorCertification']   = $investorCertification;  
        $data['investorFai'] = (!empty($investorFai)) ? $investorFai->data_value : []; 
        $data['activeCertificationData'] = (!empty($investorCertification)) ? $investorCertification->certification() : null;
        $data['breadcrumbs']             = $breadcrumbs;
        $data['pageTitle']               = 'Add Investor : Client Categorisation';
        $data['mode']                    = 'view';
        $data['activeMenu']          = 'add_clients';

        return view('backoffice.clients.client-categorisation')->with($data);

    }

    public function saveClientCategorisation(Request $request, $giCode)
    {

        $investor = User::where('gi_code', $giCode)->first();

        if (empty($investor)) {
            abort(404);
        }

        $requestData = $request->all();

        $activeCertification = $investor->getActiveCertification();
        if (!empty($activeCertification)) {
            $activeCertification->active = 0;
            $activeCertification->save();
        }

        $details = [];
        $addData = [];
        if ($requestData['save-type'] == 'retail') {
            $details = $this->getRetailData($requestData);
            $addData = ['client_category_id' => $requestData['client_category_id']];
        } elseif ($requestData['save-type'] == 'sophisticated') {
            $details = $this->getSophisticatedData($requestData);

        } elseif ($requestData['save-type'] == 'high_net_worth') {
            $details = $this->getHighNetWorthData($requestData);
        } elseif ($requestData['save-type'] == 'professsional_investors') {
            $details = $this->getProfessionalInvData($requestData);
        } elseif ($requestData['save-type'] == 'advice_investors') {
            $reqDetails = $this->getAdviceInvestorsData($requestData);

            $details['conditions']          = $reqDetails['conditions'];
            $financialAdvInfoData = $reqDetails['financial_advisor_info'];

            $financialAdvInfo = $investor->userFinancialAdvisorInfo();
            if (empty($financialAdvInfo)) {
                $financialAdvInfo           = new UserData;
                $financialAdvInfo->user_id  = $investor->id;
                $financialAdvInfo->data_key = 'financial_advisor_info';
            }
            $financialAdvInfo->data_value = $financialAdvInfoData;
            $financialAdvInfo->save();
             

        } elseif ($requestData['save-type'] == 'elective_prof') {
            $details = $this->getElectiveProfData($requestData);
            $addData = ['client_category_id' => $requestData['client_category_id']];
        }

        $fileId = $this->generateInvestorCertificationPdf($requestData['save-type'], $details, $investor, $addData);

        $hasCertification = $investor->userCertification()->where('certification_default_id', $requestData['client_category_id'])->first();
        if (empty($hasCertification)) {
            $hasCertification                           = new UserHasCertification;
            $hasCertification->user_id                  = $investor->id;
            $hasCertification->certification_default_id = $requestData['client_category_id'];

        }

        $hasCertification->file_id       = $fileId;
        $hasCertification->certification = $requestData['certification_type'];
        $hasCertification->active        = 1;
        $hasCertification->details       = $details;
        $hasCertification->created_at    = date('Y-m-d H:i:s');
        $hasCertification->save();

        if (!$investor->hasRole('investor')) {
            $investor->removeRole('yet_to_be_approved_investor');
            $investor->assignRole('investor');
        }

        $certificationvalidityHtml = genActiveCertificationValidityHtml($hasCertification, $fileId);

        return response()->json(['success' => true, 'file_id' => $fileId, 'html' => $certificationvalidityHtml]);

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
        $data                           = [];
        $conditionStr                   = $requestData['conditions'];
        $conditionExp                   = explode(',', $conditionStr);
        $data['conditions']             = array_filter($conditionExp);
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
        $header_footer_start_html = $this->getHeaderPageMarkup($args);

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

        if ($type == 'retail') {
            $html .= $this->retailInvestorsHtml($submissionData, $investor, $addData);
            $fileDiaplayName = "Statement for Retail (Restricted) Investor Certification";

        } elseif ($type == 'sophisticated') {
            $html .= $this->sophisticatedCertificationHtml($submissionData, $investor);
            $fileDiaplayName = "Statement for Sophisticated Investor Certification";

        } elseif ($type == 'high_net_worth') {
            $html .= $this->highNetWorthHtml($submissionData, $investor);
            $fileDiaplayName = "Statement for High Net Worth Individual Certification";

        } elseif ($type == 'professsional_investors') {
            $html .= $this->professionInvHtml($submissionData, $investor);
            $fileDiaplayName = "Statement for Professional Investor Certification";

        } elseif ($type == 'advice_investors') {
            $investorFai = $investor->userFinancialAdvisorInfo();
            $submissionData['financial_advisor_info'] = (!empty($investorFai)) ? $investorFai->data_value : [];
            $html .= $this->adviceInvestorsHtml($submissionData, $investor);
            $fileDiaplayName = "Statement for Advised Investor Certification";

        } elseif ($type == 'elective_prof') {
            $html .= $this->getElectiveProfHtml($submissionData, $investor, $addData);
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

        $html2pdf->writeHTML('');
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

    public function getHeaderPageMarkup($args)
    {

        $backtop    = isset($args['backtop']) ? $args['backtop'] : "28mm";
        $backbottom = isset($args['backbottom']) ? $args['backbottom'] : "14mm";
        $backleft   = isset($args['backleft']) ? $args['backleft'] : "14mm";
        $backright  = isset($args['backright']) ? $args['backright'] : "14mm";

        $header_footer_start_html = '<page  ';
        if (isset($args['hideheader'])) {
            $header_footer_start_html .= '  hideheader="' . $args['hideheader'] . '" ';
        }

        if (isset($args['hidefooter'])) {
            $header_footer_start_html .= '  hidefooter="' . $args['hidefooter'] . '" ';
        }

        $header_footer_start_html .= ' backtop="' . $backtop . '" backbottom="' . $backbottom . '" backleft="' . $backleft . '"  backright="' . $backleft . '" style="font-size: 12pt">
    <page_header>
        <table style="border: none; background-color:#FFF; margin:0;"  class="w100per"  >
            <tr>
                <td style="text-align: left;"  class="w100per">
                  <img src="' . url("img/pdf/header-edge-main-cert.png") . '" class="w100per"   />
                </td>
            </tr>
        </table>
    </page_header>
    <page_footer>
        <table style="border: none; background-color:#FFF; width: 100%;  "  >
            <tr>
                <td style="text-align:center;"  class="w100per" >
                  <img src="' . url("img/pdf/footer_ta_pdf-min.png") . '" class="w70per"  style="width: 90%;"/>
                </td>
            </tr>
            <tr>
                <td style="text-align: center;    width: 100%">page [[page_cu]]/[[page_nb]]</td>
            </tr>
        </table>
    </page_footer>';

        return $header_footer_start_html;

    }

    public function sophisticatedCertificationHtml($sophisticatedData, $investor)
    {

        $html = '';

        $sophisticated_option0_checked = (isset($sophisticatedData['terms']) && in_array('sic_option_0', $sophisticatedData['terms'])) ? '<img class="bg-background" src="' . url("img/pdf/cert-tick.jpg") . '"/>' : '<img class="bg-background" src="' . url("img/pdf/cert-untick.jpg") . '"/>';
        $sophisticated_option1_checked = (isset($sophisticatedData['terms']) && in_array('sic_option_1', $sophisticatedData['terms'])) ? '<img class="bg-background" src="' . url("img/pdf/cert-tick.jpg") . '"/>' : '<img class="bg-background" src="' . url("img/pdf/cert-untick.jpg") . '"/>';
        $sophisticated_option2_checked = (isset($sophisticatedData['terms']) && in_array('sic_option_2', $sophisticatedData['terms'])) ? '<img class="bg-background" src="' . url("img/pdf/cert-tick.jpg") . '"/>' : '<img class="bg-background" src="' . url("img/pdf/cert-untick.jpg") . '"/>';
        $sophisticated_option3_checked = (isset($sophisticatedData['terms']) && in_array('sic_option_3', $sophisticatedData['terms'])) ? '<img class="bg-background" src="' . url("img/pdf/cert-tick.jpg") . '"/>' : '<img class="bg-background" src="' . url("img/pdf/cert-untick.jpg") . '"/>';

        $html .= '<table cellpadding="0" cellspacing="10" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">


              <tr style="margin-bottom: 0; padding-bottom: 0;">
              <td class="text-center primary-col" style="font-size: 18px; width: 100%; text-align: center;"><p style="font-size: 18px; font-weight: bold; text-align: center;">Statement of Certified Sophisticated Investor </p></td>
              </tr>
              </table>';
        $html .= '<table cellpadding="0" cellspacing="10" border="1"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; background: #e5f5ff;">

                  <tr style="margin-bottom: 0; padding-bottom: 0;">
                    <td style="width: 30%; background-color: #1C719C; vertical-align: middle; border: none; text-align: center; color: #fff;">

                            <img class="bg-background" src="' . url("img/pdf/05-kaka.png") . '"  style="max-width:100%; height:auto; width: 60px;" /><br>

                                SOPHISTICATED INVESTOR


                     </td>
                     <td style="width: 70%; border:none;">
                        <h4>Sophisticated Investor</h4>
                        <p style="font-size: 15px; margin-bottom: 5px;">You can be considered a Sophisticated Investor if any of the following applies;</p>


                        <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                             <tr>
                             <td style="Width: 3%; vertical-align: top; font-weight: bold;"><p style="font-size: 20px; margin-top: -10; padding-top:0;">.</p></td>
                             <td style="Width: 97%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">You have been a member of a network or syndicate of business angel for at least six months</p></td>
                             </tr>
                         </table>

                         <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                             <tr>
                             <td style="Width: 3%; vertical-align: top; font-weight: bold;"><p style="font-size: 20px; margin-top: -10; padding-top:0;">.</p></td>
                             <td style="Width: 97%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">You have made more than one investment in an unlisted company in the last two years</p></td>
                             </tr>
                         </table>

                         <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                             <tr>
                             <td style="Width: 3%; vertical-align: top; font-weight: bold;"><p style="font-size: 20px; margin-top: -10; padding-top:0;">.</p></td>
                             <td style="Width: 97%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">You have worked in the private equity SME finance sector in the last two years</p></td>
                             </tr>
                         </table>

                         <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                             <tr>
                             <td style="Width: 3%; vertical-align: top; font-weight: bold;"><p style="font-size: 20px; margin-top: -10; padding-top:0;">.</p></td>
                             <td style="Width: 97%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">You have been a director of a company with annual turnover in excess of £1m in the last two years</p></td>
                             </tr>
                         </table>

                     </td>
                  </tr></table>';

        $html .= '<table cellpadding="0" cellspacing="10" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">

                  <tr style="margin-bottom: 0; padding-bottom: 0;">
                    <td style="width: 100%;">

                            &nbsp;


                     </td>

                  </tr></table>';

        $html .= '<table cellpadding="0" cellspacing="0" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">

                  <tr style="margin-bottom: 0; padding-bottom: 0;">
                  <td style="width: 100%;">


                  <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >

                        <tr>
                             <td colspan="2" style="width: 100%; font-size: 15px;">
                             I qualify as a Sophisticated investor and thus exempt under article 50(A) of the Financial Services and Markets Act 2000 after signing this prescribed template with relevant risk warnings and I meet at least one of the following criteria.
                             </td>
                         </tr>




                         <tr>
                         <td style="Width: 5%;">' . $sophisticated_option0_checked . '</td>
                         <td style="Width: 95%; font-size: 14px; margin-bottom: 20px;">I have been a member of a network or syndicate of business angels for at least the six months preceding the date of the certificate</td>
                         </tr>



                        <tr>
                         <td style="Width: 5%;">' . $sophisticated_option1_checked . '</td>
                         <td style="Width: 95%; font-size: 14px;">I have made more than one investment in an unlisted company in the two years preceding that date</td>
                         </tr>



                         <tr>
                         <td style="Width: 5%;">' . $sophisticated_option2_checked . '</td>
                         <td style="Width: 95%; font-size: 14px;">I have worked, in the two years preceding that date, in a professional capacity in the private equity sector, or in the provision of finance for small and medium enterprises</td>
                         </tr>



                         <tr>
                         <td style="Width: 5%;">' . $sophisticated_option3_checked . '</td>
                         <td style="Width: 95%; font-size: 14px;">I have been, in the two years preceding that date, a director of a company with an annual turnover of at least £1 million</td>
                         </tr>

                         </table>


                  </td>
                  </tr></table>';

        $html .= '<table cellpadding="0" cellspacing="0" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">

                  <tr style="margin-bottom: 0; padding-bottom: 0;">
                  <td style="width: 100%;">


                  <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >

                        <tr>
                             <td style="width: 100%;">
                             <p style="font-size: 15px; margin-bottom: 5px;">The financial products that are covered in the exemptions (articles 48 and 50A) only apply to certain types of investment:</p>

                            <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 3%; vertical-align: top; font-weight: bold;"><p style="font-size: 20px; margin-top: -10; padding-top:0;">.</p></td>
                                 <td style="Width: 97%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">Shares or stock in unlisted companies</p></td>
                                 </tr>
                             </table>

                            <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 3%; vertical-align: top; font-weight: bold;"><p style="font-size: 20px; margin-top: -10; padding-top:0;">.</p></td>
                                 <td style="Width: 97%; vertical-align: top;"><p style="font-size: 14px; margin-top: 0; padding-top:0;">Collective investment schemes, where the underlying investment is in unlisted company shares or stock</p></td>
                                 </tr>
                             </table>

                             <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                                 <tr>
                                 <td style="Width: 3%; vertical-align: top; font-weight: bold;"><p style="font-size: 20px; margin-top: -10px; padding-top:0;">.</p></td>
                                 <td style="Width: 97%; vertical-align: top;"><p style="font-size: 14px; margin-top: 0; padding-top:0;">Options, futures and contracts for differences that relate to unlisted shares or stock.</p></td>
                                 </tr>
                             </table>

                             </td>
                         </tr>

                    </table>


                  </td>
                  </tr></table><br>';

        $html .= '<table cellpadding="0" cellspacing="1" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">



        <tr>
             <td style="width: 100%;">
             <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                 <tr>
                 <td style="Width: 5%; vertical-align: top;">';

        if (isset($sophisticatedData['conditions']) && in_array('si_check_0', $sophisticatedData['conditions'])) {
            $html .= '<img class="bg-background" src="' . url("img/pdf/cert-tick.jpg") . '"/>';
        } else {
            $html .= '<img class="bg-background" src="' . url("img/pdf/cert-untick.jpg") . '"/>';
        }

        $html .= '     </td>
                 <td style="Width: 95%; vertical-align: top;"><p style="font-size: 14px; font-weight: bold; margin-top: 0; padding-top:0;">I accept that the investments to which the promotions will relate may expose me to a significant risk of losing all of the money or other assets invested. I am aware that it is open to me to seek advice from an authorised person who specialises in advising on non-readily realisable securities.</p></td>
                 </tr>
             </table>

             <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                 <tr>
                 <td style="Width: 5%; vertical-align: top;">';

        if (isset($sophisticatedData['conditions']) && in_array('si_check_1', $sophisticatedData['conditions'])) {
            $html .= '<img class="bg-background" src="' . url("img/pdf/cert-tick.jpg") . '"/>';
        } else {
            $html .= '<img class="bg-background" src="' . url("img/pdf/cert-untick.jpg") . '"/>';
        }

        $html .= '    </td>
                 <td style="Width: 95%;  vertical-align: top;"><p style="font-size: 14px; font-weight: bold; margin-top: 0; padding-top:0;">I wish to be treated as a sophisticated investor and have a certificate that can be made available for presentation by my accountant or Financial Adviser or lawyer (on request).</p></td>
                 </tr>
             </table>

             <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                 <tr>
                 <td style="Width: 5%; vertical-align: top;">';

        if (isset($sophisticatedData['conditions']) && in_array('si_check_2', $sophisticatedData['conditions'])) {
            $html .= '<img class="bg-background" src="' . url("img/pdf/cert-tick.jpg") . '"/>';
        } else {
            $html .= '<img class="bg-background" src="' . url("img/pdf/cert-untick.jpg") . '"/>';
        }
        $html .= '     </td>
                 <td style="Width: 95%;  vertical-align: top;"><p style="font-size: 14px; margin-top: 0; padding-top:0; font-weight: bold;">I have read and understand the risk warning.</p></td>
                 </tr>
             </table>


             </td>
         </tr>

    </table>';

        $html .= ' <br><b>Name: </b>' . $investor->first_name . ' ' . $investor->last_name;

        $html .= ' <br><b>Date: </b>' . date('d/m/Y');

        return $html;

    }

    public function retailInvestorsHtml($retailData, $investor, $addData)
    {
        $clientCategory   = Defaults::find($addData['client_category_id']);
        $getQuestionnaire = $clientCategory->getCertificationQuesionnaire();

        $html = '';

        $html .= '<table cellpadding="0" cellspacing="10" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">


              <tr style="margin-bottom: 0; padding-bottom: 0;">
              <td class="text-center primary-col" style="font-size: 18px; width: 100%; text-align: center;"><p style="font-size: 18px; font-weight: bold; text-align: center;">Statement of Certified Retail (Restricted) Investor </p></td>
              </tr>
              </table>';

        $html .= '<table cellpadding="0" cellspacing="10" border="1"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; background: #e5f5ff;">

              <tr style="margin-bottom: 0; padding-bottom: 0;">
                <td style="width: 30%; background-color: #1C719C; vertical-align: middle; border: none; text-align: center; color: #fff;">

                        <img class="bg-background" src="' . url("img/pdf/03-money-hand.png") . '" style="max-width:100%; height:auto; width: 60px;"><br>

                            RETAIL (RESTRICTED) INVESTOR


                 </td>
                 <td style="width: 70%; border:none;">
                    <h4>Retail (Restricted) Investor Statement</h4>
                    <p style="font-size: 15px; margin-bottom: 5px;">Retail (restricted) investors must declare that they are not investing more than 10% of their net assets (including savings, stocks, ISAs, bonds and property; excluding your primary residence) into unquoted companies as a result of using GrowthInvest.</p>




                 </td>
              </tr></table>';

        $html .= '<table cellpadding="0" cellspacing="10" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; ">

              <tr style="margin-bottom: 0; padding-bottom: 0;">
               <td style="width: 100%; border:none;">

               <p style="font-size: 15px; margin-bottom: 5px;">I make this statement so that I can receive promotional communications relating to non-readily realisable securities as a retail (restricted) investor. I declare that I qualify as a retail (restricted) investor because:</p>
               <table style="width: 100%; margin-bottom: 0; padding-bottom: 0; margin-left: 15px;" class="no-spacing" >
                     <tr>
                     <td style="Width: 3%; vertical-align: top; font-weight: bold;"><p style="font-size: 20px; margin-top: -10; padding-top:0;">.</p></td>
                     <td style="Width: 97%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">In the preceding twelve months, I have not invested more than 10% of my net assets in non-readily realisable securities; and </p></td>
                     </tr>
                 </table>

                <table style="width: 100%; margin-bottom: 0; padding-bottom: 0; margin-left: 15px;" class="no-spacing" >
                     <tr>
                     <td style="Width: 3%; vertical-align: top; font-weight: bold;"><p style="font-size: 20px; margin-top: -10; padding-top:0;">.</p></td>
                     <td style="Width: 97%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">I undertake that in the next twelve months I will not invest more than 10% of my net assets in non-readily realisable securities.</p></td>
                     </tr>
                 </table>



                 <p style="font-size: 15px; margin-bottom: 5px;">Net assets for these purposes do not include:</p>




                 <table style="width: 100%; margin-bottom: 0; padding-bottom: 0; margin-left: 15px;" class="no-spacing" >
                     <tr>
                     <td style="Width: 3%; vertical-align: top; font-weight: bold;"><p style="font-size: 20px; margin-top: -10; padding-top:0;">.</p></td>
                     <td style="Width: 97%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">The property which is my primary residence or any money raised through a loan secured on that property;&nbsp;</p></td>
                     </tr>
                 </table>

                <table style="width: 100%; margin-bottom: 0; padding-bottom: 0; margin-left: 15px;" class="no-spacing" >
                     <tr>
                     <td style="Width: 3%; vertical-align: top; font-weight: bold;"><p style="font-size: 20px; margin-top: -10; padding-top:0;">.</p></td>
                     <td style="Width: 97%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">Any rights of mine under a qualifying contract of insurance; OR </p></td>
                     </tr>
                 </table>

                 <table style="width: 100%; margin-bottom: 0; padding-bottom: 0; margin-left: 15px;" class="no-spacing" >
                     <tr>
                     <td style="Width: 3%; vertical-align: top; font-weight: bold;"><p style="font-size: 20px; margin-top: -10; padding-top:0;">.</p></td>
                     <td style="Width: 97%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">Any benefits (in the form of pensions or otherwise) which are payable on the termination of my service or on my death or retirement and to which I am (or my dependants are), or may be entitled.</p></td>
                     </tr>
                 </table>

               </td>
              </tr>
              </table>';

        $html .= '<table cellpadding="0" cellspacing="10" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; ">

              <tr style="margin-bottom: 0; padding-bottom: 0;">
               <td style="width: 100%; border:none;">



               </td>
               </tr>
               </table>';

        $html .= '<table cellpadding="0" cellspacing="5" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; font-size: 14px;">';
        $quest_count = 1;

        foreach ($getQuestionnaire as $getQuestion) {

            if ($quest_count == 4) {
                $html .= '<tr style="margin-bottom: 0; padding-bottom: 0;">
                    <td colspan="4"> <br/><br><br><br> </td>

                </tr> ';
            }

            $html .= '<tr style="margin-bottom: 0; padding-bottom: 0;">
            <td width="3%">' . $quest_count . '</td>
            <td colspan="3">' . $getQuestion->questions . '
            </td>
        </tr>';

            foreach ($getQuestion->options as $option) {

                $quiz_option_selected = '<img class="bg-background" src="' . url("img/pdf/cert-untick.jpg") . '"/>';
                if ($option->correct) {
                    $quiz_option_selected = ' <img class="bg-background" src="' . url("img/pdf/cert-tick.jpg") . '"/>';
                }
                $html .= '<tr style="margin-bottom: 0; padding-bottom: 0;">
            <td width="3%"></td>
            <td width="3%">
                ' . $quiz_option_selected . '
            </td>
            <td width="2%">
            </td>
            <td width="92%">' . $option->label . '</td>


        </tr> ';

            }
            $html .= '<tr>
                <td>&nbsp;</td>
            </tr>';

            $quest_count++;

        }
        $html .= '</table>';

        $html .= '<table cellpadding="0" cellspacing="10" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">

              <tr style="margin-bottom: 0; padding-bottom: 0;">
                 <td style="width: 100%; border:none;">



                    <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 5%; vertical-align: top;">';

        if (isset($retailData['conditions']) && in_array('ri_check_1', $retailData['conditions'])) {
            $html .= '<img class="bg-background" src="' . url("img/pdf/cert-tick.jpg") . '"/>';
        } else {
            $html .= '<img class="bg-background" src="' . url("img/pdf/cert-untick.jpg") . '"/>';
        }
        $html .= '
                         </td>
                         <td style="Width: 95%; vertical-align: top; font-weight: bold;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">I  accept that the investments to which the promotions will relate may expose me to a significant risk of losing all of the money or other assets invested. I am aware that it is open to me to seek advice from an authorised person who specialises in advising on non-readily realisable securities.</p></td>
                         </tr>
                     </table>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 5%; vertical-align: top;">';

        if (isset($retailData['conditions']) && in_array('ri_check_2', $retailData['conditions'])) {
            $html .= '<img class="bg-background" src="' . url("img/pdf/cert-tick.jpg") . '"/>';
        } else {
            $html .= '<img class="bg-background" src="' . url("img/pdf/cert-untick.jpg") . '"/>';
        }

        $html .= '
                         </td>
                         <td style="Width: 95%; vertical-align: top; font-weight: bold;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">I wish to be treated as a Retail (Restricted) Investor.</p></td>
                         </tr>
                     </table>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 5%; vertical-align: top;">';

        if (isset($retailData['conditions']) && in_array('ri_check_3', $retailData['conditions'])) {
            $html .= '<img class="bg-background" src="' . url("img/pdf/cert-tick.jpg") . '"/>';
        } else {
            $html .= '<img class="bg-background" src="' . url("img/pdf/cert-untick.jpg") . '"/>';
        }
        $html .= '
                         </td>
                         <td style="Width: 95%; vertical-align: top; font-weight: bold;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">I have read and understand the risk warning.</p></td>
                         </tr>
                     </table>



                 </td>
              </tr></table><br><br>';

        $html .= ' <br><b>Name: </b>' . $investor->first_name . ' ' . $investor->last_name;

        $html .= ' <br><b>Date: </b>' . date('d/m/Y');

        return $html;

    }

    public function highNetWorthHtml($highNetData, $investor)
    {

        $highnetworth_option0_checked = (isset($highNetData['terms']) && in_array('sic_option_0', $highNetData['terms'])) ? '<img class="bg-background" src="' . url("img/pdf/cert-tick.jpg") . '"/>' : '<img class="bg-background" src="' . url("img/pdf/cert-untick.jpg") . '"/>';
        $highnetworth_option1_checked = (isset($highNetData['terms']) && in_array('sic_option_1', $highNetData['terms'])) ? '<img class="bg-background" src="' . url("img/pdf/cert-tick.jpg") . '"/>' : '<img class="bg-background" src="' . url("img/pdf/cert-untick.jpg") . '"/>';

        $html = '';

        $html .= '<table cellpadding="0" cellspacing="10" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">


              <tr style="margin-bottom: 0; padding-bottom: 0;">
              <td class="text-center primary-col" style="font-size: 18px; width: 100%; text-align: center;"><p style="font-size: 18px; font-weight: bold; text-align: center;">Statement of Certified High Net Worth Individual</p></td>
              </tr>
              </table>';

        $html .= '<table cellpadding="0" cellspacing="10" border="1"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; background: #e5f5ff;">

                  <tr style="margin-bottom: 0; padding-bottom: 0;">
                    <td style="width: 30%; background-color: #1C719C; vertical-align: middle; border: none; text-align: center; color: #fff;">

                            <img class="bg-background" src="' . url("img/pdf/01-piggybank.png") . '"  style="max-width:100%; height:auto; width: 60px;" /><br>

                                HIGH NET WORTH INDIVIDUALS


                     </td>
                     <td style="width: 70%; border:none;">
                        <h4>High Net Worth Individuals</h4>
                        <p style="font-size: 15px; margin-bottom: 5px;">High Net-Worth Individuals ("HNWI") are exempt under article 48 of the FSMA 2000 if they have signed a prescribed template with relevant risk warnings that they have over £100 000 p.a income and net assets excluding primary residence of over £250,000</p>




                     </td>
                  </tr></table>';

        $html .= '<table cellpadding="0" cellspacing="10" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">

                  <tr style="margin-bottom: 0; padding-bottom: 0;">
                    <td style="width: 100%;">
                            &nbsp;
                     </td>
                  </tr></table>';

        $html .= '<table cellpadding="0" cellspacing="10" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; ">

                <tr style="margin-bottom: 0; padding-bottom: 0;">

                     <td style="width: 100%; border:none;">
                     <p style="margin-bottom: 5px; font-size: 15px;">
                        I am a certified high net worth individual because at least one of the following applies:
                        </p>
                     </td>
                  </tr>

                <tr style="margin-bottom: 0; padding-bottom: 0;">

                     <td style="width: 100%; border:none;">
                        <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                             <tr>
                                <td style="Width: 5%;">' . $highnetworth_option0_checked . '</td>
                                <td style="Width: 95%; font-size: 14px; margin-bottom: 20px;"> I had, during the financial year immediately preceding the date below, an annual income to the value of £100,000 or more;</td>
                             </tr>
                         </table>

                         <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                             <tr>
                             <td style="Width: 5%;">' . $highnetworth_option1_checked . '</td>
                            <td style="Width: 95%; font-size: 14px;">I held, throughout the financial year immediately preceding the date below, net assets to the value of £250,000 or more. Net assets for these purposes do not include:</td>
                             </tr>
                         </table>


                     </td>
                  </tr>



                <tr style="margin-bottom: 0; padding-bottom: 0;">
                     <td style="width: 100%; border:none;">
                        <table style="width: 100%; margin-bottom: 0; padding-bottom: 0; margin-left: 15px;" class="no-spacing" >
                             <tr>
                             <td style="Width: 5%; vertical-align: top;">(i)</td>
                             <td style="Width: 95%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">The property which is my client\'s primary residence or any loan secured on that residence;</p></td>
                             </tr>
                         </table>

                         <table style="width: 100%; margin-bottom: 0; padding-bottom: 0; margin-left: 15px;" class="no-spacing" >
                             <tr>
                             <td style="Width: 5%; vertical-align: top;">(ii)</td>
                             <td style="Width: 95%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">Any rights of my client\'s are under a qualifying contract of insurance within the meaning of the Financial Services and Markets Act 2000 (Regulated Activities) Order 2001; or</p></td>
                             </tr>
                         </table>

                         <table style="width: 100%; margin-bottom: 0; padding-bottom: 0; margin-left: 15px;" class="no-spacing" >
                             <tr>
                             <td style="Width: 5%; vertical-align: top;">(iii)</td>
                             <td style="Width: 95%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">Any benefits (in the form of pensions or otherwise) which are payable on the termination of my client service or on his/her death or retirement and to which he/she (or dependants are), or may be entitled.</p></td>
                             </tr>
                         </table>
                     </td>
                  </tr>

                  <tr style="margin-bottom: 0; padding-bottom: 0;">

                     <td style="width: 100%; border:none;">

                        <p style="font-size: 15px; margin-bottom: 5px;">By agreeing to be categorised as a HNWI, you agree to be communicated financial promotions of certain types of investments, principally;</p>


                        <table style="width: 100%; margin-bottom: 0; padding-bottom: 0; margin-left: 15px;" class="no-spacing" >
                             <tr>
                             <td style="Width: 3%; vertical-align: top; font-weight: bold;"><p style="font-size: 20px; margin-top: -10; padding-top:0;">.</p></td>
                             <td style="Width: 97%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">Shares or stock in unlisted companies</p></td>
                             </tr>
                         </table>

                         <table style="width: 100%; margin-bottom: 0; padding-bottom: 0; margin-left: 15px;" class="no-spacing" >
                             <tr>
                             <td style="Width: 3%; vertical-align: top; font-weight: bold;"><p style="font-size: 20px; margin-top: -10; padding-top:0;">.</p></td>
                             <td style="Width: 97%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">Collective investment schemes, where the underlying investment is in unlisted company shares or stock</p></td>
                             </tr>
                         </table>

                         <table style="width: 100%; margin-bottom: 0; padding-bottom: 0; margin-left: 15px;" class="no-spacing" >
                             <tr>
                             <td style="Width: 3%; vertical-align: top; font-weight: bold;"><p style="font-size: 20px; margin-top: -10; padding-top:0;">.</p></td>
                             <td style="Width: 97%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">Options, futures and contracts for differences that relate to unlisted shares or stock</p></td>
                             </tr>
                         </table>
                     </td>
                  </tr>

                  <tr style="margin-bottom: 0; padding-bottom: 0;">
                     <td style="width: 100%; border:none;">
                        <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                             <tr>
                             <td style="Width: 5%; vertical-align: top;">';

        if (isset($highNetData['conditions']) && in_array('hi_check_0', $highNetData['conditions'])) {
            $html .= '<img class="bg-background" src="' . url("img/pdf/cert-tick.jpg") . '"/>';
        } else {
            $html .= '<img class="bg-background" src="' . url("img/pdf/cert-untick.jpg") . '"/>';
        }

        $html .= '
                        </td>
                        <td style="Width: 95%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0; font-weight: bold;">I accept that the investments to which the promotions will relate may expose me to a significant risk of losing all of the money or other assets invested. I am aware that it is open to me to seek advice from an authorised person who specialises in advising on non-readily realisable securities.</p></td>
                         </tr>
                     </table>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 5%; vertical-align: top;">';

        if (isset($highNetData['conditions']) && in_array('hi_check_1', $highNetData['conditions'])) {
            $html .= '<img class="bg-background" src="' . url("img/pdf/cert-tick.jpg") . '"/>';
        } else {
            $html .= '<img class="bg-background" src="' . url("img/pdf/cert-untick.jpg") . '"/>';
        }

        $html .= '</td>
                         <td style="Width: 95%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0; font-weight: bold;">I wish to be treated as a HNWI and have a certificate that can be made available for presentation by my accountant or lawyer (on request).</p></td>
                         </tr>
                     </table>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 5%; vertical-align: top;">';

        if (isset($highNetData['conditions']) && in_array('hi_check_2', $highNetData['conditions'])) {
            $html .= '<img class="bg-background" src="' . url("img/pdf/cert-tick.jpg") . '"/>';
        } else {
            $html .= '<img class="bg-background" src="' . url("img/pdf/cert-untick.jpg") . '"/>';
        }

        $html .= ' </td>
                         <td style="Width: 95%; vertical-align: top; font-weight: bold;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">I have read and understand the risk warning.</p></td>
                         </tr>
                     </table>
                 </td>
              </tr>
              </table><br><br>';

        $html .= ' <br><b>Name: </b>' . $investor->first_name . ' ' . $investor->last_name;

        $html .= ' <br><b>Date: </b>' . date('d/m/Y');

        return $html;

    }

    public function professionInvHtml($professionInvData, $investor)
    {

        $html = '';

        $html .= '<table cellpadding="0" cellspacing="10" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">


      <tr style="margin-bottom: 0; padding-bottom: 0;">
      <td class="text-center primary-col" style="font-size: 18px; width: 100%; text-align: center;"><p style="font-size: 18px; font-weight: bold; text-align: center;">Statement of Certified Professional Investor </p></td>
      </tr>
      </table>';

        $html .= '<table cellpadding="0" cellspacing="10" border="1"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; background: #e5f5ff;">

                  <tr style="margin-bottom: 0; padding-bottom: 0;">
                    <td style="width: 30%; background-color: #1C719C; vertical-align: middle; border: none; text-align: center; color: #fff;">

                            <img class="bg-background" src="' . url("img/pdf/02-people.png") . '"  style="max-width:100%; height:auto; width: 60px; "  /><br>

                                PROFESSIONAL INVESTOR


                     </td>
                     <td style="width: 70%; border:none;">
                        <h4>Professional Investor</h4>
                        <p style="font-size: 15px; margin-bottom: 5px;">A Professional Investor is an investor whom is not designated as a Retail (Restricted) Investor as per the FCA Conduct of Business Handbook https://fshandbook.info/FS/print/FCA/COBS/3 .  If you fall into one of the below categories then you will qualify as a professional investor. As a professional investor GrowthInvest is able to communicate with you directly in relation to investment business.</p>




                     </td>
                  </tr></table>';

        $html .= '<table cellpadding="0" cellspacing="10" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">

    <tr style="margin-bottom: 0; padding-bottom: 0;">

     <td style="width: 100%; border:none;">
        <p>Investment professionals are exempt under Article 14 of the of the Financial Services and Markets Act 2000 (Promotion of Collective Investment Scheme) (Exemptions) Order 2001:</p>
        <ol  style="list-style-type: lower-alpha; font-size: 14px;">
            <li style="line-height: 16px;">  an authorised person;</li>
            <li style="line-height: 16px;">  an exempt person where the communication relates to a controlled activity which is a regulated activity in relation to which the person is exempt;</li>
            <li style="line-height: 16px;">  any other person—
                <ol   style="list-style-type: lower-roman; font-size: 14px;">
                    <li style="line-height: 16px;"> whose ordinary activities involve him in carrying on the controlled activity to which the communication relates for the purpose of a business carried on by him; or </li>
                    <li style="line-height: 16px;"> who it is reasonable to expect will carry on such activity for the purposes of a business carried on by him; </li>
                </ol>
            </li>
            <li style="line-height: 16px;">  a government, local authority (whether in the United Kingdom or elsewhere) or an international organisation;</li>
            <li style="line-height: 16px;">  a person ("A") who is a director, officer or employee of a person ("B") falling within any of subparagraphs (a) to (d) where the communication is made to A in that capacity and where A’s responsibilities when acting in that capacity involve him in the carrying on by B of controlled activities.</li>
        </ol>




     </td>
    </tr></table>';

        $html .= '<table cellpadding="0" cellspacing="10" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">

                  <tr style="margin-bottom: 0; padding-bottom: 0;">
                     <td style="width: 100%; border:none;">



                        <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                             <tr>
                             <td style="Width: 5%; vertical-align: top;">';

        if (isset($professionInvData['conditions']) && in_array('pi_check_1', $professionInvData['conditions'])) {
            $html .= '<img class="bg-background" src="' . url("img/pdf/cert-tick.jpg") . '"/>';
        } else {
            $html .= '<img class="bg-background" src="' . url("img/pdf/cert-untick.jpg") . '"/>';
        }
        $html .= '
                            </td>
                            <td style="Width: 95%; vertical-align: top; font-weight: bold;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">I accept that the investments to which the promotions will relate may expose me to a significant risk of losing all of the money or other assets invested. I am aware that it is open to me to seek advice from an authorised person who specialises in advising on non-readily realisable securities.</p></td>
                             </tr>
                         </table>

                         <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                             <tr>
                             <td style="Width: 5%; vertical-align: top;">';

        if (isset($professionInvData['conditions']) && in_array('pi_check_1', $professionInvData['conditions'])) {
            $html .= '<img class="bg-background" src="' . url("img/pdf/cert-tick.jpg") . '"/>';
        } else {
            $html .= '<img class="bg-background" src="' . url("img/pdf/cert-untick.jpg") . '"/>';
        }

        $html .= '
                             </td>
                             <td style="Width: 95%; vertical-align: top; font-weight: bold;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">I wish to be treated as an professional investor.</p></td>
                             </tr>
                         </table>

                         <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                             <tr>
                             <td style="Width: 5%; vertical-align: top;">';

        if (isset($professionInvData['conditions']) && in_array('pi_check_2', $professionInvData['conditions'])) {
            $html .= '<img class="bg-background" src="' . url("img/pdf/cert-tick.jpg") . '"/>';
        } else {
            $html .= '<img class="bg-background" src="' . url("img/pdf/cert-untick.jpg") . '"/>';
        }

        $html .= '
                             </td>
                             <td style="Width: 95%; vertical-align: top; font-weight: bold;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">I have read and understand the risk warning.</p></td>
                             </tr>
                         </table>



                     </td>
                  </tr></table><br><br>';

        $html .= ' <br><b>Name: </b>' . $investor->first_name . ' ' . $investor->last_name;

        $html .= ' <br><b>Date: </b>' . date('d/m/Y');

        return $html;

    }

    public function adviceInvestorsHtml($adviceInvData, $investor)
    {

        $html = '';

        $html .= '<table cellpadding="0" cellspacing="10" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">


      <tr style="margin-bottom: 0; padding-bottom: 0;">
      <td class="text-center primary-col" style="font-size: 18px; width: 100%; text-align: center;"><p style="font-size: 18px; font-weight: bold; text-align: center;">Statement of Certified Advised Investor</p></td>
      </tr>
      </table>';

        $html .= '<table cellpadding="0" cellspacing="10" border="1"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; background: #e5f5ff;">

                      <tr style="margin-bottom: 0; padding-bottom: 0;">
                        <td style="width: 30%; background-color: #1C719C; vertical-align: middle; border: none; text-align: center; color: #fff;">

                                <img class="bg-background " src="' . url("img/pdf/06-ppl-circle.png") . '"  style="max-width:100%; height:auto; width: 60px; " /><br>

                                    ADVISED INVESTOR


                         </td>
                         <td style="width: 70%; border:none;">
                            <h4>Advised Investor</h4>
                            <p style="font-size: 15px; margin-bottom: 5px;">An advised investor is one that has been assessed and categorised by an FCA regulated company
                    and deemed suitable under COBS9 to receive financial promotions. As an advised investor you are aware
                    that you can seek advice from an authorised person who specialises in advising on unlisted shares and
                    unlisted debt securities.</p>

                         </td>
                      </tr></table>';

        $html .= '<table cellpadding="0" cellspacing="10" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">

        <tr style="margin-bottom: 0; padding-bottom: 0;">

         <td style="width: 100%; border:none;">
            <p style="font-size: 14px; margin-bottom: 5px;">Please provide details of the FCA regulated company through which you have been assessed and categorised. GrowthInvest will treat you as a Retail (Restricted) Investor until such time as the company is registered as a client and has provided categorisation documentation on your behalf. Please complete the below statement and questionnaire.</p>

            <p style="font-size: 14px; margin-bottom: 5px;">I am a client of a firm that has assessed me as suitable to receive financial promotions. I accept that the investments to which the promotions relate may expose me to a significant risk of losing all of the money or other property invested. I am aware that it is open to me to seek advice from an authorised person who specialises in advising on unlisted shares and unlisted debt securities.</p>

         </td>
        </tr></table>';

        $financial_advisor_details = $adviceInvData['financial_advisor_info'];

        if (!empty($financial_advisor_details)) {

            $html .= '<table cellpadding="0" cellspacing="10" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">

                <tr style="margin-bottom: 0; padding-bottom: 0;">

                 <td style="width: 100%; border:none;">

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 100%; vertical-align: top;">
                         <h4 style="border-bottom: 1px solid #000; margin-bottom:0; padding-bottom: 0;">Financial Advisor details</h4><hr style="margin-top: 5px; margin-bottom: 5px;"></td>
                         </tr>
                     </table>

                    <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 60%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">Do you have a Financial Advisor or Wealth Manager (Authorised Person)</p></td>
                         <td style="width: 10%;"></td>
                         <td style="Width: 30%; vertical-align: top; font-size: 14px;">' . ucfirst($financial_advisor_details['havefinancialadvisor']) . '</td>
                         </tr>
                     </table>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 60%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">Are you receiving advice from an Authorised Person in relation to unlisted shares and unlisted debt securities?</p></td>
                         <td style="width: 10%;"></td>
                         <td style="Width: 30%; vertical-align: top; font-size: 14px;">' . ucfirst($financial_advisor_details['advicefromauthorised']) . '</td>
                         </tr>
                     </table>';

            if (isset($financial_advisor_details['havefinancialadvisor'])) {

                $address  = !isset($financial_advisor_details['address']) || is_null($financial_advisor_details['address']) ? "" : "<table style='width: 100%; margin-bottom: 0; padding-bottom: 0;' class='no-spacing' ><tr><td style='width: 100%;'>" . $financial_advisor_details['address'] . "</td></tr></table>";
                $address2 = !isset($financial_advisor_details['address2']) || is_null($financial_advisor_details['address2']) ? "" : "<table style='width: 100%; margin-bottom: 0; padding-bottom: 0;' class='no-spacing' ><tr><td style='width: 100%;'>" . $financial_advisor_details['address2'] . "</td></tr></table>";
                $city     = !isset($financial_advisor_details['city']) || is_null($financial_advisor_details['city']) ? "" : $financial_advisor_details['city'] . ",";
                $location = !isset($financial_advisor_details['county']) || is_null($financial_advisor_details['county']) ? "" : "&nbsp;" . $financial_advisor_details['county'] . ",";
                $postcode = !isset($financial_advisor_details['postcode']) || is_null($financial_advisor_details['postcode']) ? "" : "&nbsp;" . $financial_advisor_details['postcode'] . "";

                $addressall = "<div>" . $address . $address2 . $city . $location . $postcode . "</div><br>";

                if ($financial_advisor_details['havefinancialadvisor'] == 'yes') {
                    $html .= '
                    <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 60%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">Company Name</p></td>
                         <td style="width: 10%;"></td>
                         <td style="Width: 30%; vertical-align: top; font-size: 14px;">' . $financial_advisor_details['companyname'] . '</td>
                         </tr>
                     </table>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 60%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">Address</p></td>
                         <td style="width: 10%;"></td>
                         <td style="Width: 30%; vertical-align: top; font-size: 14px;">' . $addressall . '</td>
                         </tr>
                     </table>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 60%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">Telephone Number</p></td>
                         <td style="width: 10%;"></td>
                         <td style="Width: 30%; vertical-align: top; font-size: 14px;">' . $financial_advisor_details['telephone'] . '</td>
                         </tr>
                     </table>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 60%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">Principle contact</p></td>
                         <td style="width: 10%;"></td>
                         <td style="Width: 30%; vertical-align: top; font-size: 14px;">' . $financial_advisor_details['principlecontact'] . '</td>
                         </tr>
                     </table>

                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 60%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">Email</p></td>
                         <td style="width: 10%;"></td>
                         <td style="Width: 30%; vertical-align: top; font-size: 14px;">' . $financial_advisor_details['email'] . '</td>
                         </tr>
                     </table>



                     <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 60%; vertical-align: top;"><p style="font-size: 14px;margin-top: 0; padding-top:0;">FCA Number</p></td>
                         <td style="width: 10%;"></td>
                         <td style="Width: 30%; vertical-align: top; font-size: 14px;">' . $financial_advisor_details['fcanumber'] . '</td>
                         </tr>
                     </table>';

                }
            }

            $html .= '  </td>
                </tr></table>';

        }

        $html .= '<div style="page-break-after:always;border:none;"></div>';

        $html .= '<table cellpadding="0" cellspacing="10" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">

                <tr style="margin-bottom: 0; padding-bottom: 0;">

                 <td style="width: 100%; border:none;">
                 <table style="width: 100%; margin-bottom: 0; padding-bottom: 0;" class="no-spacing" >
                         <tr>
                         <td style="Width: 5%; vertical-align: top;">';

        if (isset($adviceInvData['conditions']) && in_array('ai_check_0', $adviceInvData['conditions'])) {
            $html .= '<img class="bg-background" src="' . url("img/pdf/cert-tick.jpg") . '"/>';
        } else {
            $html .= '<img class="bg-background" src="' . url("img/pdf/cert-untick.jpg") . '"/>';
        }
        $html .= '
                         </td>

                         <td style="Width: 95%; vertical-align: top; font-weight: bold; font-size: 14px;">I am a client of a firm that has assessed me as suitable to receive financial promotions.</td>
                         </tr>
                         <tr>
                         <td style="Width: 5%; vertical-align: top;"> ';

        if (isset($adviceInvData['conditions']) && in_array('ai_check_1', $adviceInvData['conditions'])) {
            $html .= '<img class="bg-background" src="' . url("img/pdf/cert-tick.jpg") . '"/>';
        } else {
            $html .= '<img class="bg-background" src="' . url("img/pdf/cert-untick.jpg") . '"/>';
        }
        $html .= '        </td>

                         <td style="Width: 95%; vertical-align: top; font-weight: bold; font-size: 14px;">I accept that the investments to which the promotions relate may expose me to a significant risk of losing all of the money or other property invested. I am aware that it is open to me to seek advice from an authorised person who specialises in advising on unlisted shares and unlisted debt securities.</td>
                         </tr>
                         <tr>
                         <td style="Width: 5%; vertical-align: top;"> ';

        if (isset($adviceInvData['conditions']) && in_array('ai_check_2', $adviceInvData['conditions'])) {
            $html .= '<img class="bg-background" src="' . url("img/pdf/cert-tick.jpg") . '"/>';
        } else {
            $html .= '<img class="bg-background" src="' . url("img/pdf/cert-untick.jpg") . '"/>';
        }

        $html .= '
                         </td>

                         <td style="Width: 95%; vertical-align: top; font-weight: bold; font-size: 14px;">I have read and understand the risk warning.</td>
                         </tr>
                     </table>
                 </td>
                 </tr>
                 </table><br>';

        $html .= ' <br><b>Name: </b>' . $investor->first_name . ' ' . $investor->last_name;

        $html .= ' <br><b>Date: </b>' . date('d/m/Y');

        return $html;

    }

    public function getElectiveProfHtml($retailData, $investor, $addData)
    {

        $clientCategory   = Defaults::find($addData['client_category_id']);
        $getQuestionnaire = $clientCategory->getCertificationQuesionnaire();

        $electiveProfInvestorQuizStatementDeclaration = getElectiveProfInvestorQuizStatementDeclaration(true);

        $electiveProfessionalStatement   = $electiveProfInvestorQuizStatementDeclaration['statement'];
        $electiveProfessionalDeclaration = $electiveProfInvestorQuizStatementDeclaration['declaration'];

        $html = '';

        $html .= '<table cellpadding="0" cellspacing="10" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">


        <tr style="margin-bottom: 0; padding-bottom: 0;">
        <td class="text-center primary-col" style="font-size: 18px; width: 100%; text-align: center;"><p style="font-size: 18px; font-weight: bold; text-align: center;">Statement of Certified Elective Professional Investor </p></td>
        </tr>
        </table>';

        $html .= '<table cellpadding="0" cellspacing="10" border="1"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; background: #e5f5ff;">

          <tr style="margin-bottom: 0; padding-bottom: 0;">
            <td style="width: 30%; background-color: #1C719C; vertical-align: middle; border: none; text-align: center; color: #fff;">

                    <img class="bg-background" src="' . url("img/pdf/cert-untick.jpg") . '"  style="max-width:100%; height:auto; width: 60px; " /><br>

                        ELECTIVE PROFESSIONAL INVESTOR


             </td>
             <td style="width: 70%; border:none;">
                <h4>Elective Professional Investor</h4>
                <p style="font-size: 15px; margin-bottom: 5px;">
                    If categorised as a Retail (Restricted) Investor, Sophisticated Investor or High Net Worth Individual
                    we are unable to conduct business with you via telephone or in person in relation to our investments.
                    However, if you chose to become an Elective Professional client and we deem you suitable then
                    you can engage directly with us in respect of investment business.
                </p>

                <p>An Elective Professional (Opt Up) Client is someone ordinarily a “Retail” client who wishes to be treated as a "Professional" category client as per the FCA handbook COBs <a href="https://fshandbook.info/FS/print/FCA/COBS/3" target ="_blank">https://fshandbook.info/FS/print/FCA/COBS/3</a>
                    </p>




             </td>
          </tr></table>';

        $html .= '<table cellpadding="0" cellspacing="10" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0;">

          <tr style="margin-bottom: 0; padding-bottom: 0;">
             <td style="width: 100%; border:none;">


                <p>To enable us to categorise you as an Elective Professional Opt Up you must complete the following questionnaire. After this has been completed you must follow the instructions in the statement below.
                    </p>




             </td>
          </tr></table>';

        $html .= '<table cellpadding="0" cellspacing="5" border="0"   class="w100per round_radius" style="margin-top: 0; margin-bottom: 0; padding-top: 0; padding-bottom: 0; font-size: 14px;">';
        $quest_count = 1;

        foreach ($getQuestionnaire as $getQuestion) {

            if ($quest_count == 5) {
                $html .= '<tr style="margin-bottom: 0; padding-bottom: 0;">
                            <td colspan="4"> <br/><br><br><br><br><br> </td>

                        </tr> ';
            }

            $html .= '<tr style="margin-bottom: 0; padding-bottom: 0;">
            <td width="3%">' . $quest_count . '</td>
            <td colspan="3">' . $getQuestion->questions . '
            </td>
        </tr>';

            foreach ($getQuestion->options as $option) {
                $quiz_option_selected = '<img class="bg-background" src="' . url("img/pdf/cert-untick.jpg") . '"/>';
                if ($option->correct) {
                    $quiz_option_selected = ' <img class="bg-background" src="' . url("img/pdf/cert-tick.jpg") . '"/>';
                }
                $html .= '<tr>
            <td width="3%"></td>
            <td width="3%" >
                ' . $quiz_option_selected . '
            </td>
            <td width="2%">
            </td>
            <td width="92%">' . $option->label . '
            </td>
        </tr>';

            }

            $html .= '<tr>
                    <td coslpan="4">&nbsp;</td>
                </tr>';

            $quest_count++;

        }
        $html .= '</table>';

        $html .= $electiveProfessionalStatement;

        $html .= $electiveProfessionalDeclaration;

        $html .= ' <div style="margin-bottom: 5px;"><b>Name: </b>' . $investor->first_name . ' ' . $investor->last_name . '</div>';

        $html .= ' <div style="margin-bottom: 5px;"><b>Email ID: </b>' . $investor->email . '</div>';

        $html .= ' <div style="margin-bottom: 5px;"><b>Date: </b>' . date('d/m/Y') . '</div>';

        return $html;
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

        $investorFai = $investor->userFinancialAdvisorInfo();
        $additionalInfo = $investor->userAdditionalInfo();

        $data['countyList']  = getCounty();
        $data['countryList'] = getCountry();
        $data['investor']    = $investor;
        $data['investorFai'] = (!empty($investorFai)) ? $investorFai->data_value : [];
        $data['additionalInfo'] = (!empty($additionalInfo)) ? $additionalInfo->data_value : []; 
        $data['sectors']     = getSectors();
        $data['breadcrumbs'] = $breadcrumbs;
        $data['pageTitle']   = 'Add Investor : Additional Information';
        $data['mode']        = 'view';
        $data['activeMenu']          = 'add_clients';

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
        $investorFai["havefinancialadvisor"]              = (isset($requestData["havefinancialadvisor"])) ? $requestData["havefinancialadvisor"] : '' ;
        $investorFai["requireadviceseedeisoreis"]         = (isset($requestData["requireadviceseedeisoreis"])) ? $requestData["requireadviceseedeisoreis"]: '' ;
        $investorFai["advicefromauthorised"]              = (isset($requestData["advicefromauthorised"])) ? $requestData["advicefromauthorised"]: '' ;

        $userMeta["skypeid"]                           = $requestData["skypeid"];
        $userMeta["linkedin"]                          = $requestData["linkedin"];
        $userMeta["facebook"]                          = $requestData["facebook"];
        $userMeta["twitter"]                           = $requestData["facebook"];
        $userMeta["employmenttype"]                    = (isset($requestData["employmenttype"])) ? $requestData["employmenttype"]: '' ;
        $userMeta["totalannualincome"]                 = $requestData["totalannualincome"];
        $userMeta["possibleannualinvestment"]          = $requestData["possibleannualinvestment"];
        $userMeta["maximuminvestmentinanyoneproject"]  = $requestData["maximuminvestmentinanyoneproject"];
        $userMeta["investortype"]                      = (isset($requestData["employmenttype"])) ? $requestData["investortype"]: '' ;
        $userMeta["specificinterestinbussinesssector"] = $requestData["specificinterestinbussinesssector"];
        $userMeta["investedinanunlistedcompany"]       = $requestData["investedinanunlistedcompany"];
        $userMeta["comfortablewithliquidityissues"]    = (isset($requestData["comfortablewithliquidityissues"])) ? $requestData["comfortablewithliquidityissues"]: '' ;
        $userMeta["investorlookingfor"]                = $requestData["investorlookingfor"];
        $userMeta["requireassistance"]                 = (isset($requestData["requireassistance"])) ? $requestData["requireassistance"]: '' ;
        $userMeta["investas"]                          = (isset($requestData["investas"])) ?  $requestData["investas"]: '' ;
        $userMeta["haveanycompanieslookingforfunding"] = (isset($requestData["haveanycompanieslookingforfunding"])) ?  $requestData["haveanycompanieslookingforfunding"]: '' ;
        $userMeta["usedeisorventurecapitaltrusts"]     = (isset($requestData["usedeisorventurecapitaltrusts"])) ? $requestData["usedeisorventurecapitaltrusts"]: '' ;
        $userMeta["numcompaniesinvested2yr_seis"]      = $requestData["numcompaniesinvested2yr_seis"];
        $userMeta["totalinvestedinseis"]               = $requestData["totalinvestedinseis"];
        $userMeta["usedeis"]                           = (isset($requestData["usedeis"])) ? $requestData["usedeis"]: '' ;
        $userMeta["numcompaniesinvested2yr_eis"]       = $requestData["numcompaniesinvested2yr_eis"];
        $userMeta["totalinvestedeis"]                  = $requestData["totalinvestedeis"];
        $userMeta["usedvct"]                           = (isset($requestData["usedvct"])) ? $requestData["usedvct"]: '' ;
        $userMeta["numcompaniesinvested2yr_vct"]       = $requestData["numcompaniesinvested2yr_vct"];
        $userMeta["totalinvestedvct"]                  = $requestData["totalinvestedvct"];
        $userMeta["hearaboutsite"]                     = $requestData["hearaboutsite"];
        $userMeta["marketingmail"]                     = (isset($requestData["marketingmail"])) ? $requestData["marketingmail"]: '' ;
        $userMeta["marketingmail_party"]               = (isset($requestData["marketingmail_party"])) ?  $requestData["marketingmail_party"]: '' ;
        $userMeta["plansforusingsite"]                     = $requestData["plansforusingsite"];

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

        Session::flash('success_message', 'Your client registration details added successfully and being redirected to certification stage');
        return redirect(url('backoffice/investor/' . $giCode . '/additional-information'));

    }

}
