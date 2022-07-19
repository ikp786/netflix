<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ApiController;

Route::get('unauthorized', function () {
    return response()->json(['status'=>false,'code' => 401, 'data'=>[], 'message' => 'Unauthorized user.']);
})->name('api.unauthorized');

Route::post('signup_api', [AuthController::class, 'signup_api']); 
Route::post('login_api', [AuthController::class, 'login_api']);
Route::post('social_media_login', [AuthController::class, 'social_media_login']); 
Route::post('reset_password_api', [AuthController::class, 'reset_password_api']); 


Route::post('get_course_list', [ApiController::class, 'get_course_list']);

Route::post('get_package_list', [ApiController::class, 'get_package_list']);
    
Route::post('get_course_detail', [ApiController::class, 'get_course_detail']);

Route::group(['middleware' => ['auth:api']], function(){ 
    
    Route::get('get_user_profile', [ApiController::class, 'get_user_profile']);

    Route::post('add_rating', [ApiController::class, 'add_rating']);
    Route::post('add_comment', [ApiController::class, 'add_comment']);
    Route::post('like_unlike', [ApiController::class, 'like_unlike']);
    
    Route::any('stripe_call', [ApiController::class, 'stripe_call']);
    
    Route::post('get_progress_list', [ApiController::class, 'get_progress_list']);

    Route::post('add_question_for_review', [ApiController::class, 'add_question_for_review']);

    Route::post('add_to_cart', [ApiController::class, 'add_to_cart']);
    Route::post('get_cart_list', [ApiController::class, 'get_cart_list']);
    Route::post('delete_cart_item', [ApiController::class, 'delete_cart_item']);
   
    // Route::post('get_course_detail', [ApiController::class, 'get_course_detail']);
    
    Route::post('get_questions_list', [ApiController::class, 'get_questions_list']);
    Route::post('review_test_before_finish', [ApiController::class, 'review_test_before_finish']);
    Route::post('get_score_after_test_finish', [ApiController::class, 'get_score_after_test_finish']);
    
    Route::post('add_examdate_to_course', [ApiController::class, 'add_examdate_to_course']);
    Route::post('add_tutorial_note', [ApiController::class, 'add_tutorial_note']);
    Route::post('add_tutorial_bookmark', [ApiController::class, 'add_tutorial_bookmark']);

    Route::post('add_watched_tutorial', [ApiController::class, 'add_watched_tutorial']);
    Route::post('make_test', [ApiController::class, 'make_test']);
    Route::post('finish_test', [ApiController::class, 'finish_test']);

    Route::post('delete_popup_or_banner', [ApiController::class, 'delete_popup_or_banner']);
    Route::post('get_category_list', [ApiController::class, 'get_category_list']);
    Route::post('get_tutorial_list', [ApiController::class, 'get_tutorial_list']);
 
    Route::post('purchase_plan', [ApiController::class, 'purchase_plan']);
    
    Route::post('update_transaction', [ApiController::class, 'update_transaction']);
    
});
 Route::get('get_category_list_mn', [ApiController::class, 'get_category_list_mn']);

  Route::get('check_mailsend_api', [ApiController::class, 'check_mailsend_api']);
  