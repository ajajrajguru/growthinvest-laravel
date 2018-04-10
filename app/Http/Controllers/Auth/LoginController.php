<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

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
        $action = 'Successful Login';
        $activity = saveActivityLog('User',$user->id,'successful_logins',$user->id,$action,'',$user->firm_id);

        if ($user->can('backoffice_access')) {

            return url('/backoffice/dashboard');

        } else if ($user->can('frontoffice_access')) {

            return url("/user-dashboard/");
        } else {

            return url("");
        }

        return '/home';
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $email = $request->email;
        $user = \App\User::where('email',$email)->first();
        if(!empty($user)){
            $action = 'Login Failed';
            $activity = saveActivityLog('User',$user->id,'auth_fail',$user->id,$action,'',$user->firm_id);
        }
        


        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    protected function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('/login');
    }
}
