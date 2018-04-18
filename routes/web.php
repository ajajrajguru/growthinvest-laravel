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

Route::get('investment-opportunities/{type}', 'BusinessListingController@investmentOpportunities');
Route::post('investment-opportunities/filter-listings', 'BusinessListingController@getFilteredInvestmentOpportunity');



Route::group(['middleware' => ['auth', 'userPermission'], 'prefix' => 'backoffice'], function () {
    //firms
    Route::get('firms/add', 'FirmController@create');
    Route::post('firms/save-firm', 'FirmController@store');
    Route::post('firms/save-firm-invite', 'FirmController@saveFirmInvite');
    Route::get('firms/{giCode}', 'FirmController@show');
    Route::get('firm/export-firm', 'FirmController@exportFirms');
    Route::resource('firm', 'FirmController');

    //users
    Route::get('user/add/intermediary-registration', 'UserController@addUserStepOne');
    Route::get('user/{giCode}/intermediary-registration', 'UserController@userStepOneData');
    Route::post('user/save-step-one', 'UserController@saveUserStepOne');
    Route::get('user/{giCode}/intermediary-profile', 'UserController@userStepTwoData');
    Route::post('user/save-step-two', 'UserController@saveUserStepTwo');
    Route::get('user/export-users', 'UserController@exportUsers');
    Route::get('user/{usertype}', 'UserController@getUsers');
    Route::post('user/delete-user', 'UserController@deleteUsers');
    Route::resource('entrepreneurs', 'EntrepreneurController');
    Route::resource('fundmanagers', 'FundmanagerController');
    Route::post('entrepreneurs/get-entrepreneurs', 'EntrepreneurController@getEntrepreneurslist');
    Route::get('entrepreneur/export-entrepreneurs', 'EntrepreneurController@exportEntrepreneurs');
    Route::post('fundmanagers/get-fundmanagers', 'FundmanagerController@getFundmanagerslist');
    Route::get('fundmanager/export-fundmanagers', 'FundmanagerController@exportFundmanagers');

    //activity feeds
    Route::get('manage-act-feed-group', 'ActivityController@manageActivityFeedGroup');
    Route::post('activity-group/get-activity-type', 'ActivityController@getActivityGroupType');
    Route::post('activity-group/save-activity-type', 'ActivityController@saveActivityGroupType');

    Route::get('activity/summary', 'ActivityController@activitySummary');
    Route::post('activity/activity-summary', 'ActivityController@getActivitySummary');


    //investors
    Route::get('investor/export-investors', 'InvestorController@exportInvestors');
    Route::get('investor/export-investors-activity', 'ActivityController@exportInvestorsActivity');
    Route::get('investor/investors-activity-pdf', 'ActivityController@generateInvestorsActivityPdf');
    Route::get('investor/registration', 'InvestorController@registration');
    Route::get('investor/download-certification/{fileid}', 'InvestorController@downloadCertification');
    Route::get('investor/{giCode}/registration', 'InvestorController@editRegistration');
    Route::get('investor/{giCode}/client-categorisation', 'InvestorController@clientCategorisation');
    Route::post('investor/{giCode}/save-client-categorisation', 'InvestorController@saveClientCategorisation');
    Route::get('investor/{giCode}/additional-information', 'InvestorController@additionalInformation');
    Route::post('investor/{giCode}/save-additional-information', 'InvestorController@saveAdditionalInformation');
    Route::get('investor/{giCode}/investment-account', 'InvestorController@investmentAccount');
    Route::get('investor/{giCode}/download-investor-nominee', 'InvestorController@downloadInvestorNominee');
    Route::post('investor/{giCode}/save-investment-account', 'InvestorController@saveInvestmentAccount');
    Route::post('investor/get-investors', 'InvestorController@getInvestors');
    Route::post('investor/save-registration', 'InvestorController@saveRegistration');
    
    Route::get('investor/{giCode}/investor-profile', 'InvestorController@investorProfile');
    Route::get('investor/{giCode}/investor-invest', 'InvestorController@investorInvest');
    Route::get('investor/{giCode}/investor-news-update', 'InvestorController@investorNewsUpdate');
    Route::get('investor/{giCode}/investor-activity', 'ActivityController@investorActivity');
    Route::post('/save-onfido-report-status', 'InvestorController@saveOnfidoReportStatus');
    Route::post('/save-news-update', 'InvestorController@saveInvestorNewsUpdate');
    Route::post('/delete-news-update', 'InvestorController@deleteInvestorNewsUpdate');
    Route::post('investor/get-investor-invest', 'InvestorController@getInvestorInvest');
    Route::post('investor/get-investor-activity', 'ActivityController@getInvestorActivity');
    Route::resource('investor', 'InvestorController'); 

    //business
    Route::get('business/{type}', 'BusinessListingController@index');
    Route::post('business-listings/get-businesslistings', 'BusinessListingController@getBusinessListings');    
    Route::get('business-listing/export-business-listings', 'BusinessListingController@exportBusinessListings');
    Route::resource('current-business-valuation', 'CurrentBusinessValuation');
    Route::post('save-current-business-valuation', 'CurrentBusinessValuation@saveCurrentValuation');
    Route::get('current-valuations/export-current-valuations', 'CurrentBusinessValuation@exportCurentValuations');
    Route::post('business-listings/get-current-valuation-listings', 'CurrentBusinessValuation@getCurrentValuationListings');
    Route::get('entrepreneur/registration', 'EntrepreneurController@registration');
    Route::post('entrepreneur/save-registration', 'EntrepreneurController@saveRegistration');
    Route::get('entrepreneur/{giCode}/registration', 'EntrepreneurController@editRegistration');

    Route::get('fundmanager/registration', 'FundmanagerController@registration');
    Route::post('fundmanager/save-registration', 'FundmanagerController@saveRegistration');
    Route::get('fundmanager/{giCode}/registration', 'FundmanagerController@editRegistration');
    Route::get('firm-invite/{giCode}/{type}', 'FirmController@getInvite');
    Route::get('dashboard/', 'UserController@showDashboard');

    /*Coming soon routes on dashboard */
    Route::get('dashboard', ['type' => 'home', 'uses' => 'UserController@showDashboard']);
    Route::get('dashboard/portfolio', ['type' => 'portfolio', 'uses' => 'UserController@showDashboard']);
    Route::get('dashboard/investment_offers', ['type' => 'investment-offers', 'uses' => 'UserController@showDashboard']);
    Route::get('dashboard/transferasset', ['type' => 'transferassets', 'uses' => 'UserController@showDashboard']);
    Route::get('dashboard/activity_feed/summary', ['type' => 'activity', 'uses' => 'UserController@showDashboard']);
    Route::get('dashboard/compliance', ['type' => 'document', 'uses' => 'UserController@showDashboard']);
    Route::get('dashboard/financials', ['type' => 'financials', 'uses' => 'UserController@showDashboard']);
    Route::get('dashboard/knowledge', ['type' => 'knowledge', 'uses' => 'UserController@showDashboard']);
    /*End Coming soon routes on dashboard */

    /*Coming soon routes on manage */
    Route::get('manage/manage-backoffice', ['type' => 'manage-backoffice', 'uses' => 'UserController@showAdminManage']);
    Route::get('manage/manage-frontoffice', ['type' => 'manage-frontoffice', 'uses' => 'UserController@showAdminManage']);
    Route::get('manage/companylist', ['type' => 'manage-companylist', 'uses' => 'UserController@showAdminManage']);
    // Route::get('manage/manage-act-feed-group', ['type' => 'manage-activityfeedgroup', 'uses' => 'UserController@showAdminManage']);
    /*End Coming soon routes on manage */



});

