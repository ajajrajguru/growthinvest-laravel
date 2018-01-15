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
        $user_roles = $user->getRoleNames(); // Returns a collection

        foreach ($user_permissions_ar as $key => $value) {
            $user_permissions[] = ($value->getAttribute('name'));
        }

        $admin_menus = $this->getUserAdminMenus($user_permissions);
        $dashboard_menus = $this->getUserDashboardMenus($user_roles,$user_permissions);

        session(['user_menus' => array('admin' => $admin_menus)]);
    }


    public function getUserAdminMenus($user_permissions){
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

        return $menus;
    }


    public function getUserDashboardMenus($user_roles,$user_permissions){

        $dashboard_menus = [];
        $mange_options = in_array('manage_options',$user_permissions );
        $is_wealth_manager = in_array('is_wealth_manager',$user_permissions );
        $firm_admin = in_array('firm_admin', $user_roles);
        $network = in_array('network', $user_roles);
        $noDashboardAccessIntermediary = $this->noDashboardAccessIntermediary($user_roles,$user_permissions);


        if($this->noDashboardAccessIntermediary()) {
            $dashboard_menus[] = array('name'=>'Dashboard','url'=>'/dashboard');
        }

        if( $mange_options || $is_wealth_manager || $firm_admin ||  $network){
            $dashboard_menus[] = array('name'=>'Portfolio','url'=>'/dashboard/portfolio');
        }



        if(!$noDashboardAccessIntermediary===false){
            if($this->hasAccess('view_all_investors',$user_permissions) ){

                    $dashboard_menus[] = array('name'=>'Manage Clients','url'=>'/dashboard/portfolio');
            }

        }






    }

    public function noDashboardAccessIntermediary($user_roles,$user_permissions){
        if(!in_array('manage_options',$user_permissions) &&  in_array('yet_to_be_approved_intermediary', $user_roles) {
            return true;
        }
        return false;
    }

    public function getMenuObject($menu=array()){
        $menu_object       = new \stdClass();
        $menu_object->url  = $menu['url'];
        $menu_object->name = $menu['name'];
        return $menu_object;
    }


    public function hasAccess($capabilities,$user_permissions){

        if(is_array($capabilities)){
           $result =  array_intersect($capabilities, $user_permissions);
        }
        else{
            if(in_array($capability,$user_permissions)===false)
                $result =  false;
            else 
                $result = true;    
        }

        return $result ;        
    }

}
