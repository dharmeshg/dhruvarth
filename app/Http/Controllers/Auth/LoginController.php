<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Mail\ForgotMail;
use Hash;
use Session;
use App\Models\User;
use Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index() {
        return view('auth.login');
    }

    public function customLogin(Request $request)
    {
        $input = $request->all();
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        
        $credentials = $request->only('email', 'password');
        $credentialsuser['email'] = $credentials['email'];
        $credentialsuser['password'] = $credentials['password'];

            if (Auth::attempt($credentials) ) {
                $user = Auth::user();
                 if ($user->role == 'administrator') {
                        if (isset($request->remember_me) && !empty($request->remember_me)) {
                            setcookie('email', $request->email, time() + 432000);
                            setcookie('password', $request->password, time() + 432000);
                        } else {
                            setcookie('email', '', time() - 3600);
                            setcookie('password', '', time() - 3600);
                        }

                        return redirect('admin/dashboard')->withSuccess('Signed in');
                    } else {
                        Auth::logout();
                        return redirect('admin/login')->with('error', 'You do not have access.');
                    }
            }else{
                return redirect('admin/login')
                    ->with('error','Email-Address And Password Are Wrong.');
            }
    }
    // public function userLogout() {
    //     auth()->logout();
    //     return redirect('admin/login');
    // }
    public function logout(Request $request)
        {
            $this->performLogout($request);
            return redirect('admin/login');
        }
    public function send_link_reset_view()
    {
        return view('auth.reset_pass_link');
    }

    public function send_link_reset(Request $request)
    {
        $email = $request->email;
        $user_data = User::where('email',$email)->first();
        if ($user_data != "") {
            if ($user_data->email != "") {
                $token = Str::random(64);
                $user = User::where('email',$email)->update(['reset_token' => $token]);
                Mail::to($user_data->email)->send(new ForgotMail($token));
                return redirect()->route('reset.pass.link.view')->with('success','Please Check Your Email');
            }else{
                return redirect()->route('reset.pass.link.view')->with('error','Email is not Registerd with us!.');
            }
          }else{
            return redirect()->route('reset.pass.link.view')->with('error','Please Check Your Email.');
          }
    }

    public function reset_pass_store_view($token)
    {
        $user_token = $token;
        return view('auth.forgot_pass', compact('user_token'));
    }

    public function update_password(Request $request)
    {
        $token = $request->token;
        $email = $request->email;
        $password = $request->password;
        $new_password = Hash::make($request->password);
        User::where('email',$email)
        ->update(['password' => $new_password, 'reset_token' => null]);
        return redirect()->route('login')->withSuccess('Your Password is Updated.!');
    }
}
