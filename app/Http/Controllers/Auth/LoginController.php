<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Route;
use \App\User;
use \App\Model\UserInfo;
use Socialite;
use Hash;
use Auth;
use Session;

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

    use AuthenticatesUsers {
        logout as performLogout;
    }

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
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logout(Request $request)
    {
        $this->performLogout($request);
        return redirect('/');
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(\Illuminate\Http\Request $request)
    {
        // return $request->only($this->username(), 'password');
        return ['email' => $request->{$this->username()}, 'password' => $request->password, 'status' => 1];
    }

    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return Response
     */
    public function redirectToProviderFB()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallbackFB()
    {
        $user = Socialite::driver('facebook')->user();
        $socialiteAuth = self::socialiteAuth($user);
        return redirect('/');

    }


    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return Response
     */
    public function redirectToProviderGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallbackGoogle()
    {
        $user = Socialite::driver('google')->user();
        $socialiteAuth = self::socialiteAuth($user);
        return redirect('/');
    }

    public function socialiteAuth($user)
    {
        $name  = $user->getName();
        $email = $user->getEmail();

        $findUser = User::where('email', '=', $email)->first();

        if ($findUser) {
            Auth::login($findUser);
        } else{
            $password = rand (10000000,99999999);
            $authUser               = new User;
            $authUser->name         = $name;
            $authUser->email        = $email;
            $authUser->password     = Hash::make($password);
            $authUser->showPassword = $password;
            $authUser->u_role       = 'U';
            $authUser->status       = '1';
            $authUser->save();

            $last_insert_id                 = $authUser->id;
            $userInfo                       = new UserInfo;
            $userInfo->u_id_fk              = $last_insert_id;
            $userInfo->email                = $email;
            $userInfo->name                 = $name;
            $userInfo->phone                = '0';
            $userInfo->default_address_flag = 1;
            $userInfo->save();

            Auth::login($authUser);
        }
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = [$this->username() => trans('auth.failed')];
        Session::flash('message', json_encode(array('type'=>'error','message'=>'Invalid credentials',true)));
        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }

        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }


    
}
