<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ApiController;

Route::get('unauthorized', function () {
    return response()->json(['status'=>false,'code' => 401, 'data'=>[], 'message' => 'Unauthorized user.']);
})->name('api.unauthorized');

Route::post('signup_api', [AuthController::class, 'signup_api']);
Route::post('otp_verification', [AuthController::class, 'otp_verification']);
Route::post('resend_otp', [AuthController::class, 'resend_otp']);
Route::post('login_api', [AuthController::class, 'login_api']);
Route::post('change_password_api', [AuthController::class, 'change_password_api']);
Route::post('contact_us', [ApiController::class, 'contact_us']);

Route::get('get_category', [ApiController::class, 'get_category']); 

Route::get('get_language_type', [ApiController::class, 'get_language_type']); 

Route::get('check_get_email/{user_id?}', [ApiController::class, 'check_get_email']);

Route::post('get_sub_category', [ApiController::class, 'get_sub_category']);

Route::get('get_country_list', [ApiController::class, 'get_country_list']);

Route::group(['middleware' => ['auth:api']], function() { 
    
    Route::get('get_category', [ApiController::class, 'get_category']); 
    
    Route::post('get_page_detail', [ApiController::class, 'get_page_detail']);
      
    Route::get('get_user_profile', [ApiController::class, 'get_user_profile']);
    Route::post('update_user_profile', [ApiController::class, 'update_user_profile']);
    Route::get('get_user_notification', [ApiController::class, 'get_user_notification']);
    
    Route::get('logout', [AuthController::class, 'logout']);
    
    
    

    Route::post('add_review_rating', [ApiController::class, 'add_review_rating']); 

    Route::post('add_to_my_list', [ApiController::class, 'add_to_my_list']);
    Route::post('add_to_watchlist', [ApiController::class, 'add_to_watchlist']);
    Route::post('add_to_download', [ApiController::class, 'add_to_download']);
    Route::post('add_to_played_history', [ApiController::class, 'add_to_played_history']);

    Route::post('delete_from_my_list', [ApiController::class, 'delete_from_my_list']);
    Route::post('delete_from_watchlist', [ApiController::class, 'delete_from_watchlist']);
    Route::post('delete_from_download', [ApiController::class, 'delete_from_download']);
    Route::post('delete_played_history', [ApiController::class, 'delete_played_history']);

    Route::get('get_my_fav_list', [ApiController::class, 'get_my_fav_list']);
    
    Route::post('add_prefered_category', [ApiController::class, 'add_prefered_category']);
    
    Route::get('get_watchlist', [ApiController::class, 'get_watchlist']);
    Route::post('get_my_video_list', [ApiController::class, 'get_my_video_list']);
    Route::get('get_my_download_list', [ApiController::class, 'get_my_download_list']);
    Route::get('get_played_history', [ApiController::class, 'get_played_history']);

    Route::post('get_home_list', [ApiController::class, 'get_home_list']);

    Route::post('get_search_video_list', [ApiController::class, 'get_search_video_list']);
    Route::post('get_video_detail', [ApiController::class, 'get_video_detail']);

    

    Route::get('get_subscription_list', [ApiController::class, 'get_subscription_list']);

    Route::get('my_subscriptions', [ApiController::class, 'my_subscriptions']);

    Route::post('update_notification_status', [ApiController::class, 'update_notification_status']);

    Route::post('add_update_subscription_plan', [ApiController::class, 'add_update_subscription_plan']);
    
});
 
