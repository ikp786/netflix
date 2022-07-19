<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;  
use App\Models\SubscribedPlan;
use App\Models\SubscriptionPlan;
use App\Models\Category;
use App\Models\Product;  
use App\Models\SubProduct;
use App\Models\ContactDetail;
use Auth;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {   
        $user_id = Auth::id(); 

        $totalUsers = User::where('role_id','!=','1')->count();
        $totalMembershipPlan = SubscriptionPlan::count();
        $totalSubscribers = SubscribedPlan::leftjoin('subscription_plans','subscription_plans.id','=','subscribed_plans.subscription_plan_id')->leftjoin('users','users.id','=','subscribed_plans.user_id')->where('subscribed_plans.status','1')->count();

        if(Auth::user()->hasRole('admin')){
            $totalCustomer = User::where('role_id','2')->count(); 
            $totalCategory = Category::count(); 

            $totalSubCategory = Product::count(); 
            $totalContact = ContactDetail::count(); 
            $totalVideo = SubProduct::count();

            return view('admin.home',compact('totalCustomer','totalCategory','totalSubCategory','totalVideo','totalSubscribers','totalContact','totalMembershipPlan')); 
        } 
 
        
    }
}
