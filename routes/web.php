<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */



Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware' => ['auth','userPermission'], 'prefix' => 'backoffice'], function () {
	Route::resource( 'firm', 'FirmController' );
	Route::get('user/add/step-one','UserController@addUserStepOne');
	Route::get('user/{giCode}/step-one','UserController@userStepOneData');
	Route::post('user/save-step-one','UserController@saveUserStepOne');
	Route::get('user/{giCode}/step-two','UserController@userStepTwoData');
	Route::get('user/{usertype}','UserController@getUsers');
	
 
});

Auth::routes();

Route::get('/', 'UserController@index')->name('home');

Route::resource('users', 'UserController');

Route::resource('roles', 'RoleController');

Route::resource('permissions', 'PermissionController');

Route::get('/logout', 'Auth\LoginController@logout');









/* Test Routes */

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
Route::get('/test-cust-register-user', function () {
    //$credentials = Input::only('login_id', 'password','email','first_name');

    $credentials             = array('login_id' => 'parag@ajency.in', 'password' => 'temp123', 'email' => 'parag@ajency.in', 'first_name' => 'parag');
    $credentials['password'] = Hash::make($credentials['password']);
    try {
        $user  = App\User::create($credentials);
        $token = JWTAuth::fromUser($user);
    } catch (Exception $e) {
        return Response::json(['error' => $e->getMessage()], Illuminate\Http\Response::HTTP_CONFLICT);
    }

    //App\User::create($credentials);
});

Route::get('/test-get-session-data', function (Request $request) {
    
    $user = Auth::user() ;
    echo"<pre>Logged in user data :-";	
    print_r($user);
	echo "<br/>==============================================================================";

    echo "<br/>USER ROLES:----";
    print_r($user->getRoleNames());
    echo "<br/>==============================================================================";

    echo "<br/> USER PERMISSIONS:----------";
    echo"Directly assigned to user :--";
    print_r($user->permissions);
    echo "<br/>-------------------------------------------------------------------------------";
    echo"inherited by user role:--<br/>";
    //print_r();
    $user_permissions = $user->getAllPermissions();

    foreach ($user_permissions as $key => $value) {
    	 	echo $value->getAttribute('name').", ";
    }

    echo "<br/>==============================================================================";

    echo"<br/>User menus";	
    $value = session('user_menus');
    print_r($value);
});

Route::get('/test-logout-user', function (Request $request) {

    Auth::logout();
    Session::flush();

});


Route::get('/test-update-password', function (Request $request) {

	$user  = App\User::find(12705);
    $user->password = Hash::make('temp123');
  	$user->save();

});


Route::get('/test-current-user-permissions', function (Request $request) {

	$user  = Auth::user();
    $user->password = Hash::make('temp123');
  	$user->save();

});


Route::get('/test-give-permission-to-role', function (Request $request) {



	$permission = Permission::create(['name' => 'manage_options','display_name'=>'Manage Options','type'=>'backoffice']);
	$role = Role::findByName('administrator');
	$role->givePermissionTo('manage_options');

});

