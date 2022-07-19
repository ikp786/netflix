<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

use Illuminate\Http\Request;
 
use App\Providers\RouteServiceProvider; 
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Auth\Events\Registered;
use Session;
use Auth;
 
use App\Http\Resources\CategoryCollection; 
use App\Http\Resources\SliderCollection; 
  
use App\Http\Resources\BookingViewCollection;
use App\Http\Resources\NotificationCollection;
use App\Http\Resources\UserCollection;
// use App\Http\Resources\UserResource;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\SubProductApiCollection;
use App\Http\Resources\SubProductCollection;
use App\Http\Resources\ProductDetailCollection;
use App\Http\Resources\SubProductDetailCollection;
use App\Http\Resources\ProductApiCollection;
use App\Http\Resources\SubscribedPlanCollection;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\ApiHelper;
use App\Models\Category;    
use DB;  
use App\Models\Page;  
use App\Models\Specialist;   
use App\Models\Slider;
use App\Models\Notification;  
use App\Models\ReviewRating; 
use App\Models\Product; 
use App\Models\SubProduct; 
use App\Models\Favourite; 
use App\Models\Bookmark; 
use App\Models\Download; 
use App\Models\PlayedVideoHistory; 
use App\Models\SubscriptionPlan; 
use App\Models\SubscribedPlan; 
use App\Models\ContactDetail; 
use App\Models\Country; 
use App\Models\PreferedCategory;    

class ApiController extends Controller
{   
    public function get_sub_category(Request $request){

        $validator = Validator::make($request->all(),[
            'category_id' => 'required|integer',  
        ]);

        $req_data = []; // (object)[];
        if($validator->fails()){
            $error = '';
            if (!empty($validator->errors())) {
                $error = $validator->errors()->first();
            } 
            $message = $error; 
            return $this->json_view(false,$req_data,$message); 
        }else    
        {   
            $res_data = ProductApiCollection::collection(Product::orderBy('id','desc')->where(['category_id'=>$request->category_id,'status'=>1])->get()); 

            if(!empty($res_data)){
                $req_data = $res_data;  
                $req_message = "Record Found"; 

                return $this->json_view(true,$req_data,$req_message);   
            }else{
                $req_message = "No Record Found"; 
                return $this->json_view(false,$req_data,$req_message);   
            }
        }  
    } 
    
    public function get_user_profile(Request $request) {
       
        $user_id = auth()->user()->id;

        $req_data = [];
        $user = User::find($user_id); 
    
        $getCountry = Country::where('countries_id',$user->country)->first(['countries_id','countries_name']);
        $req_data = [
            'user_id' => $user->id,
            'role_id' => $user->role_id ?? '', 
            'user_name' => $user->name ?? '', 
            'email' => $user->email ?? '', 
            'country_code' => $user->country_code ?? '', 
            'country_flag_code' => $user->country_flag_code ?? '', 
            'phone' => $user->phone ?? '', 
            'country_id' => $getCountry->countries_id ?? '', 
            'country_name' => $getCountry->countries_name ?? '', 
            'profile_image' => ($user->profile_photo_path) ? url('uploads/'.$user->profile_photo_path) : "", 
            'push_notification_status' => $user->push_notification_status, 
        ];
          
        $req_message = "User Information";
            
        return $this->json_view(true,$req_data,$req_message);
    }
    
    public function get_user_notification(Request $request) {

            $req_data = []; $req_data_obj = (object)[]; 
            $user_id = Auth::id(); 
            $getNotification =  Notification::where('user_id',$user_id)->orderBy('id','desc')->get();

            if(count($getNotification)){  
                $note_data = NotificationCollection::collection($getNotification); 
                $req_data['notification_list'] = $note_data;
                $req_message = "Record Found";   
                return $this->json_view(true,$req_data,$req_message);  
            } 
            $req_message = "No Record Found";  
            return $this->json_view(true,$req_data_obj,$req_message);  
 
    }

    public function check_get_email($user_id='') {
         
        $req_message ='';
        $user = DB::table('users')->find($user_id); 

        $req_data = [
            'user_id' => $user->id,
            'user_name' => $user->name ?? '', 
            'email' => strval($user->email),  
        ];  

        $req_message = "User Information";

        return $this->json_view(true,$req_data,$req_message);
    }
 
