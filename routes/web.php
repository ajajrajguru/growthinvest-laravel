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


// upload
Route::group(['middleware' => ['auth']], function () {
    Route::get('download-file/{id}', 'UserController@downloadS3File');
    Route::post('upload-files', 'UserController@uploadTempFiles');
    Route::post('upload-cropper-image', 'UserController@uploadTempImage');
    Route::post('crop-image', 'UserController@uploadCroppedImage');
    Route::post('delete-image', 'UserController@deleteImage');
    Route::post('delete-file', 'UserController@deleteFile');

    // frontoffice entrepreneurs
    Route::get('/add-business-proposals/{type}', 'BusinessListingController@create');
    Route::post('/business-proposals/add-team-member', 'BusinessListingController@getTeamMemberHtml');
    Route::post('/business-proposals/save', 'BusinessListingController@store');
    Route::post('/business-proposals/save-all', 'BusinessListingController@saveAll');
    Route::get('/investment-opportunities/{type}/{slug}/edit', 'BusinessListingController@create');
    Route::get('/investment-opportunities/{type}/{slug}/edit-due-deligence-questionnaire', 'BusinessListingController@editDueDeligenceQuestionnaire');
    Route::post('/investment-opportunities/save-due-deligence-questionnaire', 'BusinessListingController@saveDueDeligenceQuestionnaire');

    Route::get('/investment-opportunities/{type}/{slug}/edit-tier-1-visa', 'BusinessListingController@editTierVisa');
    Route::get('/download-business-proposals/{gicode}', 'BusinessListingController@generateBusinessProposalPdf');
});
 
// backoffice

Route::group(['middleware' => ['auth', 'userPermission'], 'prefix' => 'backoffice'], function () {
    //firms
    Route::get('firms/add', 'FirmController@create');
    Route::post('firms/save-firm', 'FirmController@store');
    Route::post('firms/save-firm-invite', 'FirmController@saveFirmInvite');
    Route::get('firms/{giCode}', 'FirmController@show');
    Route::get('firm/export-firm', 'FirmController@exportFirms');
    Route::get('firm/{giCode}/users', 'FirmController@getFirmUsers');
    Route::get('firm/{giCode}/intermediary-registration', 'UserController@addUserStepOne');
    Route::get('firm/{giCode}/export-users', 'FirmController@exportFirmUsers');
    Route::get('firm/{giCode}/investors', 'FirmController@firmInvestors');
    Route::get('firm/{giCode}/investor/registration', 'InvestorController@registration');
    Route::get('firm/{giCode}/investment-clients', 'FirmController@firmInvestmentClients');
    Route::get('firm/{giCode}/business-clients', 'FirmController@firmBusinessClients');
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

    Route::get('investment-offers', 'InvestorController@investmentOffers');


    //investors
    Route::get('investor/export-investors', 'InvestorController@exportInvestors');
    Route::get('investor/export-investors-activity', 'ActivityController@exportInvestorsActivity');
    Route::get('investor/investors-activity-pdf', 'ActivityController@generateInvestorsActivityPdf');
    Route::get('investor/registration', 'InvestorController@registration');
    Route::get('investor/download-certification/{gi_code}', 'InvestorController@downloadCertification');
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

    // financials
    Route::get('financials/investment-clients', 'BusinessListingController@investmentClients');
    Route::post('financials/get-investment-client', 'BusinessListingController@getInvestmentClients');
    Route::get('financials/export-investmentclient', 'BusinessListingController@exportInvestmentClients');
    Route::get('financials/investmentclient-pdf', 'BusinessListingController@generateInvestmentClientsPdf');
    Route::get('financials/business-clients', 'BusinessListingController@businessClients');
    Route::post('financials/get-business-client', 'BusinessListingController@getBusinessClients');
    Route::get('financials/export-businessclient', 'BusinessListingController@exportBusinessClients');
    Route::get('financials/businessclient-pdf', 'BusinessListingController@generateBusinessClientsPdf');
    Route::post('financials/save-commission', 'BusinessListingController@saveCommission');

    // portfolio
    Route::get('portfolio', 'PortfolioController@index');
    Route::post('portfolio/get-portfolio-data', 'PortfolioController@getPortfolioData');
    Route::get('portfolio/export-report', 'PortfolioController@exportPortfolioReportXlsx');



    // transfer-asset 
    Route::get('transfer-asset', 'TransferAssetController@transferAsset');
    Route::get('transfer-asset/offline', 'TransferAssetController@offlineTransferAsset');
    Route::get('transfer-asset/online', 'TransferAssetController@onlineTransferAsset');
    Route::get('transfer-asset/online/{id}', 'TransferAssetController@onlineTransferAssetSummary');
    Route::post('transfer-asset/save-online-asset', 'TransferAssetController@saveOnlineTransferAsset');
    Route::post('transfer-asset/investor-assets', 'TransferAssetController@getInvestorAssets');
    Route::post('transfer-asset/save-status', 'TransferAssetController@saveAssetStatus');
    Route::post('transfer-asset/delete-asset', 'TransferAssetController@deleteAsset');
    Route::get('transfer-asset/{id}/download/{type}', 'TransferAssetController@downloadTransferAsset');
    Route::post('transfer-asset/esign-doc', 'TransferAssetController@adobeSignataureTransferAsset');



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



Route::group(['middleware' => ['auth'], 'prefix' => 'user-dashboard'], function () {
    Route::get('/', 'UserController@userDashboard');
    Route::get('/business-proposals', 'BusinessListingController@getUserBusinessProposals');

    

});


// webhooks
Route::post('investor/adobe/signed-doc-callback', 'InvestorController@updateInvestorNomineePdf');
Route::post('transfer-asset/adobe/signed-doc-callback', 'TransferAssetController@updateTransferAssetDockey');
Route::post('onfido-webhook', 'InvestorController@onfidoWebhook');

// 
Route::resource('users', 'UserController');
Route::resource('roles', 'RoleController');
Route::resource('permissions', 'PermissionController');


//migration
Route::group(['middleware' => ['auth'],'prefix' => 'migration'], function () {
    Route::get('run/{type}', 'BusinessListingController@migratteVctData');
});

Auth::routes();

Route::get('/', 'UserController@index')->name('home');

Route::get('/logout', 'Auth\LoginController@logout');
