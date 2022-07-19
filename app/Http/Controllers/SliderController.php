<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Models\Slider;
use Auth;
use Validator;
use yajra\Datatables\Datatables;

class SliderController extends Controller
{  
    function __construct()
    { 
        $this->middleware('permission:slider-list|slider-create|slider-edit|slider-delete', ['only' => ['index','show']]);
        $this->middleware('permission:slider-create', ['only' => ['create','store']]);
        $this->middleware('permission:slider-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:slider-delete', ['only' => ['destroy']]);   
    }
     
    public function index()
    { 
        return view('admin.slider.index',[]);    
    }
    
    public function status_update(Request $request)
    {   
        request()->validate([
            'record_id' => 'required|integer',  
            'status' => 'required|integer', 
        ]);

        Slider::where('id',$request->record_id)->update(array('status'=>$request->status));
        
        return response()->json(['status'=>1,'message'=>'Banner status updated.']); 
    } 
    
    public function call_data(Request $request)
    {
        $get_data = Slider::orderBy('status','desc')->orderBy('id','desc')->get();

        return Datatables::of($get_data)
            ->addIndexColumn() 
            ->editColumn("slider_type_name",function($get_data){
                return ($get_data->slider_type=='1') ? 'Profile Banner' : 'App Banner';
            })
            ->editColumn("slider_image",function($get_data){
               if($get_data->slider_image){
                    return '<a target="_blank" href="'.url('uploads/'.$get_data->slider_image).'" ><img src="'.url('uploads/'.$get_data->slider_image).'" style="width:30px;" /></a>';
                } 
            })
            ->editColumn("slider_video_url",function($get_data){
                return ($get_data->video_url) ? $get_data->video_url : '';
            })
            ->editColumn("status",function($get_data){
               if($get_data->status=='1'){
                    return '<label class="switch switch-small">
                        <input type="checkbox" checked value="1" class="common_status_update ch_input"
                         title="Active" data-id="'.$get_data->id.'" data-action="slider"  />
                        <span></span>
                    </label>';
                }else{
                    return '<label class="switch switch-small">
                        <input type="checkbox" value="0" class="common_status_update ch_input"
                         title="Inactive" data-id="'.$get_data->id.'" data-action="slider"  />
                        <span></span>
                    </label>';
                }
               
            })
            ->editColumn("created_at",function($get_data){
                return date("Y-m-d", strtotime($get_data->created_at));
            })
            ->editColumn("action",function($get_data){

                $cr_form = '<form id="form_del_'.$get_data->id.'" action="'.route('slider.destroy',$get_data->id).'" method="POST">
                            <input type="hidden" name="_token" value="'.csrf_token().'" />';
 
                            /*$cr_form .= '<a class="btn btn-info btn-rounded btn-condensed btn-sm s_btn1 " href="'.route('slider.show',$get_data->id).'" ><i class="fa fa-eye"></i></a>';*/

                $cr_form .= '<a class="btn btn-info btn-rounded btn-condensed btn-sm s_btn1 view_in_modal"
                  data-id="'.$get_data->id.'" data-toggle="modal" data-target="#modal_view_dt" ><i class="fa fa-eye"></i></a>';

                if(Auth::user()->can('slider-edit')){

                    /*$cr_form .= '<a class="btn btn-default btn-rounded btn-condensed btn-sm" href="'.route('slider.edit',$get_data->id).'"><i class="fa fa-pencil"></i></a> ';*/


                    $cr_form .= '<a href="#" class="btn btn-default btn-rounded btn-condensed btn-sm form_data_act" data-id="'.$get_data->id.'"  ><i class="fa fa-pencil"></i></a> ';
                }   

                    $cr_form .= '<input type="hidden" name="_method" value="DELETE"> ';

                /*if(Auth::user()->can('slider-delete')){
                    $cr_form .= '<button type="button" data-id="'.$get_data->id.'" class="btn btn-danger btn-rounded btn-condensed btn-sm del-confirm" ><i class="fa fa-trash"></i></button>'; 

                } */
                $cr_form .='</form>';

                return $cr_form;
            }) 
            ->rawColumns(['slider_image','status','action'])->make(true);

    }

    public function get_data(Request $request)
    {   
        if($request->record_id){
            $get_data = Slider::where('id',$request->record_id)->get()->toArray(); 
            return response()->json(['status'=>1,'message'=>'Record Found.','result'=>$get_data]);
        }else{
            return response()->json(['status'=>0,'message'=>'No Record Found.','result'=>array() ]);
        } 

    } 

    public function store(Request $request)
    {
        /*request()->validate([
            'slider_image' => 'required|mimes:jpg,bmp,png', 
        ]); */
        
        $rules = [  
            'slider_type' => 'required',
            'slider_image' => 'required|mimes:jpg,jpeg,bmp,png,gif', 
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

            $res_data = Slider::find($request->record_id);
            // $res_data->slider_name = $request->input('slider_name');
            $res_data->status = $request->input('status');

            $res_data->slider_type =   $request->input('slider_type');

            if($request->video_id){
                $res_data->video_id =   $request->input('video_id');
            }

            if($request->video_url){
                $res_data->video_url =   $request->input('video_url');
            }
            if($request->hasFile('slider_image')){   
                $category_img_path = $request->slider_image->store('slider_image');   
                $res_data->slider_image = $category_img_path;
            }
        
            $res_data->save();
            
            return response()->json(['status'=>1,'message'=>'Record Updated Successfully.' ]);
        }else{
            $input = $request->all();

            if($request->hasFile('slider_image')){   
                $slider_image_url = $request->slider_image->store('slider_image');   
                $input['slider_image'] = $slider_image_url; 
            } 
            Slider::create($input);
            return response()->json(['status'=>1,'message'=>'Record Added Successfully.']);
        } 
        return response()->json(['status'=>0,'message'=>'Record Submission Failed.' ]);
 
    }
    
    public function destroy($id)
    {  
        $insert = Slider::where('id',$id)->delete();

        return redirect()->route('slider.index')->with('success','Banner deleted successfully');
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