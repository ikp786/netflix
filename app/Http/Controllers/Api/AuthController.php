<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

use Illuminate\Http\Request;
 use Illuminate\Support\Facades\Http;
use App\Helpers\ApiHelper;

use App\Providers\RouteServiceProvider; 
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Auth\Events\Registered;
use Session;
use Illuminate\Support\Facades\Auth; 
use Symfony\Component\HttpFoundation\Response;
use App\Models\PhoneVerification; 
use Passport;
use Carbon\Carbon;
use Str;
use App\Models\TempUser;  
 

class AuthController extends Controller
{ 

    public function json_view($req_status=false,$req_data="",$req_message="",$status_code="")
    {
        $this->status = $req_status;
        // $this->code = ($req_status==false) ? "404" : "";
        if($status_code!="")
            $this->code = $status_code;

        $this->data = $req_data;
        $this->message = $req_message;
        return  response()->json($this);  
    }
  
 
    private function rand_string( $length ) {

        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($chars),0,$length);

    }
    
    public function login_api(Request $request)
    { 
        $req_data = (object)[];
        try {
            $rules = [ 
                'country_code' => 'required',
                'phone' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                }  
                return $this->json_view(false,$req_data,$error,'101');
            } 
            // $password = Hash::make($request->phone);


            /************** Project Create ****** */
            
            $user = User::where(['phone'=>$request->phone,'country_code'=>$request->country_code])->first();
            if(!$user){
               $message = 'Login details not found.';
                return $this->json_view(false,$req_data,$message,'108');
            }else { 
 
                 $data = User::where(['phone'=>$request->phone,'country_code'=>$request->country_code])->first();
                 $user_id = $data->id;
                 
                 if($data->status=='0'){ 

                    $message = 'Your account is not activated by admin.';
                    return $this->json_view(false,$req_data,$message,'102');

                 }elseif($data->phone_verified_at==''){ 
                    
                    $otp = rand(1000,9999); 

                    $new_tokken = Str::random('40').'.'.md5(time());

                    $input2 = [
                        'phone' => $request->phone,
                        'otp' => md5($otp),
                        'otp_text' => $otp,
                        'token' => $new_tokken
                    ];
                    $data22 = PhoneVerification::create($input2);
   
                    $data2 = ApiHelper::setJosnData($data22); 

                    $req_data = $data2; 
                    // $req_data['access_token'] = $new_tokken;

                    $message = 'Your account is not verified.';
                    return $this->json_view(false,$req_data,$message,'103');
                 
                 }else{
                    
                    $get_usr_data = User::where(['phone'=>$request->phone,'country_code'=>$request->country_code])->first(['id','name','email','country_code','country_flag_code','phone','role_id','email_verified_at','country','city_name','phone_verified_at','status','is_verify','verify_code','device_token','profile_photo_path','address','status'])->toArray();
 
                    $r_otp = rand(1000,9999);

                    $input2 = [
                        'phone' => $request->phone,
                        'otp' => md5($r_otp),
                        'otp_text' =>$r_otp,
                        'token' => Str::random('40').'.'.md5(time())
                    ]; 
                        $phone = $request->phone;
                        $check_phone = PhoneVerification::where('phone',$phone)->first();
                        if(isset($check_phone->id)){
 
                            PhoneVerification::where('id',$check_phone->id)->update($input2);
                            $insert_id = $check_phone->id;
                        }else{ 
                            $insert = PhoneVerification::create($input2); 
                            $insert_id = $insert;
                        }

                        if(isset($insert_id)){
                            $data = PhoneVerification::find($insert_id);
                            // $messageid='messsageid';
                            // $variables_values = $request->prospect_name|$customer->name|$customer->name|$insert->otp|'url';
                            // $numbers = $request->phone;
                            // ApiHelper::sendSMS($messageid, $variables_values, $numbers);

                            $data = ApiHelper::setJosnData($data->toArray());
                              
                            // $req_data['api_data'] = $data;

                            $req_data = $data;
                        }
                }
                
                if($request->device_token){
                    if(isset($user_id)){ 
                        User::where('id',$user_id)->update(array('device_token'=>$request->device_token));
                    }
                }   

                $message = 'Otp is send to your mobile.';
                return $this->json_view(true,$req_data,$message,'104');

            }  

        } catch (Exception $e) {  
            $message = $e->getMessage();
            return $this->json_view(false,$req_data,$message,'101');
        }
    }

    public function otp_verification(Request $request)
    {
        $req_data = [];
        $req_data_obj = (object)[];

        try {
            $rules = [
                'token' => 'required',
                'country_code' => 'required',
                'phone' => 'required',
                'otp' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                } 
                $message = $error;
                return $this->json_view(false,$req_data_obj,$message);
            }
            
            $find = PhoneVerification::where('phone', $request->phone)->where('token', $request->token)->first();
            if($find)
            {    
                if($find->otp!=md5($request->otp)){
                    $message = 'OTP is not valid.';
                   
                    return $this->json_view(false,$req_data_obj,$message);

                }else{  

                    $user_data = TempUser::where(['phone'=>$request->phone,'country_code'=>$request->country_code])->first(['id','user_name','email','country_code','country_flag_code','concated_phone','phone','country','is_verified','device_token','is_term_accept']);
                     
                    if($user_data->is_verified=='1'){

                        $id = ['phone' => $user_data->phone];  
                        $password = Str::random('9');
                        $random_verify_str = Str::random('40').'.'.md5(time());
                        $input = [  
                            'name' => $user_data->user_name,
                            'email' => $user_data->email,
                            'country_code' => $user_data->country_code, 
                            'country_flag_code' => $user_data->country_flag_code,
                            'phone' => $user_data->phone, 
                            'country_flag_code' => $user_data->country_flag_code,
                            'concated_phone' => $user_data->concated_phone,
                            'country' => ($user_data->country) ? $user_data->country : "", 
                            'password' => Hash::make($password), 
                            'role_id' => '2', 
                            'device_token' => $user_data->device_token, 
                            'verify_code' => $random_verify_str, 
                            'is_verify' => '1', 
                            'is_term_accept' => $user_data->is_term_accept,
                            'phone_verified_at' => now(), 
                            'email_verified_at'=>now()
                        ];

                        $insert = User::updateOrCreate($id, $input);
                        
                        $tempUserId = $user_data->id;
                        TempUser::where('id',$tempUserId)->update(['is_verified'=>'2']);
                    }
                    
                    $dataNew = User::where(['phone'=>$request->phone,'country_code'=>$request->country_code])->first(['id','name','email','phone','phone_verified_at','status','device_token']);

                    $data2 = ApiHelper::setJosnData($dataNew->toArray()); 
                        
                    $req_data = $data2; 
                    $req_data['access_token'] = $dataNew->createToken('authToken', ['user'])->accessToken;
 
                    
                    $message = 'Verification successfull.';
                    return $this->json_view(true,$req_data,$message);
                }
            }
 
            $message = 'Verification failed, Please try again.';
            return $this->json_view(false,$req_data_obj,$message);
 
        }catch (Exception $e){

            $message = $e->getMessage();
            return $this->json_view(false,$req_data_obj,$message); 

        }
    }
 
 
    public function change_password_api(Request $request)
    {
        $req_data = [];
        $req_data_obj = (object)[];

        try {
            $rules = [
                'token' => 'required', 
                'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|digits_between:6,15',
                'password' => 'required|same:confirm_password',
                'otp' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                } 
                $message = $error;
                return $this->json_view(false,$req_data_obj,$message);
            }
            
            $find = PhoneVerification::where('phone', $request->phone)->where('token', $request->token)->first();
            if($find)
            {    
                if($find->otp!=md5($request->otp)){
                    $message = 'OTP is not valid.';
                   
                    return $this->json_view(false,$req_data_obj,$message);

                }else{   
                    $data = User::where('phone', $request->phone)->first();

                    if($data->id!=''){ 

                        $id = ['phone' => $request->phone]; 
                        $input = [  
                            'password' => Hash::make($request->confirm_password),  
                        ];  

                        $insert = User::updateOrCreate($id, $input);
                        if ($insert) {  
                            $message = 'Password updated successfully.';
                            return $this->json_view(true,$req_data,$message);
                        } 
                    }   

                    $message = 'Password not update.';
                    return $this->json_view(false,$req_data_obj,$message);
                }
            }
 
            $message = 'Password update failed, Please try again.';
            return $this->json_view(false,$req_data_obj,$message);
 
        }catch (Exception $e){

            $message = $e->getMessage();
            return $this->json_view(false,$req_data_obj,$message); 

        }
    }
    
    public function resend_otp(Request $request)
    {
        try {
            $rules = [
                'country_code' => 'required',
                'phone' => 'required|numeric|regex:/^([0-9\s\-\+\(\)]*)$/'//|exists:users,phone',
            ];
            
            $validator = Validator::make($request->all(), $rules);

            $req_data = [];
            $req_data_obj = (object)[];

            if($validator->fails()){
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                } 
                $message = $error;
                return $this->json_view(false,$req_data_obj,$message);
            }


            $find = TempUser::where(['country_code'=>$request->country_code,'phone'=>$request->phone])->exists();
            if($find){
 
                $otp = rand(1000,9999);
                $phone = $request->only('phone');
                $input = $request->only('phone');
                $input['otp'] = md5($otp);
                $input['otp_text'] = $otp;
                $input['token'] = Str::random(40).'.'.time();

                $check_phone = PhoneVerification::where('phone',$phone)->first();
                if(isset($check_phone->id)){
                    PhoneVerification::where('id',$check_phone->id)->update($input);
                    $insert_id = $check_phone->id;
                }else{ 
                    $insert = PhoneVerification::create($input); 
                    $insert_id = $insert;
                }

                if (isset($insert_id)) { 
                    $data = PhoneVerification::find($insert_id);
                    // $messageid='messsageid';
                    // $variables_values = $request->prospect_name|$customer->name|$customer->name|$insert->otp|'url';
                    // $numbers = $request->phone;
                    // ApiHelper::sendSMS($messageid, $variables_values, $numbers);
 
                    $req_data = $data; 
                    $message = 'OTP successfully send on your phone.';
                    return $this->json_view(true,$req_data,$message);
                } 
                    
                $message = 'OTP sending failed.';
                return $this->json_view(false,$req_data_obj,$message);
            } 

            $message = 'This number is not registered, Please Register first.';
            return $this->json_view(false,$req_data_obj,$message);

        } catch (Exception $e){ 

            $message = $e->getMessage();
            return $this->json_view(false,$req_data,$message);

        }
    }

    public function signup_api(Request $request)
    {  
        $req_data = [];
        $req_data_obj = (object)[];
        try {  
               
                $rules = [ 
                    'user_name' => 'required',
                    'country_flag_code' => 'required',
                    'country_code' => 'required', 
                    'country' => 'required', 
                    'email' => 'required|email|unique:users,email',
                    'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|digits_between:6,15|unique:users,phone',  
                    'device_token' => 'required', 
                    'is_term_accept' => 'required',
                ];
    

                $validator = Validator::make($request->all(), $rules);

                if($validator->fails()){
                    $error = '';
                    if (!empty($validator->errors())){
                        $error = $validator->errors()->first();
                    }  
                    return $this->json_view(false,$req_data_obj,$error);
                }  
                $input = [ 
                    'user_name' => $request->user_name,
                    'email' => $request->email,
                    'country_code' => $request->country_code, 
                    'country_flag_code' => $request->country_flag_code,
                    'phone' => $request->phone, 
                    'concated_phone' => $request->country_code.$request->phone, 
                    'country' => ($request->country) ? $request->country : "", 
                    'is_term_accept' => ($request->is_term_accept) ? $request->is_term_accept : "0", 
                    'device_token' => $request->device_token,
                ]; 
                 
                $id2 = [
                    'phone' => $request->only('phone'),
                    'is_verified' => '1',
                ];
                $insert =  TempUser::updateOrCreate($id2, $input);
 
                if($insert){

                    $ins_id = $insert->id; 

                    $r_otp = rand(1000,9999);

                    $input2 = [
                        'phone' => $request->phone,
                        'otp' => md5($r_otp),
                        'otp_text' =>$r_otp,
                        'token' => Str::random('40').'.'.md5(time())
                    ];
                    $data = PhoneVerification::create($input2);
                    
                    // ApiHelper::sendSMS($messageid, $variables_values, $numbers);
                    $data = ApiHelper::setJosnData($data->toArray());
                   
                    $req_data = $data;
                    $message = 'Register successfully, Please verify your account.';
                    return $this->json_view(true,$req_data,$message);
                }  
        } catch (Exception $e) { 
            $message = $e->getMessage();
            return $this->json_view(false,$req_data_obj,$message);
        }
    }
   

    public function social_media_login(Request $request)
    {
        $req_data = [];
        try {
            $rules = array( 
                'social_media_id' => 'required', 
                'email' => 'required',   
                'social_media_type' => 'required' 
            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                } 
                $message = $error;
                return $this->json_view(false,$req_data,$message);
            }

            $input = $request->only('email');

            $getSoc_Dt = User::where('email', $request->email)->whereNotNull('email');

            if($request->social_media_type=="google"){

                $input['google_id'] = $request->social_media_id;  

            }else if($request->social_media_type=="facebook"){
                
                $input['facebook_id'] = $request->social_media_id; 

            }

            $find = $getSoc_Dt->first();

            if($find){  
                
                $input['email_verified_at'] = Carbon::now();
                
                User::where('email', $request->email)->update($input);

                $data = User::where('email', $request->email)->first();
 
                $data['access_token'] = $data->createToken('authToken', ['user'])->accessToken;
                $data = ApiHelper::setJosnData($data->toArray()); 

                $req_data['api_data'] = $data;
                $message = 'Your account register successfully.';
                return $this->json_view(true,$req_data,$message);
            }
 
            $message = 'Registration failed, Please try again.';
            return $this->json_view(false,$req_data,$message);
 
        }catch (Exception $e){

            $message = $e->getMessage();
            return $this->json_view(false,$req_data,$message); 

        }
    }
     
    public function logout(Request $request) {
        $req_data = [];
        try {
            $request->user()->token()->revoke();
            $message = 'User logout successfully.';
            return $this->json_view(true,$req_data,$message);
        } catch (Exception $e) {
            $message = 'Something went wrong.';
            return $this->json_view(false,$req_data,$message);
        }
    }
     
}
