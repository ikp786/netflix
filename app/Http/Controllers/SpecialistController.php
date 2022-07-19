<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Specialist;
use yajra\Datatables\Datatables;
use Auth;

class SpecialistController extends Controller
{  
    function __construct()
    { 
    }
     
    public function index()
    {
        $get_category = Category::where('status','1')->pluck('category_name','id')->all();
        return view('admin.specialist.index',compact('get_category'));       
    }   
    
    public function status_update(Request $request)
    {   
        request()->validate([
            'record_id' => 'required|integer',  
            'status' => 'required|integer', 
        ]);

        Specialist::where('id',$request->record_id)->update(array('status'=>$request->status));
        
        return response()->json(['status'=>1,'message'=>'Status updated.']); 
    } 
    
    public function call_data(Request $request)
    {
        /*$get_dat22a = Specialist::orderBy('status','desc')->where('id','1')->first();
        dd($get_dat22a->category_data->category_name);*/
        $get_data = Specialist::orderBy('status','desc')->orderBy('specialist_name','asc')->get();

        return Datatables::of($get_data)
            ->addIndexColumn()
            ->editColumn("category_name",function($get_data){
                return ($get_data->category_id) ? @$get_data->category_data->category_name : "";
            })
            ->editColumn("specialist_name",function($get_data){
                return $get_data->specialist_name;
            })
            ->editColumn("status",function($get_data){
               if($get_data->status=='1'){
                    return '<label class="switch switch-small">
                        <input type="checkbox" checked value="1" class="common_status_update ch_input"
                         title="Active" data-id="'.$get_data->id.'" data-action="feature"  />
                        <span></span>
                    </label>';
                }else{
                    return '<label class="switch switch-small">
                        <input type="checkbox" value="0" class="common_status_update ch_input"
                         title="Inactive" data-id="'.$get_data->id.'" data-action="feature"  />
                        <span></span>
                    </label>';
                }
               
            })
            ->editColumn("created_at",function($get_data){
                return date("Y-m-d", strtotime($get_data->created_at));
            })
            ->editColumn("action",function($get_data){

                $cr_form = '<form id="form_del_'.$get_data->id.'" action="'.route('specialist.destroy',$get_data->id).'" method="POST">
                            <input type="hidden" name="_token" value="'.csrf_token().'" />';
 
                            /*$cr_form .= '<a class="btn btn-info btn-rounded btn-condensed btn-sm s_btn1 " href="'.route('specialist.show',$get_data->id).'" ><i class="fa fa-eye"></i></a>';*/

                $cr_form .= '<a class="btn btn-info btn-rounded btn-condensed btn-sm s_btn1 view_in_modal"
                  data-id="'.$get_data->id.'" data-toggle="modal" data-target="#modal_view_dt" ><i class="fa fa-eye"></i></a>';

                if(Auth::user()->can('specialist-edit')){

                    /*$cr_form .= '<a class="btn btn-default btn-rounded btn-condensed btn-sm" href="'.route('specialist.edit',$get_data->id).'"><i class="fa fa-pencil"></i></a> ';*/


                    $cr_form .= '<a href="#" class="btn btn-default btn-rounded btn-condensed btn-sm feature_form_data_act" data-id="'.$get_data->id.'"  ><i class="fa fa-pencil"></i></a> ';
                }   

                    $cr_form .= '<input type="hidden" name="_method" value="DELETE"> ';

                /*if(Auth::user()->can('specialist-delete')){
                    $cr_form .= '<button type="button" data-id="'.$get_data->id.'" class="btn btn-danger btn-rounded btn-condensed btn-sm del-confirm" ><i class="fa fa-trash"></i></button>'; 

                } */
                $cr_form .='</form>';

                return $cr_form;
            }) 
            ->rawColumns(['category_name','status','action'])->make(true);

    }

    public function get_data(Request $request)
    {   
        if($request->record_id){
            $get_data = Specialist::where('id',$request->record_id)->get()->toArray(); 
            return response()->json(['status'=>1,'message'=>'Record Found.','result'=>$get_data]);
        }else{
            return response()->json(['status'=>0,'message'=>'No Record Found.','result'=>array() ]);
        } 

    } 

    public function store(Request $request)
    {
        request()->validate([
            'specialist_name' => 'required', 
        ]); 
        
        if($request->record_id){

            $res_data = Specialist::find($request->record_id);
            $res_data->category_id = $request->input('category_id');
            $res_data->specialist_name = $request->input('specialist_name');
            $res_data->status = $request->input('status');
            $res_data->save();
            
            return response()->json(['status'=>1,'message'=>'Record Updated Successfully.' ]);
        }else{
            $res_data = Specialist::where(['specialist_name' => $request->specialist_name])->first();
            if(isset($res_data->id)){
                return response()->json(['status'=>2,'message'=>'Record Already Exist.' ]);
            }else{
                Specialist::create($request->all());
            }
            return response()->json(['status'=>1,'message'=>'Record Added Successfully.']);
        } 
        return response()->json(['status'=>0,'message'=>'Record Submission Failed.' ]);
 
    }
    
    public function destroy($id)
    {  
        $insert = Specialist::where('id',$id)->delete();

        return redirect()->route('specialist.index')->with('success','Record deleted successfully');
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