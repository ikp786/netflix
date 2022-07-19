<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use Auth;
use Validator;
use yajra\Datatables\Datatables;

class SubscriptionPlanController extends Controller
{  
    function __construct()
    { 
        $this->middleware('permission:subscription_plan-list|subscription_plan-create|subscription_plan-edit|subscription_plan-delete', ['only' => ['index','show']]);
        $this->middleware('permission:subscription_plan-create', ['only' => ['create','store']]);
        $this->middleware('permission:subscription_plan-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:subscription_plan-delete', ['only' => ['destroy']]);   
    }
     
    public function index()
    { 
        return view('admin.subscription_plan.index',[]);    
    }
     
    public function call_data(Request $request)
    {
        $get_data = SubscriptionPlan::orderBy('created_at','desc')->get();

        return Datatables::of($get_data)
            ->addIndexColumn()
            ->editColumn("plan_title",function($get_data){
                return $get_data->plan_title;
            })
            ->editColumn("plan_for_month",function($get_data){
                return $get_data->plan_for_month;
            })
            ->editColumn("price",function($get_data){
                return $get_data->price;
            })
            ->editColumn("discount_in_percent",function($get_data){
                return $get_data->discount_in_percent;
            })
            ->editColumn("created_at",function($get_data){
                return date("Y-m-d", strtotime($get_data->created_at));
            })
            ->editColumn("action",function($get_data){

                $cr_form = '<form id="form_del_'.$get_data->id.'" action="'.route('subscription_plan.destroy',$get_data->id).'" method="POST">
                            <input type="hidden" name="_token" value="'.csrf_token().'" />';
 
                            /*$cr_form .= '<a class="btn btn-info btn-rounded btn-condensed btn-sm s_btn1 " href="'.route('category.show',$get_data->id).'" ><i class="fa fa-eye"></i></a>';*/

                $cr_form .= '<a class="btn btn-info btn-rounded btn-condensed btn-sm s_btn1 view_in_modal"
                  data-id="'.$get_data->id.'" data-toggle="modal" data-target="#modal_view_dt" ><i class="fa fa-eye"></i></a>';

                if(Auth::user()->can('subscription_plan-edit')){

                    /*$cr_form .= '<a class="btn btn-default btn-rounded btn-condensed btn-sm" href="'.route('category.edit',$get_data->id).'"><i class="fa fa-pencil"></i></a> ';*/


                    $cr_form .= '<a href="#" class="btn btn-default btn-rounded btn-condensed btn-sm form_data_act" data-id="'.$get_data->id.'"  ><i class="fa fa-pencil"></i></a> ';
                }   

                    $cr_form .= '<input type="hidden" name="_method" value="DELETE"> ';

                if(Auth::user()->can('subscription_plan-delete')){
                    $cr_form .= '<button type="button" data-id="'.$get_data->id.'" class="btn btn-danger btn-rounded btn-condensed btn-sm del-confirm" ><i class="fa fa-trash"></i></button>'; 

                } 
                $cr_form .='</form>';

                return $cr_form;
            }) 
            ->rawColumns(['status','action'])->make(true);

    }

    public function get_data(Request $request)
    {   
        if($request->record_id){
            $get_data = SubscriptionPlan::where('id',$request->record_id)->get()->toArray(); 
            return response()->json(['status'=>1,'message'=>'Record Found.','result'=>$get_data]);
        }else{
            return response()->json(['status'=>0,'message'=>'No Record Found.','result'=>array() ]);
        } 

    } 

    public function store(Request $request)
    { 

        $rules = [  
            'plan_title' => 'required', 
            'plan_for_month' => 'required', 
            'price' => 'required', 
            'discount_price' => 'required', 
            'discount_in_percent' => 'required',  
        ];
 
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            $error = '';
            if (!empty($validator->errors())){
                $error = $validator->errors()->first();
            }   

            return response()->json(['status'=>2,'message'=>$error ]);
        }
        
        if($request->record_id){

            $res_data = SubscriptionPlan::find($request->record_id);
            $res_data->plan_title = $request->input('plan_title');
            $res_data->plan_for_month = $request->input('plan_for_month');
            $res_data->price = $request->input('price');
            $res_data->discount_price = $request->input('discount_price');
            $res_data->discount_in_percent = $request->input('discount_in_percent');
 
            $res_data->save();
            
            return response()->json(['status'=>1,'message'=>'Record Updated Successfully.' ]);
        }else{
            $res_data = SubscriptionPlan::where(['plan_title' => $request->plan_title])->first();
            if(isset($res_data->id)){
                return response()->json(['status'=>2,'message'=>'Record Already Exist.' ]);
            }else{ 
                $input = $request->all(); 
                SubscriptionPlan::create($input);
            }
            return response()->json(['status'=>1,'message'=>'Record Added Successfully.']);
        } 
        return response()->json(['status'=>0,'message'=>'Record Submission Failed.' ]);
 
    }
    
    public function destroy($id)
    {  
        $insert = SubscriptionPlan::where('id',$id)->delete();

        return redirect()->route('subscription_plan.index')->with('success','Subscription Plan deleted successfully');
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