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
        $this->storeUserMenus($event);

    }

    public function storeUserMenus($event)
    {
        $user = $event->user;
        
        $user_permissions = [];

        $user_permissions_ar = $user->getAllPermissions();
        $user_roles          = $user->getRoleNames(); // Returns a collection

        foreach ($user_permissions_ar as $key => $value) {
            $user_permissions[] = ($value->getAttribute('name'));
        }

        $admin_menus = $this->getUserAdminMenus($user_permissions);
        //$dashboard_menus = $this->getUserDashboardMenus($user_roles,$user_permissions);

        $user_data['role'] = isset($user_roles[0]) ? $user_roles[0] : '';

        session(['user_data' => $user_data]);
        session(['user_menus' => array('admin' => $admin_menus)]);
    }

    public function getUserAdminMenus($user_permissions)
    {
        $menus = [];

        if (count(array_intersect($user_permissions, array('manage_options', 'edit_my_firm')) > 0)) {

            if (count(array_intersect($user_permissions, array('manage_options', 'view_firms'))) > 0) {

                $menus[] = ['url' => '#manage', 'name' => 'Manage'];
            }

            if (in_array('manage_options', $user_permissions)) {

                $menus[] = ['url' => '#Statistics', 'name' => 'Statistics'];
                $menus[] = ['url' => '#View-document-templates', 'name' => 'View Document Templates'];
                $menus[] = ['url' => '#View-email-templates', 'name' => 'View Email Templates'];

                if (in_array('view_groups', $user_permissions)) {

                    $menus[] = ['url' => '#view-groups', 'name' => 'View Groups'];
                }

                if (count(array_intersect($user_permissions, array('view_firm_leads', 'view_all_leads'))) > 0) {

                    $menus[] = ['url' => '#view-leads', 'name' => 'View Leads'];
                }

            }

        }

        return $menus;
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
