<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Firm;
use App\UserData;
use Auth;

//Importing laravel-permission models
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

//Enables us to output flash messaging
use Session;

class UserController extends Controller {

    public function __construct() {
        // $this->middleware(['auth', 'isAdmin']); //isAdmin middleware lets only users with a //specific permission permission to access these resources
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index() {
    //Get all users and pass it to the view
        $users = User::all(); 
        return view('users.index')->with('users', $users);
    }


    /**
    manage users
    -get all users
    -get intermidiateusers
    */
    public function getUsers($userType='all'){

        $user = new User;
        if($userType=='intermidiate'){
            $userType = 'Intermidiate User';
            $users = $user->getIntermidiateUsers(); 
        }
        else{
            $userType = 'User';
            $users = $user->allUsers(); 
        }

        $breadcrumbs = [];
        $breadcrumbs[] = ['url'=>url('/'), 'name'=>"Home"];
        $breadcrumbs[] = ['url'=>'', 'name'=> $userType];

        $data['users'] = $users;
        $data['userType'] = $userType;
        $data['breadcrumbs'] = $breadcrumbs;
        $data['pageTitle'] = $userType;

        return view('backoffice.user.list')->with($data);

    }

    public function addUserStepOne(){
        $user = new User;
        $firmsList = getModelList('App\Firm'); 
        $firms =$firmsList['list'];

        $breadcrumbs = [];
        $breadcrumbs[] = ['url'=>url('/'), 'name'=>"Home"];
        $breadcrumbs[] = ['url'=>'', 'name'=> 'Add User'];
         
        $data['roles'] = Role::get();
        $data['countyList'] = getCounty();
        $data['countryList'] = getCountry();
        $data['companyDescription'] = getCompanyDescription();
        $data['user'] = $user;
        $data['firms'] = $firms;
        $data['breadcrumbs'] = $breadcrumbs;
        $data['pageTitle'] = 'Add User';
        $data['mode'] = 'edit';
        return view('backoffice.user.step-one')->with($data);
    }

    public function saveUserStepOne(Request $request){

        $requestData = $request->all();
        $firstName = $requestData['first_name'];
        $lastName = $requestData['last_name'];
        $email = $requestData['email'];
        $telephone = $requestData['telephone'];
        $password = $requestData['password'];
        $companyName = $requestData['company_name'];
        $companyWebsite = $requestData['company_website'];
        $addressLine1 = $requestData['address_line_1'];
        $addressLine2 = $requestData['address_line_2'];
        $townCity = $requestData['town_city'];
        $county = $requestData['county'];
        $postcode = $requestData['postcode'];
        $country = $requestData['country'];
        $companyFcaNumber = $requestData['company_fca_number'];
        $companyDescription = $requestData['company_description'];
        $role = $requestData['roles'];
        $firm = $requestData['firm'];
        $isSuspended = ($requestData['is_suspended']) ? 1 :0 ;

        $giArgs=array('prefix' => "GIIM",'min'=>20000001,'max' => 30000000);

        $user = new User;
        $giCode = generateGICode($user,'gi_code',$giArgs);
        $user->login_id = $email;
        $user->avatar = '';
        $user->title = '';
        $user->email = $email;
        $user->first_name = $firstName;
        $user->last_name = $lastName;
        $user->password = $password;
        $user->status = 0;
        $user->registered_by = Auth::user()->id;
        $user->telephone_no = $telephone;
        $user->address_1 = $addressLine1;
        $user->address_2 = $addressLine2;
        $user->city = $townCity;
        $user->postcode = $postcode;
        $user->county = $county;
        $user->country = $country;
        $user->firm_id = $firm;
        $user->gi_code = $giCode;
        $user->deleted = 0;
        $user->suspended = $isSuspended;
        $user->save();

        $userId = $user->id;

        $userDetails = ['company'=>$companyName,'website'=>$companyWebsite,'companyfca'=>$companyFcaNumber,'typeaccount'=>$companyDescription]; 

        $userData = new UserData;
        $userData->user_id = $userId;
        $userData->data_key = 'additional_info';
        $userData->data_value = $userDetails;
        $userData->save();

        //assign role
        $user->assignRole($role);

        Session::flash('success_message','User details saved successfully.');
        return redirect(url('backoffice/user/'.$giCode.'/step-one')); 

 
    }

    public function userStepOneData($giCode){ 
        $user = User::where('gi_code',$giCode)->first();

        if(empty($user)){
            abort(404);
        }

        $firmsList = getModelList('App\Firm'); 
        $firms =$firmsList['list'];

        $breadcrumbs = [];
        $breadcrumbs[] = ['url'=>url('/'), 'name'=>"Home"];
        $breadcrumbs[] = ['url'=>'', 'name'=> 'Add User'];
        $userData = $user->userAdditionalInfo(); 
        $data['user'] = $user;
        $data['userData'] = $userData;
        $data['roles'] = Role::get();
        $data['countyList'] = getCounty();
        $data['countryList'] = getCountry();
        $data['companyDescription'] = getCompanyDescription();
        $data['firms'] = $firms;
        $data['breadcrumbs'] = $breadcrumbs;
        $data['pageTitle'] = 'Add User';
        $data['mode'] = 'edit';
        return view('backoffice.user.step-one')->with($data);

    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create() {
    //Get all roles and pass it to the view
        $roles = Role::get();
        return view('users.create', ['roles'=>$roles]);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request) {
    //Validate name, email and password fields
        $this->validate($request, [
            'name'=>'required|max:120',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6|confirmed'
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
    public function show($id) {
        return redirect('users'); 
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id) {
        $user = User::findOrFail($id); //Get user with specified id
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
    public function update(Request $request, $id) {
        $user = User::findOrFail($id); //Get role specified by id

    //Validate name, email and password fields  
        $this->validate($request, [
            'name'=>'required|max:120',
            'email'=>'required|email|unique:users,email,'.$id,
            'password'=>'required|min:6|confirmed'
        ]);
        $input = $request->only(['name', 'email', 'password']); //Retreive the name, email and password fields
        $roles = $request['roles']; //Retreive all roles
        $user->fill($input)->save();

        if (isset($roles)) {        
            $user->roles()->sync($roles);  //If one or more role is selected associate user to roles          
        }        
        else {
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
    public function destroy($id) {
    //Find a user with a given id and delete
        $user = User::findOrFail($id); 
        $user->delete();

        return redirect()->route('users.index')
            ->with('flash_message',
             'User successfully deleted.');
    }
}