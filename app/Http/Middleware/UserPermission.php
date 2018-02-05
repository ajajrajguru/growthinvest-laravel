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

                'backoffice/user/{usertype}'                               => ['users'],
                'backoffice/user/export-users'                             => ['users'],
                'backoffice/user/add/step-one'                             => ['add_user'],
                'backoffice/user/{giCode}/step-one'                        => ['add_user'],
                'backoffice/user/{giCode}/step-two'                        => ['add_user'],
                'backoffice/user/save-step-one'                            => ['add_user'],
                'backoffice/user/save-step-two'                            => ['add_user'],
                'backoffice/user/delete-user'                              => ['remove_users', 'delete_users', 'delete_user'],

                'backoffice/firm'                                          => ['view_firms'],
                'backoffice/firm/export-firm'                              => ['view_firms'],
                'backoffice/firms/add'                                     => ['add_firm'],
                'backoffice/firms/save-firm'                               => ['add_firm', 'edit_firm', 'edit_my_firm'],
                'backoffice/firms/{giCode}'                                => ['edit_firm', 'edit_my_firm'],

                'backoffice/investor'                                      => ['view_all_investors', 'investors', 'view_investors'],
                'backoffice/investor/get-investors'                        => ['view_all_investors', 'investors', 'view_investors'],
                'backoffice/investor/export-investors'                     => ['view_all_investors', 'investors', 'view_investors'],
                'backoffice/investor/registration'                         => ['add_investor'],
                'backoffice/investor/{giCode}/registration'                => ['add_investor'],
                'backoffice/investor/save-registration'                    => ['add_investor'],
                'backoffice/investor/{giCode}/client-categorisation'       => ['add_investor'],
                'backoffice/investor/{giCode}/save-client-categorisation'  => ['add_investor'],
                'backoffice/investor/{giCode}/additional-information'      => ['add_investor'],
                'backoffice/investor/{giCode}/save-additional-information' => ['add_investor'],
                'backoffice/investor/{giCode}/investment-account'          => ['add_investor'],
                'backoffice/investor/{giCode}/save-investment-account'     => ['add_investor'],
                'backoffice/investor/{giCode}/download-investor-nominee'      => ['add_investor', 'view_all_investors', 'investors', 'view_investors'],

                'backoffice/entrepreneurs'                                 => ['view_all_business_owners', 'view_firm_business_owners'],
                'backoffice/entrepreneurs/get-entrepreneurs'               => ['view_all_business_owners', 'view_firm_business_owners'],
                'backoffice/entrepreneur/export-entrepreneurs'             => ['view_all_business_owners', 'view_firm_business_owners'],
                'backoffice/fundmanagers'                                  => ['view_all_fund_managers', 'view_firm_fund_managers'],
                'backoffice/fundmanagers/get-fundmanagers'                 => ['view_all_fund_managers', 'view_firm_fund_managers'],
                'backoffice/fundmanager/export-fundmanagers'               => ['view_all_fund_managers', 'view_firm_fund_managers'],
                'backoffice/business-listings'                             => ['view_backoffice_proposals', 'view_firm_business_proposals'],
                'backoffice/business-listings/get-businesslistings'        => ['view_backoffice_proposals', 'view_firm_business_proposals'],
                'backoffice/business-listing/export-business-listings'     => ['view_backoffice_proposals', 'view_firm_business_proposals'],
 
                'backoffice/current-business-valuations'                   => ['view_current_business_valuation'],
                'backoffice/entrepreneur/registration'                     => ['introduce_business_owners_in_any_firm', 'introduce_business_owners_in_my_firm'],
                'backoffice/entrepreneur/save-registration'                => ['introduce_business_owners_in_any_firm', 'introduce_business_owners_in_my_firm'],
                'backoffice/entrepreneur/{giCode}/registration'            => ['introduce_business_owners_in_any_firm', 'introduce_business_owners_in_my_firm'],

                'backoffice/fundmanager/registration'                      => ['introduce_business_owners_in_any_firm', 'introduce_business_owners_in_my_firm'],
                'backoffice/fundmanager/save-registration'                 => ['introduce_business_owners_in_any_firm', 'introduce_business_owners_in_my_firm'],
                'backoffice/fundmanager/{giCode}/registration'             => ['introduce_business_owners_in_any_firm', 'introduce_business_owners_in_my_firm'],

                'backoffice/firm-invite/{giCode}/{type}'                   => ['view_firms', 'add_investor', 'introduce_business_owners_in_my_firm', 'introduce_business_owners_in_any_firm'],
 

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
