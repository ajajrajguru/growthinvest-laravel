<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Session;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $this->storeUserMenus($event);

    }

    public function storeUserMenus($event)
    {
        $user = $event->user;
        /*$user->last_login_at = date('Y-m-d H:i:s');
        $user->last_login_ip = $this->request->ip();
        $user->save();*/
        $user_permissions = [];

        $user_permissions_ar = $user->getAllPermissions();

        foreach ($user_permissions_ar as $key => $value) {
            $user_permissions[] = ($value->getAttribute('name'));
        }

        $menus = [];

        if (count(array_intersect($user_permissions, array('manage_options', 'edit_my_firm')) > 0)) {

            $menu_object = new \stdClass();
            if (count(array_intersect($user_permissions, array('manage_options', 'view_firms'))) > 0) {

                $menu_object->url  = '#manage';
                $menu_object->name = 'Manage';

                $menus[] = $menu_object;
            }

            if (in_array('manage_options', $user_permissions)) {
                $menu_object1       = new \stdClass();
                $menu_object1->url  = '#Statistics';
                $menu_object1->name = 'Statistics';

                $menus[] = $menu_object1;

                $menu_object2       = new \stdClass();
                $menu_object2->url  = '#View-document-templates';
                $menu_object2->name = 'View Document Templates';
                $menus[]            = $menu_object2;

                $menu_object3       = new \stdClass();
                $menu_object3->url  = '#View-email-templates';
                $menu_object3->name = 'View Email Templates';
                $menus[]            = $menu_object3;

                if (in_array('view_groups', $user_permissions)) {

                    $menu_object5       = new \stdClass();
                    $menu_object5->url  = '#view-groups';
                    $menu_object5->name = 'View Groups';
                    $menus[]            = $menu_object5;
                }

                if (count(array_intersect($user_permissions, array('view_firm_leads', 'view_all_leads'))) > 0) {

                    $menu_object6       = new \stdClass();
                    $menu_object6->url  = '#view-leads';
                    $menu_object6->name = 'View Leads';
                    $menus[]            = $menu_object6;
                }

            }

        }

        session(['user_menus' => array('admin' => $menus)]);
    }

}
