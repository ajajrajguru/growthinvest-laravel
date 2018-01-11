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
    "admin_owner_auth_check" will include permission which checks if logged in user is admin or owner of the model
    "normal_user_check" whill skip admin/owner check
    **/

    public function routePermission(){
        
        $routePermission =[
            'backoffice' => 
                [
                    'backoffice/firm'=>['View Firms'], 
                    'backoffice/user/{usertype}'=>['All Users'],
                    'backoffice/user/add-user'=>['Add User'],
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

    public function handle($request, Closure $next)
    {
        $routePerrmissions = $this->routePermission();
        $router = app()->make('router');
        $uriPath = $router->getCurrentRoute()->uri; 

        $uriPermission =  $this->getUriPermissions($uriPath);
 
        if(!hasAccess($uriPermission)){
            abort(403);
        }

        return $next($request);
    }
}
