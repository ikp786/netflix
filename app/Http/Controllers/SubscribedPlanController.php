<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Models\SubscribedPlan;
use App\Models\User;
use Auth;
use Validator;
use yajra\Datatables\Datatables;

class SubscribedPlanController extends Controller
{  
    function __construct()
    { 
        $this->middleware('permission:subscribed_plan-list|subscribed_plan-create|subscribed_plan-edit|subscribed_plan-delete', ['only' => ['index','show']]);
        $this->middleware('permission:subscribed_plan-create', ['only' => ['create','store']]);
        $this->middleware('permission:subscribed_plan-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:subscribed_plan-delete', ['only' => ['destroy']]);   
    }
     
    public function index(Request $request,$user_id="")
    { 
        $getUser = User::where('id',$user_id)->first(['name']);
        $user_name = (isset($getUser->name)) ? ucwords($getUser->name) : ""; 
        return view('admin.subscribed_user_plan.index',compact('user_id','user_name'));    
    }
     
    public function call_data(Request $request)
    {    
        if($request->user_id){  
            $get_data = SubscribedPlan::leftjoin('subscription_plans','subscription_plans.id','=','subscribed_plans.subscription_plan_id')->
                leftjoin('users','users.id','=','subscribed_plans.user_id')->orderBy('subscribed_plans.id','desc')->where('subscribed_plans.user_id',$request->user_id)->get(['subscribed_plans.*','subscription_plans.plan_title','subscription_plans.plan_for_month','subscription_plans.price','subscription_plans.discount_in_percent']); 
        }else{
            $get_data = SubscribedPlan::leftjoin('subscription_plans','subscription_plans.id','=','subscribed_plans.subscription_plan_id')->
                leftjoin('users','users.id','=','subscribed_plans.user_id')->orderBy('subscribed_plans.id','desc')->get(['subscribed_plans.*','subscription_plans.plan_title','subscription_plans.plan_for_month','subscription_plans.price','subscription_plans.discount_in_percent']); 
        }
 
        return Datatables::of($get_data)
            ->addIndexColumn() 
            ->editColumn("plan_title",function($get_data){
                return $get_data->plan_title;
            })
            ->editColumn("transaction_id",function($get_data){
                return $get_data->transaction_id;
            })
            ->editColumn("plan_for_month",function($get_data){
                return $get_data->plan_for_month;
            })
            ->editColumn("expiry_date",function($get_data){
                return date("Y-m-d", strtotime($get_data->expiry_date)); // return $get_data->expiry_date;
            })
            ->editColumn("status",function($get_data){
                if($get_data->status=='1')
                    return '<label class="btn btn-xs btn-primary">Active</label>';
                else if($get_data->status=='2')
                    return '<label class="btn btn-xs btn-warning">Cancelled</label>'; 
                else if($get_data->status=='3')
                    return '<label class="btn btn-xs btn-primary">Upgrated</label>';  
                else if($get_data->status=='4')
                    return '<label class="btn btn-xs btn-danger">Expired</label>'; 
            })->rawColumns(['status'])->make(true);

    }
 
    public function store(Request $request)
    {  
    }
    
    public function destroy($id)
    {  
    }


    public function create()
    {  
    }
    
    public function show($id)
    { 
    }
    
    public function edit($id)
    { 
    }
   
    public function update(Request $request, $id)
    {  
    }
 
    
}