    /*public function update_user_profile(Request $request) {
               
        $user_id = auth()->user()->id;
        $auth_user_type = auth()->user()->user_type;
 
        $req_data = [];

        $rules = [  
            'user_name' => 'required',
            'country_code' => 'required', 
            'phone' => 'required|integer',
            'email' => 'required',
            'country' => 'required|integer',
        ]; 
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            $error = '';
            if (!empty($validator->errors())){
                $error = $validator->errors()->first();
            }  
            return $this->json_view(false,$req_data,$error);
        } 

        $input = [ 
            'name' => $request->user_name,  
            'country_code' => $request->country_code, 
            'country' => $request->country, 
        ];

        if($request->hasFile('profile_photo_path')){   
            $profile_photo_img_path = $request->profile_photo_path->store('profile_photo_path'); 
            $input['profile_photo_path'] = $profile_photo_img_path;
        }     
  
        $checkUserDt = User::find($user_id);  
        $email_update='0'; $phone_update='0';

        if(isset($checkUserDt->id)){
            if($checkUserDt->email!=$request->email){
                $input['email'] = $request->email;
                $email_update='1';

                $checkEmailRec = User::where('id','!=',$user_id)->where('email',$request->email)->first();
                if(!isset($checkEmailRec->id)){ 
                    User::where('id',$user_id)->update($input);
                } 
            }
            if($checkUserDt->phone!=$request->phone){
                $input['phone'] = $request->phone;  
                $phone_update='1';

                $checkPhoneRec = User::where('id','!=',$user_id)->where('phone',$request->phone)->first(); 
                if(!isset($checkPhoneRec->id)){ 
                    User::where('id',$user_id)->update($input);
                }
            }
        }    
         
        $resend_otp_status='0';
        if($email_update=='1' && $phone_update=='1'){
            $req_message = "Email & Phone Updated Successfully";
            $resend_otp_status='1';
        }elseif($email_update=='1'){
            $req_message = "Email Updated Successfully";
            $resend_otp_status='1';
        }elseif($phone_update=='1'){
            $req_message = "Phone Updated Successfully";
            $resend_otp_status='1';
        }else{
            $req_message = "Profile Updated Successfully";
        }
    
        $user = User::find($user_id); 
        
        $req_data['access_token'] = $user->createToken('authToken', ['user'])->accessToken;
        return $this->json_view(true,$req_data,$req_message); 
    } */
    
    public function update_user_profile(Request $request) {
               
        $user_id = auth()->user()->id;
        $auth_user_type = auth()->user()->user_type;
 
        $req_data = [];

        $rules = [  
            'user_name' => 'required',
            'country_code' => 'required', 
            'phone' => 'required|integer|unique:users,phone,'.$user_id,
            'email' => 'required|unique:users,email,'.$user_id,
            'country' => 'required|integer',
        ];
    

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            $error = '';
            if (!empty($validator->errors())){
                $error = $validator->errors()->first();
            }  
            return $this->json_view(false,$req_data,$error);
        } 

        $input = [ 
            'name' => $request->user_name,  
            'country_code' => $request->country_code, 
            'country' => $request->country, 
        ];
        if($request->country_flag_code){
            $input['country_flag_code'] = $request->country_flag_code;
        }
        if($request->hasFile('profile_photo_path')){   
            $profile_photo_img_path = $request->profile_photo_path->store('profile_photo_path'); 
            $input['profile_photo_path'] = $profile_photo_img_path;
        }     
        
        User::find($user_id)->update($input); 

        $req_message = "Profile Updated Successfully";
    
        $user = User::find($user_id); 
        
