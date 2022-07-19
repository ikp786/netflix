<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Product; 
use App\Models\SubProduct; 
use App\Models\ReviewRating; 
use yajra\Datatables\Datatables; 
use DB;
use Auth;

class SubProductController extends Controller
{  
    function __construct()
    { 
        $this->middleware('permission:sub_product-list|sub_product-create|sub_product-edit|sub_product-delete', ['only' => ['index','show']]);
        $this->middleware('permission:sub_product-create', ['only' => ['create','store']]);
        $this->middleware('permission:sub_product-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:sub_product-delete', ['only' => ['destroy']]); 
    }
     
    public function index(Request $request,$product_id="")
    {   
        $get_category = Category::where('status','1')->get(['id','category_name']);
        $get_product = Product::where('status','1')->get(['id','product_name']);
        $get_rej_message = [];

        return view('admin.sub_product.index',compact('get_rej_message','product_id','get_product','get_category'));     
    }
    
    public function status_update(Request $request)
    {   
        request()->validate([
            'record_id' => 'required|integer',  
            'status' => 'required|integer', 
        ]);

        $find_dt = SubProduct::find($request->record_id);
        SubProduct::where('id',$request->record_id)->update(array('status'=>$request->status));
        
        return response()->json(['status'=>1,'message'=>'Video status updated.']); 
    } 
    
    public function call_data(Request $request)
    { 
        
        if($request->product_id){
            $get_data = SubProduct::orderBy('status','desc')->where('product_id',$request->product_id)->orderBy('sub_product_title','asc')->get();
        }else{
            $get_data = SubProduct::orderBy('status','desc')->orderBy('sub_product_title','asc')->get();
        } 

        return Datatables::of($get_data)
            ->addIndexColumn()
            ->editColumn("banner_image",function($get_data){
               if($get_data->banner_image){
                    return '<a href="'.url('uploads/'.$get_data->banner_image).'" target="_blank" >
                                <img src="'.url('uploads/'.$get_data->banner_image).'" style="width: 47px; margin-left:3px;" />
                            </a>';
                }else{
                    return "";
                }
               
            }) 
            ->editColumn("sub_product_title",function($get_data){
                return (@$get_data->sub_product_title) ? @$get_data->sub_product_title : "";
            })
             ->editColumn("year",function($get_data){
                return (@$get_data->year) ? @$get_data->year : "";
            })
            ->editColumn("category_name",function($get_data){
                return (@$get_data->category_id) ? @$get_data->category_detail->category_name : "";
            })
            ->editColumn("sub_category_name",function($get_data){
                return (@$get_data->product_id) ? @$get_data->product_detail->product_name : "";
            }) 
            ->editColumn("sub_product_type_name",function($get_data){
                return (@$get_data->sub_product_type_name) ? @$get_data->sub_product_type_name : "";
            })
            ->editColumn("status",function($get_data){

                   if($get_data->status=='1'){
                        return '<label class="switch switch-small">
                            <input type="checkbox" checked value="1" class="call_assign common_status_update ch_input"
                             title="Approve" data-id="'.$get_data->id.'" data-action="sub_product"  />
                            <span></span>
                        </label>';
                    }else{
                        return '<label class="switch switch-small">
                            <input type="checkbox" value="0" class="call_assign common_status_update ch_input"
                             title="Reject" data-id="'.$get_data->id.'" data-action="sub_product"  />
                            <span></span>
                        </label>';
                    }
            })
            ->editColumn("updated_at",function($get_data){
                return date("Y-m-d", strtotime(@$get_data->updated_at));
            })
            ->editColumn("rating",function($get_data){
                 $crr = ReviewRating::select(DB::raw('COALESCE(avg(rating),0) as avg_ratting'))->where('sub_product_id',$get_data->id)->first(); 
                $rat_count = $crr->avg_ratting; 
                /*return '<a class="btn btn-info btn-rounded btn-condensed btn-sm s_btn1 " >'.$rat_count.' <i class="fa fa-eye"></i></a>';*/
                return '<a class="btn btn-info btn-rounded btn-condensed btn-sm s_btn1 " target="_blank" href="https://stageofproject.com/cocrico/series-details.html" ><i class="fa fa-eye"></i></a>';
            })
            ->editColumn("action",function($get_data){

                $cr_form = '<form id="form_del_'.$get_data->id.'" action="'.route('sub_product.destroy',$get_data->id).'" method="POST">
                            <input type="hidden" name="_token" value="'.csrf_token().'" />';
 
                            $cr_form .= '<a class="btn btn-info btn-rounded btn-condensed btn-sm s_btn1 " href="'.route('sub_product.show',$get_data->id).'" ><i class="fa fa-eye"></i></a>';

              
                if(Auth::user()->can('sub_product-edit')){

                    $cr_form .= '<a class="btn btn-default btn-rounded btn-condensed btn-sm" href="'.route('sub_product.edit',$get_data->id).'"><i class="fa fa-pencil"></i></a> ';
 
                }   

                $cr_form .= '<input type="hidden" name="_method" value="DELETE"> ';

                /*if(Auth::user()->can('sub_product-delete')){
                    $cr_form .= '<button type="button" data-id="'.$get_data->id.'" class="btn btn-danger btn-rounded btn-condensed btn-sm del-confirm" ><i class="fa fa-trash"></i></button>'; 

                } */
                $cr_form .='</form>';

                return $cr_form;
            }) 
            ->rawColumns(['banner_image','status','rating','action'])->make(true);
           
    }

