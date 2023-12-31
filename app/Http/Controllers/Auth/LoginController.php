<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth as AuthSupport;

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
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ],
        [
            "username.required" => "Username Harus diisi",
            "password.required" => "Password Harus diisi",
        ]
        );
    }

    public function login(Request $request)
    {
        // $user = User::where('username', $request->username)->first();
        // if($user){
        //     if(!$user->email_verified_at){
        //         return redirect()->route('login')->with('error', 'Akun belum terverifikasi!');
        //     }
        // }
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }



    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        if($request->wantsJson()){
            return new JsonResponse([], 204);
        }else{

            // if(AuthSupport::user()->role == 1){
            //     return redirect()->route('warranty.index');
            // }
            if(AuthSupport::user()->role == 2){
                return redirect()->route('front.index');
            }
            return redirect()->intended($this->redirectPath());
        }
    }

    public function username()
    {
        return 'username';
    }

    public function __construct()
    {
        $this->middleware('verified')->only([
            'validateLogin',
            'sendLoginResponse',
            'attemptLogin',
            'incrementLoginAttempts'
        ]);
        $this->middleware('guest')->except('logout');
    }
}
