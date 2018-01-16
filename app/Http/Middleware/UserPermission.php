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

    public function routePermission(){
        
        $routePermission =[
            'backoffice' => 
                [
                    'backoffice/firm'=>['view_firms'], 
                    'backoffice/user/{usertype}'=>['users'],
                    'backoffice/user/add/step-one'=>['add_user'],
                    'backoffice/user/{giCode}/step-one'=>['add_user'],
                    'backoffice/user/{giCode}/step-two'=>['add_user'],
                    'backoffice/user/save-step-one'=>['add_user'],
                    'backoffice/user/save-step-two'=>['add_user'],
                    'backoffice/firms/add'=>['add_firm'],
                    'backoffice/firms/save-firm'=>['manage_options']
                ],
            'frontoffice' => 
                [
                    
                ]
                                  
        ];


        return $routePermission;
    }

    public function getUriPermissions($uriPath){
        $routePerrmissions = $this->routePermission();
        $uriPermission = [];
        $guard = '';
        foreach ($routePerrmissions as $guard => $routePerrmission) {
            if(isset($routePerrmission[$uriPath])){
                $uriPermission = $routePerrmission[$uriPath];
                break;
            }
        }

        return ['guard'=>$guard,'permissions'=>$uriPermission];
    }

    /**
    checks if the user has permission to the current URI
    if not then it redirects to 403 page
    */
    public function handle($request, Closure $next)
    {
        $routePerrmissions = $this->routePermission();
        $router = app()->make('router');
        $uriPath = $router->getCurrentRoute()->uri; //dd($uriPath);

        $uriPermission =  $this->getUriPermissions($uriPath);
 
        if(!hasAccess($uriPermission)){
            abort(403);
        }

        return $next($request);
    }
}
