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

                'backoffice/user/{usertype}'                              => ['users'],
                'backoffice/user/export-users'                            => ['users'],
                'backoffice/user/add/step-one'                            => ['add_user'],
                'backoffice/user/{giCode}/step-one'                       => ['add_user'],
                'backoffice/user/{giCode}/step-two'                       => ['add_user'],
                'backoffice/user/save-step-one'                           => ['add_user'],
                'backoffice/user/save-step-two'                           => ['add_user'],
                'backoffice/user/delete-user'                             => ['remove_users', 'delete_users', 'delete_user'],

                'backoffice/firm'                                         => ['view_firms'],
                'backoffice/firm/export-firm'                             => ['view_firms'],
                'backoffice/firms/add'                                    => ['add_firm'],
                'backoffice/firms/save-firm'                              => ['add_firm', 'edit_firm', 'edit_my_firm'],
                'backoffice/firms/{giCode}'                               => ['edit_firm', 'edit_my_firm'],

                'backoffice/investor'                                     => ['view_all_investors', 'investors', 'view_investors'],
                'backoffice/investor/get-investors'                       => ['view_all_investors', 'investors', 'view_investors'],
                'backoffice/investor/export-investors'                    => ['view_all_investors', 'investors', 'view_investors'],
                'backoffice/investor/registration'                        => ['add_investor'],
                'backoffice/investor/{giCode}/registration'               => ['add_investor'],
                'backoffice/investor/save-registration'                   => ['add_investor'],
                'backoffice/investor/{giCode}/client-categorisation'      => ['add_investor'],
                'backoffice/investor/{giCode}/save-client-categorisation' => ['add_investor'],

                'backoffice/entrepreneurs'                                => ['view_all_business_owners', 'view_firm_business_owners'],
                'backoffice/entrepreneurs/get-entrepreneurs'              => ['view_all_business_owners', 'view_firm_business_owners'],
                'backoffice/entrepreneur/export-entrepreneurs'            => ['view_all_business_owners', 'view_firm_business_owners'],
                'backoffice/fundmanagers'                                 => ['view_all_fund_managers', 'view_firm_fund_managers'],
                'backoffice/fundmanagers/get-fundmanagers'                => ['view_all_fund_managers', 'view_firm_fund_managers'],
                'backoffice/fundmanager/export-fundmanagers'              => ['view_all_fund_managers', 'view_firm_fund_managers'],
                'backoffice/business-listings'                            => ['view_backoffice_proposals', 'view_firm_business_proposals'],

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
