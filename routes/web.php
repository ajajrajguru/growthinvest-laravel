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
	Route::post('user/save-step-two','UserController@saveUserStepTwo');
	Route::get('user/{usertype}','UserController@getUsers');
	
 
});

Route::group(['middleware' => ['auth','isAdmin']], function () {
	Route::resource('users','UserController');
 
});

Auth::routes();

Route::get('/', 'UserController@index')->name('home');
 
Route::resource('roles','RoleController');

Route::resource('permissions','PermissionController');

