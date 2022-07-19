<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
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

    use AuthenticatesUsers;

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

    public function login(Request $request)
    {    
        $input = $request->all();
       
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
            $credentials = $request->only('email', 'password');
     
            if (auth()->attempt($credentials)) 
            {    

                $user = auth()->user();
              
                $user_roles = $user->getUserRole()->name;

                 

                if (!isset($user->email_verified_at)) {
                    Auth::logout();
                    
                    Session::flash('flash_message', 'Email-Address And Password Are Wrong.');
                    Session::flash('flash_type', 'alert-danger'); 

                    return redirect('/login')
                        ->withErrors([
                            'email' => 'Please verify your email address.',
                        ])->withInput();
                }else{     
                    
                    if($user_roles=="admin" || $user_roles=="user"){
                     
                        return redirect('/admin/dashboard')->withSuccess('Welcome to Dashboard.');
                    }else if($user_roles=="customer"){
                         return redirect()->route('home');
                    } 
                }
                
            }else{    

                Session::flash('flash_message', 'Email-Address And Password Are Wrong.');
                Session::flash('flash_type', 'alert-danger'); 

                 return redirect()->route('login')->with('error','Email-Address And Password Are Wrong.');
            } 
        

          
    }

    
}
