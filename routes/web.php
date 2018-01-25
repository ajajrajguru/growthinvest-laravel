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
	//firms
	Route::get('firms/add','FirmController@create');
	Route::post('firms/save-firm','FirmController@store');
	Route::get('firms/{giCode}','FirmController@show'); 
	Route::get('firm/export-firm','FirmController@exportFirms');
	Route::resource( 'firm', 'FirmController' );

	//users
	Route::get('user/add/step-one','UserController@addUserStepOne');
	Route::get('user/{giCode}/step-one','UserController@userStepOneData');
	Route::post('user/save-step-one','UserController@saveUserStepOne');
	Route::get('user/{giCode}/step-two','UserController@userStepTwoData');
	Route::post('user/save-step-two','UserController@saveUserStepTwo');
	Route::get('user/export-users','UserController@exportUsers');
	Route::get('user/{usertype}','UserController@getUsers');
	Route::post('user/delete-user','UserController@deleteUsers');
	Route::resource( 'entrepreneurs', 'EntrepreneurController' );
	Route::resource( 'fundmanagers', 'FundmanagerController' );
	Route::post( 'entrepreneurs/get-entrepreneurs', 'EntrepreneurController@getEntrepreneurslist' );
	Route::get('entrepreneur/export-entrepreneurs','EntrepreneurController@exportEntrepreneurs');
	
	//investors
	Route::get('investor/export-investors','InvestorController@exportInvestors');
	Route::get('investor/registration','InvestorController@registration');
	Route::get('investor/{giCode}/registration','InvestorController@editRegistration');
	Route::get('investor/{giCode}/client-categorisation','InvestorController@clientCategorisation');
	Route::post('investor/{giCode}/save-client-categorisation','InvestorController@saveClientCategorisation');
	Route::post( 'investor/get-investors', 'InvestorController@getInvestors' );
	Route::post( 'investor/save-registration', 'InvestorController@saveRegistration' );
 	Route::resource( 'investor', 'InvestorController' );

 	//business
 	Route::resource( 'business-listings', 'BusinessListingController' );

});

 

	Route::resource('users','UserController');
	Route::resource('roles', 'RoleController');
	Route::resource('permissions', 'PermissionController');

Route::group(['middleware' => ['auth']], function () { 
});
 



Auth::routes();

Route::get('/', 'UserController@index')->name('home');
 
Route::get('/logout', 'Auth\LoginController@logout');



