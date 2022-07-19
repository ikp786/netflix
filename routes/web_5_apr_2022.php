<?php
  
use Illuminate\Support\Facades\Route;
  
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AdminController; 
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\ContactDetailController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SpecialistController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SubProductController;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\SubscriptionPlanController;
use App\Http\Controllers\SubscribedPlanController;

Route::get('verify/{token?}', 'App\Http\Controllers\Auth\RegisterController@verify_token'); 

Route::get('/verif_callback', function (){
      return view('auth.verif_callback');
});

Route::get('/admin', function (){
      return view('auth.login');
}); 

Route::post('/get_search_video_list', [HomeController::class, 'get_search_video_list']);

Route::get('/', [HomeController::class, 'index'])->name('home');
//Route::get('/', [HomeController::class, 'index']);
Route::get('/fr_category', [HomeController::class, 'category']);
Route::post('/fr_sub_category', [HomeController::class, 'sub_category']);
Route::post('/fr_video', [HomeController::class, 'video']);
Route::post('/fr_video_front_search', [HomeController::class, 'video_front_search']);
Route::get('/fr_video_detail/{video_id}', [HomeController::class, 'video_detail']);

Route::get('/fr_video_play/{video_id}', [HomeController::class, 'fr_video_play']);

Route::get('/fr_page/{page_id}', [HomeController::class, 'fr_page']);

Route::get('/fr_membership', [HomeController::class, 'membership']);
Route::get('/fr_plan_list', [HomeController::class, 'membership_plan_list']); 

Route::post('/save_profile', [HomeController::class, 'save_profile']); 

Route::post('/otp_verification_for_web', [HomeController::class, 'otp_verification_for_web']); 
Route::post('/delete_from_my_list_web', [HomeController::class, 'delete_from_my_list_web']); 
Route::post('/delete_from_download_web', [HomeController::class, 'delete_from_download_web']); 
Route::post('add_update_subscription_plan_web', [HomeController::class, 'add_update_subscription_plan_web']);
Route::post('/signup_api_web', [HomeController::class, 'signup_api_web']); 

Route::get('fr_logout', [UserController::class, 'fr_logout'])->name('fr_logout');

Route::get('/list_page', function () {
    return view('page.list');
});
Route::get('/fr_login', function () {  
    return view('front.login');
});
Route::get('/fr_signup', [HomeController::class, 'fr_signup']); 

Route::get('/fr_contact', function () {  
    return view('contact');
});
Route::get('/fr_otp_verification', function () {  
    return view('front.otp_verification');
});
Auth::routes();

Auth::routes(['verify' => true]);

Route::get('logout', [UserController::class, 'logout'])->name('logout');


Route::group(['middleware' => ['auth','verified']], function(){
    Route::post('add_review_rating', [ApiController::class, 'add_review_rating']); 
    Route::post('add_to_my_list', [ApiController::class, 'add_to_my_list']);
    Route::get('/fr_profile/{tab_id?}', [HomeController::class, 'profile']);
    Route::get('/fr_edit_profile', [HomeController::class, 'fr_edit_profile']); 

    Route::get('/fr_my_watchlist', [HomeController::class, 'my_watchlist']);

    Route::resource('notification', NotificationController::class);
    Route::get('notification_call_data', 'App\Http\Controllers\NotificationController@support_call_data');
    Route::get('notification_detail_call_data/{user_id?}', 'App\Http\Controllers\NotificationController@call_data');
    Route::get('notification/notification_detail/{user_id?}', 'App\Http\Controllers\NotificationController@notification_detail');

    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::get('role_call_data', 'App\Http\Controllers\RoleController@call_data');

    Route::get('subscripted_user_list', 'App\Http\Controllers\UserController@subscripted_user_list');

    Route::resource('permission', PermissionController::class);
    Route::get('permission_call_data', 'App\Http\Controllers\PermissionController@call_data');
    Route::post('permission_get_data', 'App\Http\Controllers\PermissionController@get_data');

    Route::resource('page', PageController::class);
    Route::get('page_call_data', 'App\Http\Controllers\PageController@call_data');

    Route::resource('category', CategoryController::class);
    Route::get('category_call_data', 'App\Http\Controllers\CategoryController@call_data');
    Route::post('category_get_data', 'App\Http\Controllers\CategoryController@get_data');
    Route::post('category_status_update','App\Http\Controllers\CategoryController@status_update');

            Route::resource('product', ProductController::class);
            Route::get('product_call_data', 'App\Http\Controllers\ProductController@call_data');
            Route::post('product_get_data', 'App\Http\Controllers\ProductController@get_data');
            Route::post('product_status_update','App\Http\Controllers\ProductController@status_update');

            Route::get('view_sub_product/{id}', 'App\Http\Controllers\SubProductController@index'); 

            Route::resource('sub_product', SubProductController::class);
            Route::get('sub_product_call_data', 'App\Http\Controllers\SubProductController@call_data');
            Route::post('sub_product_get_data', 'App\Http\Controllers\SubProductController@get_data');
            Route::post('sub_product_status_update','App\Http\Controllers\SubProductController@status_update');

 
            Route::resource('subscription_plan', SubscriptionPlanController::class);
            Route::get('subscription_plan_call_data', 'App\Http\Controllers\SubscriptionPlanController@call_data');
            Route::post('subscription_plan_get_data', 'App\Http\Controllers\SubscriptionPlanController@get_data');
            
            Route::get('subscribed_plan/{user_id?}', 'App\Http\Controllers\SubscribedPlanController@index');

            Route::resource('subscribed_plan', SubscribedPlanController::class);
            Route::get('subscribed_plan_call_data', 'App\Http\Controllers\SubscribedPlanController@call_data');
            
            Route::post('support_reply_submit', 'App\Http\Controllers\ContactDetailController@support_reply_submit'); 
            Route::get('contact_us_call_data', 'App\Http\Controllers\ContactDetailController@call_data'); 
            Route::resource('contact_us', ContactDetailController::class);
            Route::post('contact_status_update','App\Http\Controllers\ContactDetailController@status_update'); 

            
    Route::resource('specialist', SpecialistController::class);
    Route::get('specialist_call_data', 'App\Http\Controllers\SpecialistController@call_data');
    Route::post('specialist_get_data', 'App\Http\Controllers\SpecialistController@get_data');
    Route::post('feature_status_update','App\Http\Controllers\SpecialistController@status_update'); 

    Route::resource('slider', SliderController::class);
    Route::get('slider_call_data', 'App\Http\Controllers\SliderController@call_data');
    Route::post('slider_get_data', 'App\Http\Controllers\SliderController@get_data');
    Route::post('slider_status_update','App\Http\Controllers\SliderController@status_update'); 

    Route::get('user_call_data', 'App\Http\Controllers\UserController@call_data');
    Route::post('user_status_update','App\Http\Controllers\UserController@status_update'); 
    
    Route::get('profile_show', 'App\Http\Controllers\UserController@profile_show');
    Route::get('profile_edit', 'App\Http\Controllers\UserController@profile_edit');

    Route::get('setting', 'App\Http\Controllers\UserController@setting_edit');

    // Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
     
     Route::get('/dashboard', [HomeController::class, 'front_login_check'])->name('dashboard');
});

Route::middleware('admin')->prefix('/admin')->group( function () {
 
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');  

});
 
