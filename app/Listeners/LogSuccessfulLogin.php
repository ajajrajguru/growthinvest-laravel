<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Session;

/**
 * Class for handling successful login event.
 */
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

         //storeUserMenus($event);
         $user = $event->user;
         storeUserMenus($user);

    } 
    

    public function getUserDashboardMenus($user_roles, $user_permissions)
    {

        $dashboard_menus               = [];
        $mange_options                 = in_array('manage_options', $user_permissions);
        $is_wealth_manager             = in_array('is_wealth_manager', $user_permissions);
        $firm_admin                    = in_array('firm_admin', $user_roles);
        $network                       = in_array('network', $user_roles);
        $noDashboardAccessIntermediary = $this->noDashboardAccessIntermediary($user_roles, $user_permissions);

        if ($this->noDashboardAccessIntermediary()) {
            $dashboard_menus[] = array('name' => 'Dashboard', 'url' => '/dashboard');
        }

        if ($mange_options || $is_wealth_manager || $firm_admin || $network) {
            $dashboard_menus[] = array('name' => 'Portfolio', 'url' => '/dashboard/portfolio');
        }

        if (!$noDashboardAccessIntermediary === false) {
            if ($this->hasAccess('view_all_investors', $user_permissions)) {

                $dashboard_menus[] = array('name' => 'Manage Clients', 'url' => '/dashboard/manage-clients', 'params' => array('option' => 'all', 'dashboard_view' => true));

            }

            if ($this->hasAccess('view_firm_investors', $user_permissions)) {

                $dashboard_menus[] = array('name' => 'Manage Clients', 'url' => '/dashboard/manage-clients', 'params' => array('option' => 'firm', 'dashboard_view' => true));
            }

        }

    }

    public function noDashboardAccessIntermediary($user_roles, $user_permissions)
    {
        if (!in_array('manage_options', $user_permissions) && in_array('yet_to_be_approved_intermediary', $user_roles)) {
            return true;
        }
        return false;
    }

    public function hasAccess($capabilities, $user_permissions)
    {

        if (is_array($capabilities)) {
            $result = array_intersect($capabilities, $user_permissions);
        } else {
            if (in_array($capability, $user_permissions) === false) {
                $result = false;
            } else {
                $result = true;
            }

        }

        return $result;
    }

}
