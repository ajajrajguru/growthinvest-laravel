<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    /**
     * Redirect user to custom url on login
     *
     * @return     string  ( description_of_the_return_value )
     */
    protected function redirectTo()
    {

        $user = Auth::user();
        if ($user->can('backoffice_access')) {

            return url('/backoffice/dashboard');

        } else if ($user->can('frontoffice_access')) {

            return url("/user-dashboard/");
        } else {

            return url("");
        }

        return '/home';
    }
}