Route::group(['middleware' => ['auth'], 'prefix' => 'investment-opportunities'], function () {

    Route::get('single-company/{slug}', 'BusinessListingController@getBusinessDetails');
    Route::get('fund/{slug}', 'BusinessListingController@getBusinessDetails');
    Route::get('fund/{slug}', 'BusinessListingController@getBusinessDetails');

});



Route::group(['prefix' => 'frontoffice'], function () {

    Route::post('show-invest-in-business-modal', 'InvestModalController@showInvestInBusinessModal');
    Route::post('save-pledge-in-business', 'InvestModalController@savePledgeInBusiness');
   

});

Route::post('investor/adobe/signed-doc-callback', 'InvestorController@updateInvestorNomineePdf');
Route::post('onfido-webhook', 'InvestorController@onfidoWebhook');

Route::resource('users', 'UserController');
Route::resource('roles', 'RoleController');
Route::resource('permissions', 'PermissionController');

Route::group(['middleware' => ['auth']], function () {
});


//migration
Route::group(['middleware' => ['auth'],'prefix' => 'migration'], function () {
    Route::get('run/{type}', 'BusinessListingController@migratteVctData');
});

Auth::routes();

Route::get('/', 'UserController@index')->name('home');

Route::get('/logout', 'Auth\LoginController@logout');