        $req_data['access_token'] = $user->createToken('authToken', ['user'])->accessToken;
        return $this->json_view(true,$req_data,$req_message); 
    } 

    public function get_page_detail(Request $request) {
          

        $validator = Validator::make($request->all(),[
            'page_id' => 'required|integer',  
        ]);

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
            $page_id = $request->page_id;
            
            $page_details = Page::find($page_id);
            if(isset($page_details->page_name)){
                $req_data = [
                    'page_name' => $page_details->page_name,
                    'page_content' => $page_details->page_content   
                ];

                $req_message = "Page Details Found";
                    
                return $this->json_view(true,$req_data,$req_message);
            }else{
                $req_message = "No Page Found";
                    
                return $this->json_view(false,$req_data,$req_message);
            }
        }    
    }

    public function get_category(Request $request){

        $req_data = CategoryCollection::collection(Category::orderBy('category_name','asc')->where('status',1)->get());  
        $req_message = "Record Found";  
        return $this->json_view(true,$req_data,$req_message);   

    } 
 
    public function get_speciality(Request $request){

        $validator = Validator::make($request->all(),[
            'category_id' => 'required|integer',  
        ]);

        $req_data = []; // (object)[];
        if($validator->fails()){
            $error = '';
            if (!empty($validator->errors())) {
                $error = $validator->errors()->first();
            } 
            $message = $error; 
            return $this->json_view(false,$req_data,$message); 
        }else    
        {  
            $res_data = Specialist::orderBy('id','desc')->where('category_id',$request->category_id)->get()->toArray(); 
            
            if(!empty($res_data)){
                $req_data = $res_data;  
                $req_message = "Record Found"; 

                return $this->json_view(true,$req_data,$req_message);   
            }else{
                $req_message = "No Record Found"; 
                return $this->json_view(false,$req_data,$req_message);   
            }
        }  
    } 
     
    public function get_home_list(Request $request) {
        
        $validator = Validator::make($request->all(),[
            'category_id' => 'required',  
        ]);

        $req_data = []; // (object)[];
        if($validator->fails()){
            $error = '';
            if (!empty($validator->errors())) {
                $error = $validator->errors()->first();
            } 
            $message = $error; 
            return $this->json_view(false,$req_data,$message); 
        }else    
        { 
            $req_data = [];  
            
            $QueSubCrr = Product::where(['status'=>'1']);
            if($request->category_id){
                $prev_sub_category_ids = $request->category_id;

                if($request->category_id=='all'){
                    $QueMnCat = Product::orderBy('product_name','asc')->where(['status'=>'1']);
                }else{
                    $prev_idss = explode(',',$prev_sub_category_ids);                       
                    $QueSubCrr->whereIn('id',$prev_idss); 
                }
            }
            $getSubbCatIds = $QueSubCrr->pluck('id')->toArray();
            
            $getSubCategory = Product::orderBy('product_name','asc')->whereIn('id',$getSubbCatIds)->get();  

            $get_slide = Slider::orderBy('id','desc')->where('status','1')->get(['id','slider_image','status']); 
            
            if($request->sub_category_id=="all"){
                $get_trending_data =  SubProduct::orderBy('id','desc')->where(['status'=>'1','video_type'=>1])->get();
                $get_popular_data =  SubProduct::orderBy('id','desc')->where(['status'=>'1','video_type'=>2])->get(); 
                $get_upcomming_data =  SubProduct::orderBy('id','desc')->where(['status'=>'1','video_type'=>3])->get();
            }else{
                $get_trending_data =  SubProduct::orderBy('id','desc')->whereIn('category_id',$getSubbCatIds)->where(['status'=>'1','video_type'=>1])->get();
                $get_popular_data =  SubProduct::orderBy('id','desc')->whereIn('category_id',$getSubbCatIds)->where(['status'=>'1','video_type'=>2])->get(); 
                $get_upcomming_data =  SubProduct::orderBy('id','desc')->whereIn('category_id',$getSubbCatIds)->where(['status'=>'1','video_type'=>3])->get();
            }    
            $req_data['category_records'] = ProductApiCollection::collection($getSubCategory); 
            $req_data['slider_records'] = SliderCollection::collection($get_slide); 
            $req_data['trending_data'] =  SubProductApiCollection::collection($get_trending_data);
            $req_data['popular_data'] =  SubProductApiCollection::collection($get_popular_data);
            $req_data['upcomming_data'] =  SubProductApiCollection::collection($get_upcomming_data);
            $req_message = "Record Found";
                
            return $this->json_view(true,$req_data,$req_message);
        }
    }

    public function get_search_video_list(Request $request) {
        
        $req_data = []; 
           
        $product_que = SubProduct::select('*'); 
        
        if(!isset($request->sub_category_id) && !isset($request->search_term)){ 
            $req_message = "No Record Found"; 
            return $this->json_view(true,$req_data,$req_message);
        }
        if($request->sub_category_id){ 
            $product_que->where('product_id',$request->sub_category_id);
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

    public function get_video_detail(Request $request) {
        
        $validator = Validator::make($request->all(),[
            'video_id' => 'required|integer',  
        ]);

        $data = $request->all();

        if($validator->fails()){
            $error = '';
            if (!empty($validator->errors())) {
                $error = $validator->errors()->first();
            } 
            $message = $error;
            return $this->json_view(false,$req_data,$message);
        }else    
        { 
            $req_data = [];    
               
            $product_data =  SubProduct::select('*')->where('id',$request->video_id)->get(); 
            $prod_result =  SubProductCollection::collection($product_data); 
 
            if($prod_result->isEmpty()){   
                $req_data['video_detail'] =  [];
                $req_message = "No Record Found"; 
            }else{
                $req_data['video_detail'] =  $prod_result; 
                $req_message = "Record Found";
            }  
            return $this->json_view(true,$req_data,$req_message);
        }
    }


    public function add_review_rating(Request $request) {
            
        $validator = Validator::make($request->all(),[
            'video_id' => 'required|integer', 
            'rating' => 'required',  
            'comment' => 'required', 
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
            $is_exist = ReviewRating::where(['user_id' => $user_id,'sub_product_id' =>$request->video_id])->count(); 

            if($is_exist==0){ 
                $newUser = ReviewRating::create([
                    'user_id' => $user_id, 
                    'sub_product_id' => $request->video_id,
                    'rating'=> $request->rating,
                    'comment'=> $request->comment 
                ]); 
                $req_message = "Rating Added Successfully";
            }else{ 
                $rev_arr = ['rating'=> $request->rating,'comment' => $request->comment ];

                ReviewRating::where(['user_id' => $user_id,'sub_product_id' => $request->video_id])->update($rev_arr); 

                $req_message = "Rating Update Successfully"; 
            }  
        }
            
        return $this->json_view(true,$req_data,$req_message);
    }
    
    public function add_to_my_list(Request $request) {
            
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
            $is_fav = Favourite::where(['user_id' => $user_id,'sub_product_id' =>$request->video_id])->count(); 
            $req_data['is_added']='0';
            if($is_fav==0){ 

                $newUser = Favourite::create([
                    'user_id' => $user_id,
                    'sub_product_id' => $request->video_id,  
                ]);
                $req_message = "Video Added To My List";
                $req_data['is_added']='1';
            }else{
                Favourite::where(['user_id' => $user_id,'sub_product_id' => $request->video_id])->delete();
                $req_message = "Video Removed From My List"; 
            }    
        }
            
        return $this->json_view(true,$req_data,$req_message);
    }

    public function add_to_watchlist(Request $request) {
            
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
            $is_fav = Bookmark::where(['user_id' => $user_id,'sub_product_id' => $request->video_id])->count(); 

            if($is_fav==0){ 

                $newUser = Bookmark::create([
                    'user_id' => $user_id,
                    'sub_product_id' => $request->video_id, 
                ]);
                $req_message = "Video Added To Watchlist";

            }else{ 
                Bookmark::where(['user_id' => $user_id,'sub_product_id' => $request->video_id])->delete();
                $req_message = "Video Removed From Watchlist"; 
            }    
        } 
        return $this->json_view(true,$req_data,$req_message);
    }
    public function add_to_download(Request $request) {
            
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
            $is_fav = Download::where(['user_id' => $user_id,'sub_product_id' => $request->video_id])->count(); 

            if($is_fav==0){ 

                $newUser = Download::create([
                    'user_id' => $user_id,
                    'sub_product_id' => $request->video_id, 
                ]);
                $req_message = "Video Added To Download";

            }else{ 
                Download::where(['user_id' => $user_id,'sub_product_id' => $request->video_id])->delete();
                $req_message = "Video Removed From Download"; 
            }    
        } 
        return $this->json_view(true,$req_data,$req_message);
    }

    public function add_to_played_history(Request $request) {
            
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
            $is_fav = PlayedVideoHistory::where(['user_id' => $user_id,'video_id' => $request->video_id])->count(); 
            $crr = [
                    'user_id' => $user_id,
                    'video_id' => $request->video_id, 
                ];
            if($is_fav==0){  
                $newUser = PlayedVideoHistory::create($crr);
                $req_message = "Video Added To History"; 
            }else{ 
                Download::where(['user_id' => $user_id,'video_id' => $request->video_id])->update($crr);
                $req_message = "Video Removed From History"; 
            }    
        } 
        return $this->json_view(true,$req_data,$req_message);
    }

    /**/

    public function delete_from_my_list(Request $request) {
            
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
            
        return $this->json_view(true,$req_data,$req_message);
    }

    public function delete_from_watchlist(Request $request) {
            
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
            Bookmark::where(['user_id' => $user_id,'sub_product_id' => $request->video_id])->delete();
            $req_message = "Video Deleted From Watchlist";    
        } 
        return $this->json_view(true,$req_data,$req_message);
    }
    public function delete_from_download(Request $request) {
            
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
        return $this->json_view(true,$req_data,$req_message);
    }

    public function delete_played_history(Request $request) {
        $user_id = Auth::id();
        $req_data = [];

        if($request->video_id){
            PlayedVideoHistory::where(['user_id' => $user_id,'video_id' => $request->video_id])->delete();
        }else{
            PlayedVideoHistory::where(['user_id' => $user_id])->delete();
        }   
        
        $req_message = "Video Deleted From History";   
       
        return $this->json_view(true,$req_data,$req_message);
    }

    public function get_watchlist(Request $request) {
          
        $user_id = Auth::id();  

        $get_trending_data =  Bookmark::leftjoin('sub_products','sub_products.id','=','bookmarks.sub_product_id')->orderBy('bookmarks.id','desc')->where(['bookmarks.user_id' => $user_id])->get(['sub_products.*']); 
        $req_data['all_data'] =  SubProductApiCollection::collection($get_trending_data);
        $req_message = "Record Found";  
        return $this->json_view(true,$req_data,$req_message);

    }

    public function get_my_video_list(Request $request) {
          
        $user_id = Auth::id();  

        /*$get_trending_data =  Favourite::leftjoin('sub_products','sub_products.id','=','favourite_table.sub_product_id')->orderBy('favourite_table.id','desc')->where(['favourite_table.user_id' => $user_id,'sub_products.video_type'=>1])->get(['sub_products.*']); 

        $get_popular_data =  Favourite::leftjoin('sub_products','sub_products.id','=','favourite_table.sub_product_id')->orderBy('favourite_table.id','desc')->where(['favourite_table.user_id' => $user_id,'sub_products.video_type'=>2])->get(['sub_products.*']); 

        $get_upcomming_data =  Favourite::leftjoin('sub_products','sub_products.id','=','favourite_table.sub_product_id')->orderBy('favourite_table.id','desc')->where(['favourite_table.user_id' => $user_id,'sub_products.video_type'=>3])->get(['sub_products.*']); */

        $trenQue =  SubProduct::orderBy('id','desc')->where(['sub_products.video_type'=>1]); 
        $popQue =  SubProduct::orderBy('id','desc')->where(['sub_products.video_type'=>2]);
        $uppQue =  SubProduct::orderBy('id','desc')->where(['sub_products.video_type'=>3]);

        if($request->sub_category_id){ 
            $trenQue->where('product_id',$request->sub_category_id);
            $popQue->where('product_id',$request->sub_category_id);
            $uppQue->where('product_id',$request->sub_category_id);
        }
        $get_trending_data = $trenQue->get(['sub_products.*']);
        $get_popular_data = $popQue->get(['sub_products.*']);
        $get_upcomming_data =  $uppQue->get(['sub_products.*']);

        $getSubCategory = Product::orderBy('product_name','asc')->where(['status'=>'1'])->get();
        $req_data['category_records'] = ProductApiCollection::collection($getSubCategory); 

        $req_data['trending_data'] =  SubProductApiCollection::collection($get_trending_data);
        $req_data['popular_data'] =  SubProductApiCollection::collection($get_popular_data);
        $req_data['upcomming_data'] =  SubProductApiCollection::collection($get_upcomming_data);
        $req_message = "Record Found";  
        return $this->json_view(true,$req_data,$req_message); 
    }   

    public function get_my_fav_list(Request $request) {
          
        $user_id = Auth::id();  

        $get_trending_data =  Favourite::leftjoin('sub_products','sub_products.id','=','favourite_table.sub_product_id')->orderBy('favourite_table.id','desc')->where(['favourite_table.user_id' => $user_id])->get(['sub_products.*']); 

        $req_data['all_data'] =  SubProductApiCollection::collection($get_trending_data);
        $req_message = "Record Found";  
        return $this->json_view(true,$req_data,$req_message); 
    }

    public function get_my_download_list(Request $request) {
          
        $user_id = Auth::id(); 
          
        $get_trending_data =  Download::leftjoin('sub_products','sub_products.id','=','download_tbl.sub_product_id')->orderBy('download_tbl.id','desc')->where(['download_tbl.user_id' => $user_id,'sub_products.video_type'=>1])->get(['sub_products.*']); 

        $get_popular_data =  Download::leftjoin('sub_products','sub_products.id','=','download_tbl.sub_product_id')->orderBy('download_tbl.id','desc')->where(['download_tbl.user_id' => $user_id,'sub_products.video_type'=>2])->get(['sub_products.*']); 

        $get_upcomming_data =  Download::leftjoin('sub_products','sub_products.id','=','download_tbl.sub_product_id')->orderBy('download_tbl.id','desc')->where(['download_tbl.user_id' => $user_id,'sub_products.video_type'=>3])->get(['sub_products.*']); 

        $req_data['trending_data'] =  SubProductApiCollection::collection($get_trending_data);
        $req_data['popular_data'] =  SubProductApiCollection::collection($get_popular_data);
        $req_data['upcomming_data'] =  SubProductApiCollection::collection($get_upcomming_data);
        $req_message = "Record Found";  
        return $this->json_view(true,$req_data,$req_message); 
    }

    public function get_played_history(Request $request) {
          
        $user_id = Auth::id(); 
          
        $get_recent_played_data =  PlayedVideoHistory::leftjoin('sub_products','sub_products.id','=','played_video_history.video_id')->orderBy('played_video_history.id','desc')->where(['played_video_history.user_id' => $user_id])->get(['sub_products.*']); 
 
        $req_data['recent_played_video'] =  SubProductApiCollection::collection($get_recent_played_data);
        $req_message = "Record Found";  
        return $this->json_view(true,$req_data,$req_message); 
    }

    public function contact_us(Request $request) {
            
        $validator = Validator::make($request->all(),[
            'subject' => 'required', 
            'description' => 'required', 

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

            $user_details = User::find($user_id);

            $newBooking = ContactDetail::create([ 
                'user_id' => @$user_id, 
                'user_name' => @$user_details->name,
                'email' => @$user_details->email,
                'mobile' => @$user_details->phone,
                'enquiry' => $request->subject,  
                'description' => $request->description,  
            ]); 
            $req_message = "Enquiry submitted successfully";
        }
            
        return $this->json_view(true,$req_data,$req_message);
    }

    public function get_country_list(Request $request){
 
        $req_data = [];  
        $res_data = Country::orderBy('countries_name','asc')->get(['countries_id as id','countries_name as country_name'])->toArray(); 
        
        if(!empty($res_data)){
            $req_data = $res_data;  
            $req_message = "Record Found"; 

            return $this->json_view(true,$req_data,$req_message);   
        }else{
            $req_message = "No Record Found"; 
            return $this->json_view(false,$req_data,$req_message);   
        } 
    } 
    

    public function get_subscription_list(Request $request){
 
        $req_data = [];  
        $res_data = SubscriptionPlan::orderBy('id','desc')->get()->toArray(); 
        
        if(!empty($res_data)){
            $req_data = $res_data;  
            $req_message = "Record Found"; 

            return $this->json_view(true,$req_data,$req_message);   
        }else{
            $req_message = "No Record Found"; 
            return $this->json_view(false,$req_data,$req_message);   
        } 
    } 
    
    public function my_subscriptions(Request $request){
        
        $user_id = Auth::id();

        $req_data = [];  
        $res_data = SubscribedPlan::leftjoin('subscription_plans','subscription_plans.id','=','subscribed_plans.subscription_plan_id')->
        leftjoin('users','users.id','=','subscribed_plans.user_id')->orderBy('subscribed_plans.id','desc')->where('subscribed_plans.user_id',$user_id)->get(['subscribed_plans.*','users.name','subscription_plans.plan_title','subscription_plans.plan_for_month','subscription_plans.price','subscription_plans.discount_in_percent'])->toArray(); 
        
        if(!empty($res_data)){
            $req_data = $res_data;  
            $req_message = "Record Found"; 

            return $this->json_view(true,$req_data,$req_message);   
        }else{
            $req_message = "No Record Found"; 
            return $this->json_view(false,$req_data,$req_message);   
        } 
    } 

    public function add_update_subscription_plan(Request $request) {
            
        $validator = Validator::make($request->all(),[
            'plan_id' => 'required|integer',   
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
            
        return $this->json_view(true,$req_data,$req_message);
    }

    public function get_my_subscribed_plans(Request $request) {
          
        $user_id = Auth::id(); 
        
        $get_prop =  SubscribedPlan::where(['user_id' => $user_id])->get(['*']); 
        
        if(count($get_prop)){  
            $book_data = SubscribedPlanCollection::collection($get_prop); 
            $req_data['subscribed_plan_list'] = $book_data;
            $req_message = "Record Found";  
            return $this->json_view(true,$req_data,$req_message); 
        }else{
            $req_data = (object)[];  
        }
         
        $req_message = "No Record Found";  
        return $this->json_view(false,$req_data,$req_message); 
    }


    public function update_notification_status(Request $request) {
            
        $validator = Validator::make($request->all(),[
            'status' => 'required',  
        ]);
 
        $data = $request->all();

        $req_data = []; // (object)[];
        if($validator->fails()){
            $error = '';
            if (!empty($validator->errors())) {
                $error = $validator->errors()->first();
            } 
            $message = $error;
            return $this->json_view(false,$req_data,$message,'101');
        }else    
        {    
            $user_id = Auth::id();
            $data = User::find($user_id);

            if($data->id!=''){  
                
                $input = [ 
                    'push_notification_status' => $request->status,  
                ];   
                                
                $insert = User::where('id',$user_id)->update($input);
                
                if($insert){  
                    $user_resp = User::where('id',$user_id)->first(['push_notification_status']);
                 
                    $req_data['notification_status'] = $user_resp->push_notification_status;
                    $message = 'Notification status updated.';
                    return $this->json_view(true,$req_data,$message,'104');
                } 
            }   

            $message = 'User not found.';
            return $this->json_view(false,$req_data_obj,$message,'101');
        }
            
        return $this->json_view(true,$req_data,$req_message);
    }

    public function add_prefered_category(Request $request) {
            
        $validator = Validator::make($request->all(),[
            'category_id' => 'required',   
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
            PreferedCategory::where(['user_id' => $user_id])->delete();

            $prev_idss = explode(',',$request->category_id); 
            foreach($prev_idss as $valk){
         
                $newUser = PreferedCategory::create([
                    'user_id' => $user_id,
                    'category_id' => $valk, 
                ]);
            }
            $req_message = "Prefered Category Added";   
        } 
        return $this->json_view(true,$req_data,$req_message);
    }

    public function json_view($req_status=false,$req_data="",$req_message="",$status_code="")
    {
        $this->status = $req_status;
        // $this->code = ($req_status==false) ? "101" : "104";
    
        if($status_code!=""){
            $this->code = $status_code;
        }else{
            $this->code = ($req_status==false) ? "101" : "104";
        }
        $this->data = $req_data;
        $this->message = $req_message;
        return  response()->json($this);  
    }  
 
}
