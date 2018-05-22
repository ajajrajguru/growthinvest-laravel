<?php

namespace App\Http\Controllers;

use App\Cropper;
use App\Firm;
use App\User;
use App\UserData;
use Auth;
use File;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
//Importing laravel-permission models
use Illuminate\Support\Facades\Hash;
use Session;
use Spatie\Permission\Models\Role;
use Ajency\FileUpload\models\FileUpload_Files;

//Enables us to output flash messaging
use Storage;

class UserController extends Controller
{

    public function __construct()
    {
        // $this->middleware(['auth', 'isAdmin']); //isAdmin middleware lets only users with a //specific permission permission to access these resources
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get all users and pass it to the view
        $users = User::all();
        return view('users.index')->with('users', $users);
    }

    /**
    manage users
    -get all users
    -get intermidiateusers
    $userType : all ,intermidiate
    breadcrumbs : Set breadcrumb structure for the listing
    pageTitle : define page name
     */
    public function getUsers($userType = 'all')
    {

        $user = new User;

        if ($userType == 'intermediate') {

            $userTypeText = 'View Yet To Be Approved Intermediaries';
            $users        = $user->getIntermidiateUsers();
            $blade        = "intermediaries";
            $activeMenu   = "intermediate";
        } else {
            $userTypeText = 'User';
            $users        = $user->allUsers();
            $blade        = "users";
            $activeMenu   = "users";
        }

        $breadcrumbs   = [];
        $breadcrumbs[] = ['url' => url('/backoffice/dashboard'), 'name' => "Dashboard"];
        $breadcrumbs[] = ['url' => url('/backoffice/manage/manage-backoffice'), 'name' => "Manage Backoffice"];
        $breadcrumbs[] = ['url' => '', 'name' => $userTypeText];

        $data['roles']       = Role::where('type', 'backoffice')->pluck('display_name');
        $data['users']       = $users;
        $data['userType']    = $userTypeText;
        $data['breadcrumbs'] = $breadcrumbs;
        $data['pageTitle']   = $userTypeText;
        $data['activeMenu']  = $activeMenu;

        return view('backoffice.user.' . $blade)->with($data);

    }

    /**
    get list of all required data to be populated in form
    send empty user object to form in create mode
    by default mode will be edit when user is created first time
    $firmGiCode - request from firm to add user
     */
    public function addUserStepOne($firmGiCode = '')
    {
        $user      = new User;
        $firmCond  = ($firmGiCode != '') ? ['gi_code' => $firmGiCode] : [];
        $firmsList = getModelList('App\Firm', $firmCond, 0, 0, ['name' => 'asc']);
        $firms     = $firmsList['list'];

        $breadcrumbs = [];
        if ($firmGiCode == '') {
            $breadcrumbs[] = ['url' => url('/'), 'name' => "Manage"];
            $breadcrumbs[] = ['url' => url('/backoffice/user/all'), 'name' => 'Users'];
            $breadcrumbs[] = ['url' => '', 'name' => 'Add User'];

            $data['is_firm_user'] = 'no';
            $viewFile             = 'backoffice.user.step-one';
        } else {
            $firm          = Firm::where('gi_code', $firmGiCode)->first();
            $breadcrumbs[] = ['url' => url('/'), 'name' => "Manage"];
            $breadcrumbs[] = ['url' => '/backoffice/firm', 'name' => 'Firm'];
            $breadcrumbs[] = ['url' => '', 'name' => $firm->name];
            $breadcrumbs[] = ['url' => '', 'name' => 'Add User'];

            $data['firm']           = $firm;
            $data['is_firm_user']   = 'yes';
            $data['firmActiveMenu'] = 'firm-users';
            $viewFile               = 'backoffice.firm.intermediary-registration';
        }

        $data['roles']              = Role::where('type', 'backoffice')->get();
        $data['countyList']         = getCounty();
        $data['countryList']        = getCountry();
        $data['companyDescription'] = getCompanyDescription();
        $data['user']               = $user;
        $data['firms']              = $firms;
        $data['breadcrumbs']        = $breadcrumbs;
        $data['pageTitle']          = 'Add User';
        $data['mode']               = 'edit';

        return view($viewFile)->with($data);
    }

