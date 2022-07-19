<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Models\Category;
use Auth;
use Validator;
use yajra\Datatables\Datatables;

class CategoryController extends Controller
{  
    function __construct()
    { 
        $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['index','show']]);
        $this->middleware('permission:category-create', ['only' => ['create','store']]);
        $this->middleware('permission:category-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:category-delete', ['only' => ['destroy']]);   
    }
     
    public function index()
    { 
        return view('admin.category.index',[]);    
    }
    
    public function status_update(Request $request)
    {   
        request()->validate([
            'record_id' => 'required|integer',  
            'status' => 'required|integer', 
        ]);

        Category::where('id',$request->record_id)->update(array('status'=>$request->status));
        
        return response()->json(['status'=>1,'message'=>'Category status updated.']); 
    } 
    
    public function call_data(Request $request)
    {
        $get_data = Category::orderBy('status','desc')->orderBy('category_name','asc')->get();

        return Datatables::of($get_data)
            ->addIndexColumn()
            ->editColumn("category_name",function($get_data){
                return $get_data->category_name;
            })
            ->editColumn("category_image",function($get_data){
               if($get_data->category_image){
                    return '<a href="'.url('uploads/'.$get_data->category_image).'" target="_blank" >
                                <img src="'.url('uploads/'.$get_data->category_image).'" style="width: 47px; margin-left:3px;" />
                            </a>';
                }else{
                    return "";
                }
               
            })
            ->editColumn("status",function($get_data){
               if($get_data->status=='1'){
                    return '<label class="switch switch-small">
                        <input type="checkbox" checked value="1" class="common_status_update ch_input"
                         title="Active" data-id="'.$get_data->id.'" data-action="category"  />
                        <span></span>
                    </label>';
                }else{
                    return '<label class="switch switch-small">
                        <input type="checkbox" value="0" class="common_status_update ch_input"
                         title="Inactive" data-id="'.$get_data->id.'" data-action="category"  />
                        <span></span>
                    </label>';
                }
               
            })
            ->editColumn("created_at",function($get_data){
                return date("Y-m-d", strtotime($get_data->created_at));
            })
            ->editColumn("action",function($get_data){

                $cr_form = '<form id="form_del_'.$get_data->id.'" action="'.route('category.destroy',$get_data->id).'" method="POST">
                            <input type="hidden" name="_token" value="'.csrf_token().'" />';
 
                            /*$cr_form .= '<a class="btn btn-info btn-rounded btn-condensed btn-sm s_btn1 " href="'.route('category.show',$get_data->id).'" ><i class="fa fa-eye"></i></a>';*/

                $cr_form .= '<a class="btn btn-info btn-rounded btn-condensed btn-sm s_btn1 view_in_modal"
                  data-id="'.$get_data->id.'" data-toggle="modal" data-target="#modal_view_dt" ><i class="fa fa-eye"></i></a>';

                if(Auth::user()->can('category-edit')){

                    /*$cr_form .= '<a class="btn btn-default btn-rounded btn-condensed btn-sm" href="'.route('category.edit',$get_data->id).'"><i class="fa fa-pencil"></i></a> ';*/


                    $cr_form .= '<a href="#" class="btn btn-default btn-rounded btn-condensed btn-sm form_data_act" data-id="'.$get_data->id.'"  ><i class="fa fa-pencil"></i></a> ';
                }   

                    $cr_form .= '<input type="hidden" name="_method" value="DELETE"> ';

                /*if(Auth::user()->can('category-delete')){
                    $cr_form .= '<button type="button" data-id="'.$get_data->id.'" class="btn btn-danger btn-rounded btn-condensed btn-sm del-confirm" ><i class="fa fa-trash"></i></button>'; 

                } */
                $cr_form .='</form>';

                return $cr_form;
            }) 
            ->rawColumns(['category_image','status','action'])->make(true);

    }

    public function get_data(Request $request)
    {   
        if($request->record_id){
            $get_data = Category::where('id',$request->record_id)->get()->toArray(); 
            return response()->json(['status'=>1,'message'=>'Record Found.','result'=>$get_data]);
        }else{
            return response()->json(['status'=>0,'message'=>'No Record Found.','result'=>array() ]);
        } 

    } 

    public function store(Request $request)
    { 

        $rules = [  
            'category_name' => 'required', 
            'category_image' => 'required|mimes:jpg,jpeg,bmp,png,gif', 
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

            $res_data = Category::find($request->record_id);
            $res_data->category_name = $request->input('category_name');
            $res_data->status = $request->input('status');

            if($request->hasFile('category_image')){   
                $category_img_path = $request->category_image->store('category_image');   
                $res_data->category_image = $category_img_path;
            }
            $res_data->save();
            
            return response()->json(['status'=>1,'message'=>'Record Updated Successfully.' ]);
        }else{
            $res_data = Category::where(['category_name' => $request->category_name])->first();
            if(isset($res_data->id)){
                return response()->json(['status'=>2,'message'=>'Record Already Exist.' ]);
            }else{ 
                $input = $request->all();

                if($request->hasFile('category_image')){   
                    $category_image_url = $request->category_image->store('category_image');   
                    $input['category_image'] = $category_image_url; 
                } 
                Category::create($input);
            }
            return response()->json(['status'=>1,'message'=>'Record Added Successfully.']);
        } 
        return response()->json(['status'=>0,'message'=>'Record Submission Failed.' ]);
 
    }
    
    public function destroy($id)
    {  
        $insert = Category::where('id',$id)->delete();

        return redirect()->route('category.index')->with('success','Category deleted successfully');
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