<?php

namespace App\Http\Middleware;

use Closure;

class UserPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    /**
    define permission set for each route and ui element
    group back office and front office URI and its permission
    more then one permission can be added for URI
     **/

    public function routePermission()
    {

        $routePermission = [
            'backoffice'  =>
            [

                'backoffice/user/{usertype}'                                  => ['users'],
                'backoffice/user/export-users'                                => ['users'],
                'backoffice/user/add/intermediary-registration'               => ['add_user'],
                'backoffice/user/{giCode}/intermediary-registration'          => ['add_user'],
                'backoffice/user/{giCode}/intermediary-profile'               => ['add_user'],
                'backoffice/user/save-step-one'                               => ['add_user'],
                'backoffice/user/save-step-two'                               => ['add_user'],
                'backoffice/user/delete-user'                                 => ['remove_users', 'delete_users', 'delete_user'],

                'backoffice/firm'                                             => ['view_firms'],
                'backoffice/firm/export-firm'                                 => ['view_firms'],
                'backoffice/firms/add'                                        => ['add_firm'],
                'backoffice/firms/save-firm'                                  => ['add_firm', 'edit_firm', 'edit_my_firm'],
                'backoffice/firms/save-firm-invite'                           => ['add_firm', 'edit_firm', 'edit_my_firm'],
                'backoffice/firms/{giCode}'                                   => ['edit_firm', 'edit_my_firm'],
                'backoffice/firm/{giCode}/users'                              => ['edit_firm', 'edit_my_firm', 'users'],
                'backoffice/firm/{giCode}/intermediary-registration'          => ['edit_firm', 'edit_my_firm', 'add_user'],
                'backoffice/firm/{giCode}/export-users'                       => ['edit_firm', 'edit_my_firm', 'add_user'],
                'backoffice/firm/{giCode}/investors'                          => ['edit_firm', 'edit_my_firm', 'view_all_investors', 'investors'],
                'backoffice/firm/{giCode}/investor/registration'              => ['edit_firm', 'edit_my_firm', 'add_investor'],
                'backoffice/firm/{giCode}/investment-clients'                 => ['edit_firm', 'manage_options'],
                'backoffice/firm/{giCode}/business-clients'                   => ['edit_firm', 'manage_options'],

                'backoffice/manage-act-feed-group'                            => ['manage_options'],
                'backoffice/activity-group/get-activity-type'                 => ['manage_options'],
                'backoffice/activity-group/save-activity-type'                => ['manage_options'],
                'backoffice/activity/summary'                                 => ['backoffice_access'],
                'backoffice/activity/activity-summary'                        => ['backoffice_access'],

                'backoffice/investment-offers'                                => ['backoffice_access'],

                'backoffice/transfer-asset'                                   => ['transfer_assets'],
                'backoffice/transfer-asset/online'                            => ['transfer_assets', 'transfer_assets_online_group'],
                'backoffice/transfer-asset/online/{id}'                            => ['transfer_assets', 'transfer_assets_online_group'],
                'backoffice/transfer-asset/save-online-asset'                 => ['transfer_assets', 'transfer_assets_online_group'],
                'backoffice/transfer-asset/save-status'                       => ['transfer_assets', 'transfer_assets_online_group'],
                'backoffice/transfer-asset/delete-asset'                      => ['transfer_assets', 'transfer_assets_online_group'],
                'backoffice/transfer-asset/investor-assets'                   => ['transfer_assets', 'transfer_assets_online_group'],
                'backoffice/transfer-asset/offonline'                         => ['transfer_assets', 'transfer_asset_docs_offline_group'],
                'backoffice/transfer-asset/{id}/download/{type}'                         => ['transfer_assets', 'transfer_asset_docs_offline_group'],
                'backoffice/transfer-asset/esign-doc'                         => ['transfer_assets', 'transfer_asset_docs_offline_group'],
                

                'backoffice/investor'                                         => ['view_all_investors', 'investors', 'view_investors'],
                'backoffice/investor/{giCode}/investor-profile'               => ['view_all_investors', 'investors', 'view_investors'],
                'backoffice/investor/{giCode}/investor-invest'                => ['view_all_investors', 'investors', 'view_investors'],
                'backoffice/investor/get-investor-invest'                     => ['view_all_investors', 'investors', 'view_investors'],
                'backoffice/investor/{giCode}/investor-news-update'           => ['view_all_investors', 'investors', 'view_investors'],
                'backoffice/save-news-update'                                 => ['view_all_investors', 'investors', 'view_investors'],
                'backoffice/save-onfido-report-status'                        => ['view_all_investors', 'investors', 'view_investors'],
                'backoffice/delete-news-update'                               => ['view_all_investors', 'investors', 'view_investors'],
                'backoffice/investor/{giCode}/investor-activity'              => ['view_all_investors', 'investors', 'view_investors'],
                'backoffice/investor/get-investor-activity'                   => ['view_all_investors', 'investors', 'view_investors'],

                'backoffice/investor/get-investors'                           => ['view_all_investors', 'investors', 'view_investors'],
                'backoffice/investor/export-investors'                        => ['view_all_investors', 'investors', 'view_investors'],
                'backoffice/investor/export-investors-activity'               => ['view_all_investors', 'investors', 'view_investors'],
                'backoffice/investor/investors-activity-pdf'                  => ['view_all_investors', 'investors', 'view_investors'],
                'backoffice/investor/registration'                            => ['add_investor'],
                'backoffice/investor/{giCode}/registration'                   => ['add_investor'],
                'backoffice/investor/save-registration'                       => ['add_investor'],
                'backoffice/investor/{giCode}/client-categorisation'          => ['add_investor'],
                'backoffice/investor/{giCode}/save-client-categorisation'     => ['add_investor'],
                'backoffice/investor/{giCode}/additional-information'         => ['add_investor'],
                'backoffice/investor/{giCode}/save-additional-information'    => ['add_investor'],
                'backoffice/investor/{giCode}/investment-account'             => ['add_investor'],
                'backoffice/investor/{giCode}/save-investment-account'        => ['add_investor'],
                'backoffice/investor/{giCode}/download-investor-nominee'      => ['add_investor', 'view_all_investors', 'investors', 'view_investors'],
                'backoffice/investor/download-certification/{gi_code}'        => ['add_investor', 'view_all_investors', 'investors', 'view_investors'],

                'backoffice/financials/investment-clients'                    => ['manage_options'],
                'backoffice/financials/export-investmentclient'               => ['manage_options'],
                'backoffice/financials/investmentclient-pdf'                  => ['manage_options'],
                'backoffice/financials/get-investment-client'                 => ['manage_options'],
                'backoffice/financials/business-clients'                      => ['manage_options'],
                'backoffice/financials/export-businessclient'                 => ['manage_options'],
                'backoffice/financials/businessclient-pdf'                    => ['manage_options'],
                'backoffice/financials/get-business-client'                   => ['manage_options'],
                'backoffice/financials/save-commission'                       => ['manage_options'],

                'backoffice/entrepreneurs'                                    => ['view_all_business_owners', 'view_firm_business_owners'],
                'backoffice/entrepreneurs/get-entrepreneurs'                  => ['view_all_business_owners', 'view_firm_business_owners'],
                'backoffice/entrepreneur/export-entrepreneurs'                => ['view_all_business_owners', 'view_firm_business_owners'],
                'backoffice/fundmanagers'                                     => ['view_all_fund_managers', 'view_firm_fund_managers'],
                'backoffice/fundmanagers/get-fundmanagers'                    => ['view_all_fund_managers', 'view_firm_fund_managers'],
                'backoffice/fundmanager/export-fundmanagers'                  => ['view_all_fund_managers', 'view_firm_fund_managers'],
                'backoffice/business/{type}'                                  => ['view_backoffice_proposals', 'view_firm_business_proposals'],
                'backoffice/business-listings/get-businesslistings'           => ['view_backoffice_proposals', 'view_firm_business_proposals'],
                'backoffice/business-listing/export-business-listings'        => ['view_backoffice_proposals', 'view_firm_business_proposals'],

                'backoffice/current-business-valuation'                       => ['view_current_business_valuation'],
                'backoffice/save-current-business-valuation'                  => ['view_current_business_valuation'],
                'backoffice/business-listings/get-current-valuation-listings' => ['view_current_business_valuation'],
                'backoffice/current-valuations/export-current-valuations'     => ['view_current_business_valuation'],
                'backoffice/entrepreneur/registration'                        => ['introduce_business_owners_in_any_firm', 'introduce_business_owners_in_my_firm'],
                'backoffice/entrepreneur/save-registration'                   => ['introduce_business_owners_in_any_firm', 'introduce_business_owners_in_my_firm'],
                'backoffice/entrepreneur/{giCode}/registration'               => ['introduce_business_owners_in_any_firm', 'introduce_business_owners_in_my_firm'],

                'backoffice/fundmanager/registration'                         => ['introduce_business_owners_in_any_firm', 'introduce_business_owners_in_my_firm'],
                'backoffice/fundmanager/save-registration'                    => ['introduce_business_owners_in_any_firm', 'introduce_business_owners_in_my_firm'],
                'backoffice/fundmanager/{giCode}/registration'                => ['introduce_business_owners_in_any_firm', 'introduce_business_owners_in_my_firm'],

                'backoffice/firm-invite/{giCode}/{type}'                      => ['view_firms', 'add_investor', 'introduce_business_owners_in_my_firm', 'introduce_business_owners_in_any_firm'],

                /*Dashboard coming soon routes*/
                'backoffice/dashboard'                                        => ['backoffice_access'],
                'backoffice/dashboard/portfolio'                              => ['backoffice_access'],
                'backoffice/dashboard/investment_offers'                      => ['backoffice_access'],
                'backoffice/dashboard/transferasset'                          => ['backoffice_access'],
                'backoffice/dashboard/activity_feed/summary'                  => ['backoffice_access'],
                'backoffice/dashboard/compliance'                             => ['backoffice_access'],
                'backoffice/dashboard/financials'                             => ['backoffice_access'],
                'backoffice/dashboard/knowledge'                              => ['backoffice_access'],
                /*End Dashboard coming soon routes*/

                /*Coming soon routes on manage */
                'backoffice/manage/manage-backoffice'                         => ['backoffice_access'],
                'backoffice/manage/manage-frontoffice'                        => ['backoffice_access'],
                'backoffice/manage/companylist'                               => ['backoffice_access'],
                'backoffice/manage/manage-act-feed-group'                     => ['backoffice_access'],
                /*End Coming soon routes on manage */

            ],

            'frontoffice' =>
            [

            ],

        ];

        return $routePermission;
    }

    public function getUriPermissions($uriPath)
    {
        $routePerrmissions = $this->routePermission();
        $uriPermission     = [];
        $guard             = '';
        foreach ($routePerrmissions as $guard => $routePerrmission) {
            if (isset($routePerrmission[$uriPath])) {
                $uriPermission = $routePerrmission[$uriPath];
                break;
            }
        }

        return ['guard' => $guard, 'permissions' => $uriPermission];
    }

    /**
    checks if the user has permission to the current URI
    if not then it redirects to 403 page
     */
    public function handle($request, Closure $next)
    {
        $routePerrmissions = $this->routePermission();

        $router  = app()->make('router');
        $uriPath = $router->getCurrentRoute()->uri;

        $uriPermission = $this->getUriPermissions($uriPath);

        if (!hasAccess($uriPermission)) {
            abort(403);
        }

        return $next($request);
    }
}