    public function create()
    {   
        $user_id = Auth::id(); 
        $get_category = Category::where('status','1')->get(['id','category_name']);
        $GetProduct = Product::orderBy('id','desc')->where('status','1')->get();   
         
        return view('admin.sub_product.create',compact('GetProduct','get_category'));
    }
 
    public function store(Request $request)
    {
        request()->validate([
            'sub_category_id' => 'required|integer',  
            'sub_product_title' => 'required',   
            'year' => 'required|integer',  
            'description' => 'required',  
            'status' => 'required|integer', 
            'video' => 'required|mimes:mp4,x-flv,x-mpegURL,MP2T,3gpp,quicktime,x-msvideo,x-ms-wmv',  
        ]);
        
        // 'video' => 'required|mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi',
         
        $input = $request->all();
         
        if($request->hasFile('banner_image')){   
            $banner_img_path = $request->banner_image->store('media');   
            $input['banner_image'] = $banner_img_path;
        } 
        if($request->hasFile('video')){   
            $media_img_path = $request->video->store('media');   
            $input['sub_media_url'] = $media_img_path;
        }

        if($request->sub_category_id){
            $input['product_id'] = $request->sub_category_id;
        }
        if($request->description){
            $input['sub_product_description'] = $request->description;
        } 
 
        $prop_data = SubProduct::create($input);
        $property_id = $prop_data->id;
                
        return redirect()->route('sub_product.index')->with('success','Video added successfully.');
    }
   
    public function show($id)
    {    
        $get_data = SubProduct::find($id); 
        $get_product_detail = Product::find($get_data->product_id);
        return view('admin.sub_product.show',compact('get_data','get_product_detail'));
    }
    
    public function edit($id)
    {
        $user_id = Auth::id();
        $get_data = SubProduct::find($id); 
        $get_category = Category::where('status','1')->get(['id','category_name']);
        $GetProduct = Product::orderBy('id','desc')->where('category_id',$get_data->category_id)->get(['id','product_name']);  
        
        return view('admin.sub_product.edit',compact('get_data','GetProduct','get_category'));
    }
   
    public function update(Request $request, $id)
    { 
        request()->validate([ 
            'sub_category_id' => 'required|integer',  
            'sub_product_title' => 'required',   
            'year' => 'required|integer',  
            'description' => 'required',  
            'status' => 'required|integer', 
            'video' => 'required|mimes:mp4,x-flv,x-mpegURL,MP2T,3gpp,quicktime,x-msvideo,x-ms-wmv',  
        ]);
        
        // 'video' => 'required|mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi',

        $input = $request->all(); 
        
        if($request->hasFile('banner_image')){   
            $banner_img_path = $request->banner_image->store('media');   
            $input['banner_image'] = $banner_img_path;
        }

        if($request->hasFile('video')){   
            $media_img_path = $request->video->store('media');   
            $input['sub_media_url'] = $media_img_path;
        }
        if($request->sub_category_id){
            $input['product_id'] = $request->sub_category_id;
        }
        if($request->description){
            $input['sub_product_description'] = $request->description;
        } 

        $res_data = SubProduct::find($id)->update($input);
         
        return redirect()->route('sub_product.index')->with('success','Video updated successfully');
    }
 
    public function destroy($id)
    {  
        $insert = SubProduct::where('id',$id)->delete();

        return redirect()->route('sub_product.index')->with('success','Video deleted successfully');
    }
 
}