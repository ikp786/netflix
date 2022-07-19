<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Models\ContactDetail;
use Auth;
use App\Models\SubscriptionPlan;
use App\Models\Slider;
use App\Models\Product;
use App\Models\SubProduct;
use App\Models\Category;
use Validator;
use App\Helpers\ApiHelper; 
use App\Models\PhoneVerification;
use App\Models\User;

use App\Models\Bookmark;
use App\Models\Favourite;
use App\Models\Download;
use App\Models\SubscribedPlan;
use Str;
use App\Models\TempUser; 
use App\Models\Country; 
use Session;
use App\Http\Resources\SubProductCollection;
use App\Http\Resources\SubProductApiCollection;
use App\Models\Page;
use App\Models\PreferedCategory;
use DB;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{ 
    public function __construct()
    {
        // $this->middleware('auth');
    } 

    public function front_login_check()
    {    
         Auth::logout();
         return redirect('/');
    }

    public function index()
    {    
        $get_slider_data = Slider::orderBy('id','desc')->where(['slider_type'=>'0','status'=>'1'])->get();
        $get_category_data = Category::orderBy('category_name','asc')->where(['status'=>'1'])->pluck('category_name');
        $get_category_data = str_replace('"',' ', $get_category_data);
        $get_category_data = str_replace('[','', $get_category_data);
        $get_category_data = str_replace(']','', $get_category_data);
        $get_upcomming_data =  SubProduct::orderBy('id','desc')->where(['status'=>'1','video_type'=>3])->get(); 

        return view('home',compact('get_slider_data','get_upcomming_data','get_category_data')); 
    }
    
    public function json_view($req_status=false,$req_data="",$req_message="",$status_code="")
    {
        $this->status = $req_status;
        // $this->code = ($req_status==false) ? "404" : "";
        if($status_code!="")
            $this->code = $status_code;

        $this->data = $req_data;
        $this->message = $req_message;
        return response()->json($this);  
    }
    
    public function fr_signup(Request $request)
    {    
        $get_country = Country::orderBy('countries_name','asc')->get(['countries_id','countries_name']);
        return view('front.signup',compact('get_country'));
    }

    public function fr_edit_profile(Request $request)
    {   
        $id = Auth::id(); 
        $user = User::find($id);  
        $get_country = Country::orderBy('countries_name','asc')->get(['countries_id','countries_name']);
        return view('front.edit_profile',compact('user','get_country'));
    }

    public function save_profile(Request $request)
    {   
        $id = Auth::id(); 

        $this->validate($request, [
            'name' => 'required', 
            'phone' => 'required|unique:users,phone,'.$id, 
        ]); 
 
        $input = $request->all();
  
        $user = User::find($id);

        $input['verify_code'] = '';
        $input['email_verified_at'] = date("Y-m-d h:m:s",strtotime("now"));
        $input['phone_verified_at'] = date("Y-m-d h:m:s",strtotime("now"));
        
        if($request->hasFile('profile_photo_path')){   
            $profile_photo_img_path = $request->profile_photo_path->store('profile_photo_path'); 
            $input['profile_photo_path'] = $profile_photo_img_path;
        } 
        
        $user->update($input);
         
        return redirect()->back()->with('success', 'Profile updated successfully');   
    }

    public function otp_verification_for_web(Request $request)
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
            
            $find = PhoneVerification::where(['phone'=>$request->phone])->where('token', $request->token)->first();
            if($find)
            {    
                if($find->otp!=md5($request->otp)){
                    $message = 'OTP is not valid.';
                   
                    return $this->json_view(false,$req_data_obj,$message);

                }else{  

                    $user_data = TempUser::where(['phone'=>$request->phone,'country_code'=>$request->country_code])->first(['id','user_name','email','country_code','phone','country_flag_code','concated_phone','country','is_verified','device_token']);

                    if($user_data->is_verified=='1'){

                        $id = ['phone' => $user_data->phone,'country_code'=>$request->country_code];  
                        $password = Str::random('9');
                        $random_verify_str = Str::random('40').'.'.md5(time());
                        $input = [  
                            'name' => $user_data->user_name,
                            'email' => $user_data->email,
                            'country_code' => $user_data->country_code, 
                            'phone' => $user_data->phone, 
                            'country_flag_code' => $user_data->country_flag_code,
                            'concated_phone' => $user_data->concated_phone,
                            'country' => ($user_data->country) ? $user_data->country : "", 
                            'password' => Hash::make($password), 
                            'role_id' => '2', 
                            'device_token' => $user_data->device_token, 
                            'verify_code' => $random_verify_str, 
                            'is_verify' => '1', 
                            'phone_verified_at' => now(),
                            'email_verified_at' => now(),  
                        ];

                        $insert = User::updateOrCreate($id, $input);
                        
                        $tempUserId = $user_data->id;
                        TempUser::where('id',$tempUserId)->update(['is_verified'=>'2']);
                    }
                    
                    $dataNew = User::where(['phone'=>$request->phone,'country_code'=>$request->country_code])->first(['id','name','email','phone','phone_verified_at','status','device_token']);
                    // Auth::loginUsingId($user_data->id);
                    Auth::login($dataNew, true);
  
                    $data2 = ApiHelper::setJosnData($dataNew->toArray()); 
                        
                    $req_data = $data2; 
                    $req_data['access_token'] = $dataNew->createToken('authToken', ['user'])->accessToken;

                    Session()->put('bearer_token',$req_data['access_token']);
                    $crr = Session()->get('bearer_token');
        // dd($crr);

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

    public function signup_api_web(Request $request)
    {  
        $req_data = [];
        $req_data_obj = (object)[];
        try {  

                $rules = [ 
                    'user_name' => 'required',
                    'country_code' => 'required', 
                    'country' => 'required', 
                    'email' => 'required|unique:users,email',
                    'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|digits_between:6,15|unique:users,phone',  
                    'device_token' => 'required', 
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
                    'phone' => $request->phone, 
                    'country' => ($request->country) ? $request->country : "", 
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

    public function category()
    {     
        $get_data = Category::orderBy('category_name','asc')->where(['status'=>'1'])->get(); 
        return view('category_page',compact('get_data')); 
    }
    public function sub_category(Request $request)
    {   
        $ids = explode(',',$request->category_ids);  
        $get_data = Product::orderBy('product_name','asc')->whereIn('category_id',$ids)->where(['status'=>'1'])->get(); 
       
        return view('sub_category_page',compact('get_data')); 
    }
    public function video(Request $request)
    {       
        $main_category_ids = $request->category_ids;
        
        if(isset($request->Continue)){
            if(Auth::check()){
                $user_id = Auth::id(); 

                PreferedCategory::where(['user_id' => $user_id])->delete();

                $prev_idss = explode(',',$request->category_ids); 
                foreach($prev_idss as $valk){
                 
                    $newUser = PreferedCategory::create([
                        'user_id' => $user_id,
                        'category_id' => $valk, 
                    ]);
                }

            }
        }
        $QueSubCrr = Product::where(['status'=>'1']);
         
        $prev_sub_category_ids = '';
        if($request->filter_by=="category_search"){
          
            $QueSubCrr->where('id',$request->sub_category_ids);
            $prev_sub_category_ids = $request->prev_sub_category_ids; // remove this if u want all sub category data
        
        }else if($request->category_ids){
           
            $prev_sub_category_ids = $request->category_ids;
            $prev_idss = explode(',',$prev_sub_category_ids);                       
            $QueSubCrr->whereIn('category_id',$prev_idss);  
        
        } 

        $getSubbCatIds = $QueSubCrr->pluck('id')->toArray(); 
  
        $Que2 =  SubProduct::orderBy('id','desc')->where(['status'=>'1','video_type'=>1]);
        $Que3 =  SubProduct::orderBy('id','desc')->where(['status'=>'1','video_type'=>2]); 
        $Que4 =  SubProduct::orderBy('id','desc')->where(['status'=>'1','video_type'=>3]); 
         
        if(count($getSubbCatIds)>0){ 
            if($request->sub_category_ids){
                $sel_idss = explode(',',$request->sub_category_ids);   
            }else{ 
                $sel_idss = $getSubbCatIds; 
            } 
            $Que2->whereIn('product_id',$sel_idss);
            $Que3->whereIn('product_id',$sel_idss);
            $Que4->whereIn('product_id',$sel_idss);
        }else{
            if(!isset($request->search_by_name)){
                $Que2->where('product_id','no');
                $Que3->where('product_id','no');
                $Que4->where('product_id','no');
            }
        }
        if($request->search_by_name){ 

            $Que2->where('sub_product_title','like',$request->search_by_name.'%');
            $Que3->where('sub_product_title','like',$request->search_by_name.'%');
            $Que4->where('sub_product_title','like',$request->search_by_name.'%');
        } 
        /*echo $Que2->toSql();
        dd($request->search_by_name);*/
        $get_sub_category = Product::orderBy('product_name','asc')->whereIn('id',$getSubbCatIds)->get();
        $get_trending_data = $Que2->get();
        $get_popular_data = $Que3->get();
        $get_upcomming_data = $Que4->get();

        $record_type = ($request->filter_by=='search_by_all') ? "all" : '';
        if($request->sub_category_ids){
            $selected_sub_category =$request->sub_category_ids;
        }else{ 
            $selected_sub_category = ""; 
        }
        
        $filter_by = (@$request->filter_by) ? @$request->filter_by : ""; 
        return view('video_page',compact('filter_by','prev_sub_category_ids','selected_sub_category','get_sub_category','get_trending_data','get_popular_data','get_upcomming_data','record_type','main_category_ids')); 
    }

    public function video_front_search(Request $request)
    {
        //dd($request->all()); 

        $getCatIds = SubProduct::leftjoin('category','category.id','=','sub_products.category_id')->
            where('sub_products.sub_product_title','like',$request->search_by_name.'%')->
            orWhere('category.category_name','like',$request->search_by_name.'%')->groupBy('category_id')->pluck('sub_products.category_id')->toArray();
         
        $video_ids = SubProduct::leftjoin('category','category.id','=','sub_products.category_id')->
            where('sub_products.sub_product_title','like',$request->search_by_name.'%')->
            orWhere('category.category_name','like',$request->search_by_name.'%')->pluck('sub_products.id')->toArray();
        $get_sub_category = Product::orderBy('product_name','asc')->whereIn('category_id',$getCatIds)->get();
        $get_trending_data =  SubProduct::orderBy('id','desc')->where(['status'=>'1','video_type'=>1])->whereIn('id',$video_ids)->get();
        $get_popular_data =  SubProduct::orderBy('id','desc')->where(['status'=>'1','video_type'=>2])->whereIn('id',$video_ids)->get(); 
        $get_upcomming_data =  SubProduct::orderBy('id','desc')->where(['status'=>'1','video_type'=>3])->whereIn('id',$video_ids)->get();

        $main_category_ids = implode(',',$getCatIds);
        $prev_sub_category_ids="";
        $selected_sub_category = ""; 
        $filter_by = ""; 
        $record_type="";

        return view('video_page',compact('filter_by','prev_sub_category_ids','selected_sub_category','get_sub_category','get_trending_data','get_popular_data','get_upcomming_data','record_type','main_category_ids'));
    }

    public function get_search_video_list(Request $request) {
        
        $req_data = []; 
           
        $product_que = SubProduct::select('*'); 
        
        if(!isset($request->search_term)){ 
            $req_message = "No Record Found"; 
            return $this->json_view(true,$req_data,$req_message);
        } 
        if($request->search_term){ 
            $product_que->where('sub_product_title','like',$request->search_term.'%');
        }

        $product_que->withCount(['product_review' => function($query) {
            $query->select(DB::raw('COALESCE(avg(rating),0) as product_rating'));
        }]);

        $get_data = $product_que->orderBy('id','desc')->where('status','1')->get();

        $prop_result =  SubProductApiCollection::collection($get_data); 

        if($prop_result->isEmpty()){  
            $req_data = [];
            $req_message = "No Record Found"; 
        }else{
            $req_data =  $prop_result;
            $req_message = "Record Found";
        } 
            
        return $this->json_view(true,$req_data,$req_message);
    }

    public function profile($tab_id="")
    {    
        $get_data = User::find(Auth::user()->id); 
        
        $user_id = Auth::id();  
 
        $get_mylist_data = []; $get_subscribed_data = []; $get_trending_data=[]; $get_popular_data=[]; $get_download_data=[];

        if($tab_id=='2'){ // for mylist data

            $get_mylist_data = Favourite::leftjoin('sub_products','sub_products.id','=','favourite_table.sub_product_id')->orderBy('favourite_table.id','desc')->where(['favourite_table.user_id' => $user_id])->get(['sub_products.*']);  
            
        }else if($tab_id=='3'){ // for downloadlist data

            $get_download_data =  Download::leftjoin('sub_products','sub_products.id','=','download_tbl.sub_product_id')->orderBy('download_tbl.id','desc')->where(['download_tbl.user_id' => $user_id])->get(['sub_products.*']); 

        }else if($tab_id=='4'){ // for subscription data

            $get_subscribed_data = SubscribedPlan::leftjoin('subscription_plans','subscription_plans.id','=','subscribed_plans.subscription_plan_id')->
            leftjoin('users','users.id','=','subscribed_plans.user_id')->orderBy('subscribed_plans.id','desc')->where('subscribed_plans.user_id',$user_id)->first(['subscribed_plans.*','users.name','subscription_plans.plan_title','subscription_plans.plan_for_month','subscription_plans.price','subscription_plans.discount_in_percent']);
        }else{ // for watchlist data
            $get_trending_data =  Bookmark::leftjoin('sub_products','sub_products.id','=','bookmarks.sub_product_id')->orderBy('bookmarks.id','desc')->where(['bookmarks.user_id' => $user_id,'sub_products.video_type'=>1])->get(['sub_products.*']); 
 
            $get_popular_data =  Bookmark::leftjoin('sub_products','sub_products.id','=','bookmarks.sub_product_id')->orderBy('bookmarks.id','desc')->where(['bookmarks.user_id' => $user_id,'sub_products.video_type'=>2])->get(['sub_products.*']);  
        }  
        
        return view('profile_page',compact('get_data','get_mylist_data','get_subscribed_data','get_trending_data','get_popular_data','get_download_data','tab_id')); 
    }

    public function fr_page($page_id="")
    {   
        if($page_id!=""){
            $get_page_data = Page::where('id',$page_id)->first();
            return view('my_pages',compact('get_page_data')); 
        }  
    }

    public function my_watchlist()
    {    
        $get_data = User::find(Auth::user()->id); 
        
        $user_id = Auth::id();  

        $get_mylist_data = Favourite::leftjoin('sub_products','sub_products.id','=','favourite_table.sub_product_id')->orderBy('favourite_table.id','desc')->where(['favourite_table.user_id' => $user_id])->get(['sub_products.*']);  
          
        
        return view('my_watchlist',compact('get_data','get_mylist_data')); 
    }

    public function delete_from_my_list_web(Request $request) {
            
        $validator = Validator::make($request->all(),[
            'video_id' => 'required|integer',   
        ]);

        $user_id = Auth::id();

        $data = $request->all();
        $req_data = [];
        if($validator->fails()){
            $error = '';
            if (!empty($validator->errors())) {
                $error = $validator->errors()->first();
            } 
            $message = $error;
            return $this->json_view(false,$req_data,$message);
        }else    
        {    
            Favourite::where(['user_id' => $user_id,'sub_product_id' => $request->video_id])->delete();
            $req_message = "Video Deleted From My List";   
        }
            
        return redirect()->back();
    }

    public function delete_from_download_web(Request $request) {
            
        $validator = Validator::make($request->all(),[
            'video_id' => 'required|integer',   
        ]);

        $user_id = Auth::id();

        $data = $request->all();
        $req_data = [];
        if($validator->fails()){
            $error = '';
            if (!empty($validator->errors())) {
                $error = $validator->errors()->first();
            } 
            $message = $error;
            return $this->json_view(false,$req_data,$message);
        }else    
        {    
            Download::where(['user_id' => $user_id,'sub_product_id' => $request->video_id])->delete();
            $req_message = "Video Deleted From Download";   
        } 
        return redirect()->back();
    }

    public function video_detail($video_id)
    {    
        $bearer_token = Session()->get('bearer_token');
        
        $product_data =  SubProduct::where(['id'=>$video_id,'status'=>'1'])->first(); 
        $get_data =  new SubProductCollection($product_data);  
        $data = json_encode($get_data);
        $video_data = json_decode($data);
        
        $GetSimilarVid =  SubProduct::where(['category_id'=>$product_data->category_id])->where('id','!=',$product_data->id)->get();
        // dd($video_data);
        return view('video_detail',compact('video_data','video_id','bearer_token','GetSimilarVid')); 
    }

    public function fr_video_play($video_id)
    {    
        $bearer_token = Session()->get('bearer_token');
        
        // $video_data =  SubProduct::where(['id'=>$video_id,'status'=>'1'])->first(['id','sub_media_url']); 
        
        $product_data =  SubProduct::where(['id'=>$video_id,'status'=>'1'])->first(); 
        $get_data =  new SubProductCollection($product_data);  
        $data = json_encode($get_data);
        $video_data = json_decode($data);
       
        return view('video_play',compact('video_data')); 
    }

    public function membership()
    {   
        return view('membership_page'); 
    }

    public function membership_plan_list()
    {    
        $user_id = Auth::id();
        $get_data = SubscriptionPlan::orderBy('created_at','desc')->get(); 
        // dd($get_data);

        $current_subscribed_data = SubscribedPlan::leftjoin('subscription_plans','subscription_plans.id','=','subscribed_plans.subscription_plan_id')->
            leftjoin('users','users.id','=','subscribed_plans.user_id')->orderBy('subscribed_plans.id','desc')->where('subscribed_plans.user_id',$user_id)->first(['subscribed_plans.*','users.name','subscription_plans.plan_title','subscription_plans.plan_for_month','subscription_plans.price','subscription_plans.discount_in_percent']);
 
        return view('membership_plan_list',compact('get_data','current_subscribed_data')); 
    }

    public function add_update_subscription_plan_web(Request $request) {
            
        $validator = Validator::make($request->all(),[
            'plan_id' => 'required|integer',   
        ]);

        if(Auth::user()){
            $user_id = Auth::id();

            $data = $request->all();
            $req_data = [];
            if($validator->fails()){
                $error = '';
                if (!empty($validator->errors())) {
                    $error = $validator->errors()->first();
                } 
                $message = $error;
                return $this->json_view(false,$req_data,$message);
            }else    
            {    
                $is_fav = SubscribedPlan::where(['user_id' => $user_id,'subscription_plan_id' => $request->plan_id])->count(); 
  
                if($is_fav==0){ 

                    $newUser = SubscribedPlan::create([
                        'user_id' => $user_id,
                        'subscription_plan_id' => $request->plan_id,  
                    ]);
                    $req_message = "Your subscription added successfully";

                }else{

                    SubscribedPlan::where(['user_id' => $user_id])->update(['subscription_plan_id' => $request->plan_id]);
                    $req_message = "Your subscription plan is updated";

                }  
            }
               
        }    
        return redirect()->back();
    }

}