    /**
    common method to add and update data
    check if user exist
    if does not exist set GI code for user
    assign role to the user, if already added delete previous and add new
     */
    public function saveUserStepOne(Request $request)
    {

        $requestData        = $request->all();
        $firstName          = $requestData['first_name'];
        $lastName           = $requestData['last_name'];
        $email              = $requestData['email'];
        $telephone          = $requestData['telephone'];
        $password           = $requestData['password'];
        $companyName        = $requestData['company_name'];
        $companyWebsite     = $requestData['company_website'];
        $addressLine1       = $requestData['address_line_1'];
        $addressLine2       = $requestData['address_line_2'];
        $townCity           = $requestData['town_city'];
        $county             = $requestData['county'];
        $postcode           = $requestData['postcode'];
        $country            = $requestData['country'];
        $companyFcaNumber   = $requestData['company_fca_number'];
        $companyDescription = $requestData['company_description'];
        $role               = $requestData['roles'];
        $firm               = $requestData['firm'];
        $isSuspended        = (isset($requestData['is_suspended'])) ? 1 : 0;
        $giCode             = $requestData['gi_code'];
        // $isFirmUser             = $requestData['is_firm_user'];

        $giArgs = array('prefix' => "GIIM", 'min' => 20000001, 'max' => 30000000);

        $sendmail = false;
        if ($giCode == '') {
            $sendmail  = true;
            $userExist = User::where('email', $email)->first();
            if (!empty($userExist)) {
                Session::flash('error_message', 'User with ' . $email . ' already exist.');
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

            $user                = new User;
            $giCode              = generateGICode($user, 'gi_code', $giArgs);
            $user->gi_code       = $giCode;
            $user->registered_by = Auth::user()->id;
        } else {
            $user = User::where('gi_code', $giCode)->first();
        }

        $user->login_id     = $email;
        $user->avatar       = '';
        $user->title        = '';
        $user->email        = $email;
        $user->first_name   = $firstName;
        $user->last_name    = $lastName;
        $user->password     = Hash::make($password);
        $user->status       = 0;
        $user->telephone_no = $telephone;
        $user->address_1    = $addressLine1;
        $user->address_2    = $addressLine2;
        $user->city         = $townCity;
        $user->postcode     = $postcode;
        $user->county       = $county;
        $user->country      = $country;
        $user->firm_id      = $firm;
        $user->deleted      = 0;
        $user->lgbr         = 'No';
        $user->suspended    = $isSuspended;
        $user->save();

        $userId = $user->id;

        $userDetails = ['company' => $companyName, 'website' => $companyWebsite, 'companyfca' => $companyFcaNumber, 'typeaccount' => $companyDescription];

        $userData = $user->userAdditionalInfo();
        if (empty($userData)) {
            $userData           = new UserData;
            $userData->user_id  = $userId;
            $userData->data_key = 'additional_info';
        }

        $userData->data_value = $userDetails;
        $userData->save();

        //assign role

        $roleName = $user->getRoleNames()->first();
        if (!empty($roleName)) {
            $user->removeRole($roleName);
        }

        if ($role != "") {
            $user->assignRole($role);
        }

        if ($sendmail) {

            $firmName              = (!empty($user->firm)) ? $user->firm->name : 'N/A';
            $data                  = [];
            $data['from']          = config('constants.email_from');
            $data['name']          = config('constants.email_from_name');
            $data['to']            = [$email];
            $data['cc']            = [];
            $data['subject']       = 'You have successfully submitted your Registration form on GrowthInvest';
            $data['template_data'] = ['name' => $user->displayName(), 'firmName' => $firmName, 'accountType' => ''];
            sendEmail('add-intermediary', $data);

            $registeredBy    = (!empty($user->registeredBy)) ? $user->registeredBy->displayName() : 'N/A';
            $role            = title_case($user->roles()->pluck('display_name')->implode(' '));
            $recipients      = getRecipientsByCapability([], array('manage_backoffice'));
            $data            = [];
            $data['from']    = config('constants.email_from');
            $data['name']    = config('constants.email_from_name');
            $data['cc']      = [];
            $data['subject'] = 'Notification: New User account created for ' . $user->displayName() . ' by ' . $registeredBy . ' in firm ' . $firmName . ' with the role ' . $role . '.';

            foreach ($recipients as $recipientEmail => $recipientName) {
                $data['to']            = $recipientEmail;
                $data['template_data'] = ['toName' => $recipientName, 'name' => $user->displayName(), 'firmName' => $firmName, 'email' => $email, 'telephone' => $user->telephone_no, 'address' => $user->address_1, 'registeredBy' => $registeredBy, 'role' => $role, 'giCode' => $user->gi_code];
                sendEmail('intermediary-register-notification', $data);
            }

            $data                  = [];
            $data['from']          = config('constants.email_from');
            $data['name']          = config('constants.email_from_name');
            $data['to']            = ['x+52703011248957@mail.asana.com'];
            $data['cc']            = [];
            $data['subject']       = $user->displayName() . ' New from ' . $firmName;
            $data['template_data'] = ['name' => $user->displayName(), 'firmName' => $firmName, 'email' => $email, 'telephone' => $user->telephone_no, 'registeredBy' => $registeredBy];
            sendEmail('intermediary-reg-automated', $data);

            $data                  = [];
            $data['from']          = config('constants.email_from');
            $data['name']          = config('constants.email_from_name');
            $data['to']            = [$email];
            $data['cc']            = [];
            $data['subject']       = "Your Growthinvest account password was changed recently";
            $data['template_data'] = ['name' => $user->displayName(), 'firmName' => $firmName, 'password' => $password];
            sendEmail('intermediary-changed-password', $data);

            $action = "New Registration on " . $firmName;
            saveActivityLog('User', Auth::user()->id, 'registration', $userId, $action, '', $user->firm_id);

        }

        Session::flash('success_message', 'Intermediary Registration Has Been Successfully Updated.');

        return redirect(url('backoffice/user/' . $giCode . '/intermediary-registration'));

    }

    /**
    $giCode - unique id generated for the user
    get user using GI code
    mode will be view since user is alredy created
     */
    public function userStepOneData($giCode)
    {
        $user = User::where('gi_code', $giCode)->first();

        if (empty($user)) {
            abort(404);
        }

        $firmsList = getModelList('App\Firm', [], 0, 0, ['name' => 'asc']);
        $firms     = $firmsList['list'];

        $breadcrumbs   = [];
        $breadcrumbs[] = ['url' => url('/'), 'name' => "Manage"];
        $breadcrumbs[] = ['url' => url('/backoffice/user/all'), 'name' => 'Users'];
        $breadcrumbs[] = ['url' => '#', 'name' => $user->first_name . ' ' . $user->last_name];
        $breadcrumbs[] = ['url' => '', 'name' => 'Edit Profile'];

        $userData                   = $user->userAdditionalInfo();
        $data['user']               = $user;
        $data['userData']           = (!empty($userData)) ? $userData->data_value : [];
        $data['roles']              = Role::get();
        $data['countyList']         = getCounty();
        $data['countryList']        = getCountry();
        $data['companyDescription'] = getCompanyDescription();
        $data['firms']              = $firms;
        $data['breadcrumbs']        = $breadcrumbs;
        $data['pageTitle']          = 'Edit User';
        $data['mode']               = 'view';
        return view('backoffice.user.step-one')->with($data);

    }

    /**
    $giCode - unique id generated for the user
    get user using GI code
     */
    public function userStepTwoData($giCode)
    {
        $user = User::where('gi_code', $giCode)->first();

        if (empty($user)) {
            abort(404);
        }
        $profilePic  = $user->getProfilePicture('medium_1x1');
        $companyLogo = $user->getCompanyLogo('medium_1x1');

        $breadcrumbs   = [];
        $breadcrumbs[] = ['url' => url('/'), 'name' => "Manage"];
        $breadcrumbs[] = ['url' => url('/backoffice/user/all'), 'name' => 'Users'];
        $breadcrumbs[] = ['url' => '#', 'name' => $user->first_name . ' ' . $user->last_name];
        $breadcrumbs[] = ['url' => '', 'name' => 'Edit Profile'];

        $intermidiatData            = $user->userIntermidaiteCompInfo();
        $taxstructureInfo           = $user->taxstructureInfo();
        $data['user']               = $user;
        $data['profilePic']         = $profilePic['url'];
        $data['hasProfilePic']      = $profilePic['hasImage'];
        $data['companyLogo']        = $companyLogo['url'];
        $data['hasCompanyLogo']     = $companyLogo['hasImage'];
        $data['intermidiatData']    = (!empty($intermidiatData)) ? $intermidiatData->data_value : [];
        $data['taxstructureInfo']   = (!empty($taxstructureInfo)) ? $taxstructureInfo->data_value : [];
        $data['regulationTypes']    = getRegulationTypes();
        $data['registeredIndRange'] = getRegisteredIndRange();
        $data['sources']            = getSource();

        $data['breadcrumbs'] = $breadcrumbs;
        $data['pageTitle']   = 'Edit User';
        $data['mode']        = 'view';
        return view('backoffice.user.step-two')->with($data);

    }

    public function saveUserStepTwo(Request $request)
    {

        $requestData = $request->all();

        $giCode = $requestData['gi_code'];
        if ($giCode == '') {
            Session::flash('error_message', 'Intermediary Registration Has Been Successfully Updated.');
            return redirect(url('backoffice/user/add/intermediary-registration'));
        } else {
            $user = User::where('gi_code', $giCode)->first();
        }

        $userId      = $user->id;
        $userDetails = [
            'con_skype'                   => $requestData['contact_skype_id'],
            'con_link'                    => $requestData['contact_linked_in'],
            'con_fb'                      => $requestData['contact_facebook'],
            'con_twit'                    => $requestData['contact_twitter'],
            'position'                    => $requestData['contact_job_title'],
            'fca_approved'                => $requestData['contact_fca_regulation'],
            'personal_fca'                => $requestData['contact_registration_number'],
            'telephonenumber'             => $requestData['contact_telephone'],
            'mobile'                      => $requestData['contact_mobile'],
            'company_link'                => $requestData['company_linkedin'],
            'company_fb'                  => $requestData['company_facebook'],
            'company_twit'                => $requestData['company_twitter'],
            'regulationtype'              => $requestData['company_regulation_type'],
            'reg_ind_cnt'                 => $requestData['company_reg_ind'],
            'regulated_total_bus_inv_aum' => $requestData['company_estimate_asset_under_mgt'],
            'source'                      => $requestData['about_platform'],
            'source_cmts'                 => $requestData['additional_comments'],
            'marketingmail'               => (isset($requestData['marketing_email'])) ? 'yes' : 'no',
            'marketingmail_partner'       => (isset($requestData['marketing_mails_partners'])) ? 'yes' : 'no',
            'interested_tax_struct'       => (isset($requestData['interested_tax_structure']) && !empty($requestData['interested_tax_structure'])) ? implode(',', $requestData['interested_tax_structure']) : '',
            'contact_email'               => (isset($requestData['connect_email'])) ? 'yes' : 'no',
            'contact_phone'               => (isset($requestData['connect_mobile'])) ? 'yes' : 'no',
            'companylogo'                 => '',

        ];

        $userData = $user->userIntermidaiteCompInfo();
        if (empty($userData)) {
            $userData           = new UserData;
            $userData->user_id  = $userId;
            $userData->data_key = 'intermediary_company_info';
        }

        $userData->data_value = $userDetails;
        $userData->save();

        $taxstructureInfo = $requestData['taxstructure'];
        $userData         = $user->taxstructureInfo();
        if (empty($userData)) {
            $userData           = new UserData;
            $userData->user_id  = $userId;
            $userData->data_key = 'taxstructure_info';
        }

        $userData->data_value = $taxstructureInfo;
        $userData->save();

        Session::flash('success_message', 'User details saved successfully.');
        return redirect(url('backoffice/user/' . $giCode . '/intermediary-profile'));
    }

    public function exportUsers()
    {
        $userObj = new User;
        $users   = $userObj->allUsers();

        $fileName = 'approved_intermediary';

        $header = ['Platform GI Code', 'Name', 'Email', 'Role', 'Firm', 'Telephone No'];

        $userData = [];

        foreach ($users as $user) {
            $userData[] = [$user->gi_code,
                title_case($user->first_name . ' ' . $user->last_name),
                $user->email,
                title_case($user->roles()->pluck('display_name')->implode(' ')),
                (!empty($user->firm)) ? $user->firm->name : '',
                $user->telephone_no,
            ];
        }

        generateCSV($header, $userData, $fileName);

        return true;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Get all roles and pass it to the view
        $roles = Role::get();
        return view('users.create', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate name, email and password fields
        $this->validate($request, [
            'name'     => 'required|max:120',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create($request->only('email', 'name', 'password')); //Retrieving only the email and password data

        $roles = $request['roles']; //Retrieving the roles field
        //Checking if a role was selected
        if (isset($roles)) {

            foreach ($roles as $role) {
                $role_r = Role::where('id', '=', $role)->firstOrFail();
                $user->assignRole($role_r); //Assigning role to user
            }
        }
        //Redirect to the users.index view and display message
        return redirect()->route('users.index')
            ->with('flash_message',
                'User successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('users');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user  = User::findOrFail($id); //Get user with specified id
        $roles = Role::get(); //Get all roles

        return view('users.edit', compact('user', 'roles')); //pass user and roles data to view

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
        $user = User::findOrFail($id); //Get role specified by id

        //Validate name, email and password fields
        $this->validate($request, [
            'name'     => 'required|max:120',
            'email'    => 'required|email|unique:users,email,' . $id,
            'password' => 'required|min:6|confirmed',
        ]);
        $input = $request->only(['name', 'email', 'password']); //Retreive the name, email and password fields
        $roles = $request['roles']; //Retreive all roles
        $user->fill($input)->save();

        if (isset($roles)) {
            $user->roles()->sync($roles); //If one or more role is selected associate user to roles
        } else {
            $user->roles()->detach(); //If no role is selected remove exisiting role associated to a user
        }
        return redirect()->route('users.index')
            ->with('flash_message',
                'User successfully edited.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Find a user with a given id and delete
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')
            ->with('flash_message',
                'User successfully deleted.');
    }

    public function deleteUsers(Request $request)
    {
        $requestData = $request->all();
        $userIdStr   = $requestData['user_id'];
        $userIds     = explode(',', $userIdStr);
        $userIds     = array_filter($userIds);

        foreach ($userIds as $key => $userId) {
            $user = User::findOrFail($userId);
            $user->delete();
        }

        return response()->json(['status' => true]);
    }

    // frontofficebashboard

    public function userDashboard(){
        $user = Auth::user();
        if(empty($user))
            abort(403);

        $profilePic           = $user->getProfilePicture('thumb_1x1');
        $data['profilePic']   = $profilePic['url'];
        $data['user'] = $user;

        if(isUser($user,['business_owner'])){
            $data['active_menu'] = 'dashboard';

            $template = 'frontend.entrepreneur.dashboard';
        }
 
        return view($template)->with($data);
    }

    /* Coming soon Dashboard Pages */
    public function showDashboard(\Illuminate\Http\Request $request)
    {
        $action = $request->route()->getAction();

        switch ($action['type']) {
            case 'home':
                $breadcrumbs             = [];
                $breadcrumbs[]           = ['url' => url('backoffice/dashboard'), 'name' => "Dashboard"];
                $breadcrumbs[]           = ['url' => '', 'name' => 'Home'];
                $data['breadcrumbs']     = $breadcrumbs;
                $data['pageTitle']       = 'Home';
                $data['page_short_desc'] = '';
                $data['activeMenu']      = 'home';
                break;
            case 'portfolio':
                $breadcrumbs             = [];
                $breadcrumbs[]           = ['url' => url('backoffice/dashboard'), 'name' => "Dashboard"];
                $breadcrumbs[]           = ['url' => '', 'name' => 'Portfolio Summary'];
                $data['breadcrumbs']     = $breadcrumbs;
                $data['pageTitle']       = 'Portfolio Summary';
                $data['page_short_desc'] = '';

                $data['activeMenu'] = 'portfolio';
                break;
            case 'investment-offers':
                $breadcrumbs             = [];
                $breadcrumbs[]           = ['url' => url('backoffice/dashboard'), 'name' => "Dashboard"];
                $breadcrumbs[]           = ['url' => '', 'name' => 'Investment Offers'];
                $data['breadcrumbs']     = $breadcrumbs;
                $data['pageTitle']       = 'Investment Offers';
                $data['page_short_desc'] = '';

                $data['activeMenu'] = 'investment_offers';
                break;
            case 'transferassets':
                $breadcrumbs             = [];
                $breadcrumbs[]           = ['url' => url('backoffice/dashboard'), 'name' => "Dashboard"];
                $breadcrumbs[]           = ['url' => '', 'name' => 'Transfer Assets'];
                $data['breadcrumbs']     = $breadcrumbs;
                $data['pageTitle']       = 'Transfer Assets';
                $data['page_short_desc'] = '';

                $data['activeMenu'] = 'transferassets';
                break;
            case 'activity':
                $breadcrumbs             = [];
                $breadcrumbs[]           = ['url' => url('backoffice/dashboard'), 'name' => "Dashboard"];
                $breadcrumbs[]           = ['url' => '', 'name' => 'Activity Analysis'];
                $data['breadcrumbs']     = $breadcrumbs;
                $data['pageTitle']       = 'Activity Analysis';
                $data['page_short_desc'] = '';

                $data['activeMenu'] = 'activity';
                break;
            case 'document':
                $breadcrumbs             = [];
                $breadcrumbs[]           = ['url' => url('backoffice/dashboard'), 'name' => "Dashboard"];
                $breadcrumbs[]           = ['url' => '', 'name' => 'Document Library'];
                $data['breadcrumbs']     = $breadcrumbs;
                $data['pageTitle']       = 'Document Library';
                $data['page_short_desc'] = '';

                $data['activeMenu'] = 'documents';
                break;
            case 'financials':
                $breadcrumbs             = [];
                $breadcrumbs[]           = ['url' => url('backoffice/dashboard'), 'name' => "Dashboard"];
                $breadcrumbs[]           = ['url' => '', 'name' => 'Financials'];
                $breadcrumbs[]           = ['url' => '', 'name' => 'Investment Clients'];
                $data['breadcrumbs']     = $breadcrumbs;
                $data['pageTitle']       = 'Investment Clients';
                $data['page_short_desc'] = '';

                $data['activeMenu'] = 'financials';
                break;

            case 'knowledge':
                $breadcrumbs             = [];
                $breadcrumbs[]           = ['url' => url('backoffice/dashboard'), 'name' => "Dashboard"];
                $breadcrumbs[]           = ['url' => '', 'name' => 'Knowledge Portal'];
                $data['breadcrumbs']     = $breadcrumbs;
                $data['pageTitle']       = 'Knowledge Portal';
                $data['page_short_desc'] = '';

                $data['activeMenu'] = 'knowledge';
                break;

        }

        return view('backoffice.dashboard-coming-soon.dashboard')->with($data);
    }

    /* Coming soon Dashboard Pages */
    public function showAdminManage(\Illuminate\Http\Request $request)
    {
        $action = $request->route()->getAction();

        switch ($action['type']) {
            case 'manage-backoffice':
                $breadcrumbs             = [];
                $breadcrumbs[]           = ['url' => url('backoffice/dashboard'), 'name' => "Dashboard"];
                $breadcrumbs[]           = ['url' => '', 'name' => 'Manage BackOffice'];
                $data['breadcrumbs']     = $breadcrumbs;
                $data['pageTitle']       = 'Manage Backoffice';
                $data['page_short_desc'] = '';
                $data['activeMenu']      = 'manage-backoffice';
                break;
            case 'manage-frontoffice':
                $breadcrumbs             = [];
                $breadcrumbs[]           = ['url' => url('backoffice/dashboard'), 'name' => "Dashboard"];
                $breadcrumbs[]           = ['url' => '', 'name' => 'Manage FrontOffice'];
                $data['breadcrumbs']     = $breadcrumbs;
                $data['pageTitle']       = 'Manage FrontOffice';
                $data['page_short_desc'] = '';

                $data['activeMenu'] = 'manage-frontoffice';
                break;
            case 'manage-companylist':
                $breadcrumbs             = [];
                $breadcrumbs[]           = ['url' => url('backoffice/dashboard'), 'name' => "Dashboard"];
                $breadcrumbs[]           = ['url' => '', 'name' => 'Company List'];
                $data['breadcrumbs']     = $breadcrumbs;
                $data['pageTitle']       = 'View Companies';
                $data['page_short_desc'] = '';

                $data['activeMenu'] = 'manage-companylist';
                break;
            case 'manage-activityfeedgroup':
                $breadcrumbs             = [];
                $breadcrumbs[]           = ['url' => url('backoffice/dashboard'), 'name' => "Dashboard"];
                $breadcrumbs[]           = ['url' => '', 'name' => 'Activity Feed Group'];
                $data['breadcrumbs']     = $breadcrumbs;
                $data['pageTitle']       = 'Activity Feed Group';
                $data['page_short_desc'] = '';

                $data['activeMenu'] = 'manage-activityfeedgroup';
                break;

        }

        return view('backoffice.dashboard-coming-soon.manage')->with($data);
    }

    public function uploadTempImage(Request $request)
    {
        if (!File::exists(public_path() . '/uploads/tmp')) {
            File::makeDirectory(public_path() . '/uploads/tmp', 0777);
        }

        $image         = $request->file('file');
        $imageFileName = 'temp_profile_pic_' . date('YmdHis') . '.' . $image->getClientOriginalExtension();

        $destinationPath = public_path() . '/uploads/tmp/';
        $url             = url('/uploads/tmp/'); //dd($url);
        $fileUrl         = url('/uploads/tmp/' . $imageFileName); //dd($url);
        $request->file('file')->move($destinationPath, $imageFileName);

        return response()->json([
            'code'    => 'image_uploaded',
            'message' => 'success',
            'data'    => [
                'image_path' => $fileUrl,
            ],
        ], 200);

    }

    public function uploadCroppedImage(Request $request)
    {
        if (!File::exists(public_path() . '/uploads/img')) {
            File::makeDirectory(public_path() . '/uploads/img', 0777);
        }
        $mapped = false; 
        $requestData = $request->all();

        $crop = new Cropper(
            isset($requestData['original_image']) ? $requestData['original_image'] : null,
            isset($requestData['crop_data']) ? $requestData['crop_data'] : null,
            isset($requestData['crop_file']) ? $requestData['crop_file'] : null
        );

        $objectType  = $requestData['object_type'];
        $objectId    = $requestData['object_id'];
        $imageType   = $requestData['image_type'];
        $displaySize = $requestData['display_size'];

        $url = $crop->getResult();

        if ($crop->getMsg() != null) {
            $model = $objectType::find($objectId);

            if($model){

               $url = updateModelImage($model,$url,$imageType,$displaySize);
               $mapped = true; 
            }

        }

        return response()->json([
            'code'       => 'image_uploaded',
            'message'    => 'success',
            'mapped'    =>  $mapped,
            'image_path' => $url,
        ], 200);

    }


    public function deleteImage(Request $request)
    {

        $requestData = $request->all();

        $objectType = $requestData['object_type'];
        $objectId   = $requestData['object_id'];
        $imageType  = $requestData['image_type'];

        $model = $objectType::find($objectId);


        $defaultImage     = getDefaultImages($imageType);
        if($model){
            $profilePicImages = $model->getImages($imageType);
            foreach ($profilePicImages as $key => $profilePicImage) {
                $fileId = $profilePicImage['id'];
                $model->unmapImage($fileId);
            }
        }
        
        return response()->json([
            'code'       => 'image_deleted',
            'message'    => 'success',
            'image_path' => $defaultImage,
        ], 200);

    }

    public function uploadTempFiles(Request $request)
    {
        if (!File::exists(public_path() . '/uploads/tmp')) {
            File::makeDirectory(public_path() . '/uploads/tmp', 0777);
        }

        $file     = $request->file('file');
        $fileName     = $request->input('name');
         
        $destinationPath = public_path() . '/uploads/tmp/';
        $url             = url('/uploads/tmp/');  
        $fileUrl         = url('/uploads/tmp/' . $fileName);  
        $request->file('file')->move($destinationPath, $fileName);

        return response()->json([
            'code'    => 'image_uploaded',
            'message' => 'success',
            'data'    => [
                'image_path' => $fileUrl,
                'file_name' => $fileName,
            ],
        ], 200);

    }

    public function deleteFile(Request $request)
    {

        $requestData = $request->all();

        $objectType = $requestData['object_type'];
        $objectId   = $requestData['object_id'];
        $fileType  = $requestData['file_type'];

        $model = $objectType::find($objectId);

        if($model){
            $getFiles = $model->getFiles($fileType);
            foreach ($getFiles as $key => $file) {
                $fileId = $file['id'];
                $model->unmapFile($fileId);
            }
        }
        
        return response()->json([
            'code'       => 'file_delete',
            'message'    => 'success',
        ], 200);

    }

    public function downloadS3File($id)
    {
        
        $file      = FileUpload_Files::find($id); 
      
        $filePath = $file->url;
        $filename = $file->name;

        $user = User::first();
        
        $ext      = pathinfo($filePath, PATHINFO_EXTENSION);
        $mimeType = getFileMimeType($ext);
        $file     = $user->getSingleFile($id);
        
        return response($file)
            ->header('Content-Type', $mimeType)
            ->header('Content-Description', 'File Transfer')
            ->header('Content-Disposition', "attachment; filename={$filename}")
            ->header('Filename', $filename);
    }

}
