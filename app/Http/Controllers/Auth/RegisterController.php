<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    { 

        // $this->validator($request->all())->validate();

        $random_verify_str = $this->rand_string(14);
        
        $checkRegisteredEmail = User::where('email',$data['email'])->first();
        if(!empty($checkRegisteredEmail)){
             return back()->with('Error','Email Already Exist');  
        }else{    
            $verify_link = '<a href="'.env('APP_URL').'/verify/'.$random_verify_str.'" style="background-color: #7087A3; font-size: 12px; padding: 10px 15px; color: #fff; text-decoration: none">Verify Now</a>';
     
            $mail_data = [
                    'receiver' => ucwords(@$data['name']),  
                    'email' => $data['email'],  
                    'web_url' => env('APP_URL'), 
                    'verify_link' => $verify_link,
                ];
            
            if(env('MAIL_ON_OFF_STATUS')=="on"){ 
                \Mail::send('mails.registration_mail', $mail_data, function($message) use ($mail_data){
                    $message->to($mail_data['email']);
                    $message->from(env('MAIL_FROM_ADDRESS'), env('APP_NAME'));
                    $message->subject(env('APP_NAME').' Registration Verification Email');
                }); 
            }
     
            $UserData = new User;    
            $UserData->name = @$data['name']; 
            $UserData->email = $data['email']; 
            $UserData->phone = $data['phone']; 
            $UserData->password = Hash::make($data['password']); 
            $UserData->role_id = '2';

            $UserData->verify_code = $random_verify_str;
            $UserData->save();

            if($UserData->id){  
               return back()->with('Success','Verification link is send to your email. Please verify and login with your account...');  
            }else{
                return back()->with('Error','Something went');  
            } 
        }       
    }

    public function verify_token(Request $request,$token=false){
        // dd($token);
        $getUser = User::where('verify_code',$token)->whereNull('email_verified_at')->first();
        
        if($getUser){

                $Data = array(
                    "verify_code" => '',
                    "email_verified_at"=>date("Y-m-d h:m:s",strtotime("now"))
                ); 
                $data =  User::where('id', @$getUser->id)->update($Data);  
  
                auth()->attempt(['id' => $getUser->id, 'password' => $getUser->password]);
 
                $sessss_data = session([
                    'user_id'      => @$getUser->id, 
                    'username'     => @$getUser->name,
                    'user_contact' => @$getUser->mobile,
                ]);

                if (@$getUser->user_photo) {
                    session(['user_image' => @$getUser->user_photo]);
                } else {
                    session(['user_image' => 'include/dummy.png']);
                }

                //  return redirect()->route('dashboard');

                Session::flash('flash_message', 'Your account is verified. Please login.');
                Session::flash('flash_type', 'alert-success'); 

                return redirect('verif_callback'); 
 
            // return back()->with('success', 'Your profile is already registered.');

        }else{  
            Session::flash('flash_message', 'Invalid Credentials...');
            Session::flash('flash_type', 'alert-danger'); 

            return redirect('login'); 
        }
    }

    public function reset_verify_token(Request $request,$token=false){
         // dd($token);
        $getUser = User::where('verify_code',$token)->first();
        
        if($getUser){
            $resett_token = $token; 
            $data = compact('resett_token');
            return view('auth.passwords.reset',$data);    
        }else{  
            Session::flash('flash_message', 'Invalid Credentials...');
            Session::flash('flash_type', 'alert-danger');  
            return redirect('login'); 
        }
    }

    private function rand_string( $length ) {

        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($chars),0,$length);

    }
}
