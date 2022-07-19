<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Models\Permission;
use Auth;

use yajra\Datatables\Datatables;

class PermissionController extends Controller
{  
    function __construct()
    { 
        $this->middleware('permission:permission-list|permission-create|permission-edit|permission-delete', ['only' => ['index','show']]);
        $this->middleware('permission:permission-create', ['only' => ['create','store']]);
        $this->middleware('permission:permission-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:permission-delete', ['only' => ['destroy']]);   
    }
     
    public function index()
    { 
        return view('permission.index',[]);    
    } 
    
    public function call_data(Request $request)
    {
        $get_data = Permission::orderBy('name','asc')->get();

        return Datatables::of($get_data)
            ->addIndexColumn()
            ->editColumn("name",function($get_data){
                return $get_data->name;
            }) 
            ->editColumn("created_at",function($get_data){
                return date("Y-m-d", strtotime($get_data->created_at));
            })
            ->editColumn("action",function($get_data){

                $cr_form = '<form id="form_del_'.$get_data->id.'" action="'.route('permission.destroy',$get_data->id).'" method="POST">
                            <input type="hidden" name="_token" value="'.csrf_token().'" />';
  
                $cr_form .= '<a class="btn btn-info btn-rounded btn-condensed btn-sm s_btn1 view_in_modal"
                  data-id="'.$get_data->id.'" data-toggle="modal" data-target="#modal_view_dt" ><i class="fa fa-eye"></i></a>';

                if(Auth::user()->can('permission-edit')){ 
                    $cr_form .= '<a href="#" class="btn btn-default btn-rounded btn-condensed btn-sm form_data_act" data-id="'.$get_data->id.'"  ><i class="fa fa-pencil"></i></a> ';
                }   

                $cr_form .= '<input type="hidden" name="_method" value="DELETE" >';
 
                $cr_form .='</form>';

                return $cr_form;
            })->make(true);

    }

    public function get_data(Request $request)
    {   
        if($request->record_id){
            $get_data = Permission::where('id',$request->record_id)->get()->toArray(); 
            return response()->json(['status'=>1,'message'=>'Record Found.','result'=>$get_data]);
        }else{
            return response()->json(['status'=>0,'message'=>'No Record Found.','result'=>array() ]);
        } 

    } 

    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required', 
        ]); 
        
        if($request->record_id){

            $res_data = Permission::find($request->record_id);
            $res_data->name = $request->input('name'); 
            $res_data->save();
            
            return response()->json(['status'=>1,'message'=>'Record Updated Successfully.' ]);
        }else{
            $res_data = Permission::where(['name' => $request->name])->first();
            if(isset($res_data->id)){
                return response()->json(['status'=>2,'message'=>'Record Already Exist.' ]);
            }else{
                Permission::create($request->all());
            }
            return response()->json(['status'=>1,'message'=>'Record Added Successfully.']);
        } 
        return response()->json(['status'=>0,'message'=>'Record Submission Failed.' ]);
 
    }
    
    public function destroy($id)
    {  
        $insert = Permission::where('id',$id)->delete();

        return redirect()->route('permission.index')->with('success','Permission deleted successfully');
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