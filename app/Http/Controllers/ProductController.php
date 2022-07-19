<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Product; 
use App\Models\SubProduct; 
use yajra\Datatables\Datatables; 

use Auth;

class ProductController extends Controller
{  
    function __construct()
    { 
        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show']]);
        $this->middleware('permission:product-create', ['only' => ['create','store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]); 
    }
     
    public function index()
    {    
        $get_rej_message = [];

        return view('admin.product.index',compact('get_rej_message'));     
    } 

    public function status_update(Request $request)
    {   
        request()->validate([
            'record_id' => 'required|integer',  
            'status' => 'required|integer', 
        ]);

        $find_dt = Product::find($request->record_id);
        Product::where('id',$request->record_id)->update(array('status'=>$request->status));
        
        return response()->json(['status'=>1,'message'=>'Sub Category status updated.']); 
    } 
    
    public function call_data(Request $request)
    { 
        $get_data = Product::orderBy('status','desc')->orderBy('product_name','asc')->get();
        
        return Datatables::of($get_data)
            ->addIndexColumn()
            ->editColumn("product_name",function($get_data){
                return (@$get_data->product_name) ? @$get_data->product_name : "";
            })
            ->editColumn("category_id",function($get_data){
                return ucwords($get_data->category_detail->category_name);
            })
            ->editColumn("media_url",function($get_data){
               if($get_data->media_url){
                    return '<a href="'.url('uploads/'.$get_data->media_url).'" target="_blank" >
                                <img src="'.url('uploads/'.$get_data->media_url).'" style="width: 47px; margin-left:3px;" />
                            </a>';
                }else{
                    return "";
                }
               
            })
            ->editColumn("status",function($get_data){

                   if($get_data->status=='1'){
                        return '<label class="switch switch-small">
                            <input type="checkbox" checked value="1" class="call_assign common_status_update ch_input"
                             title="Approve" data-id="'.$get_data->id.'" data-action="product"  />
                            <span></span>
                        </label>';
                    }else{
                        return '<label class="switch switch-small">
                            <input type="checkbox" value="0" class="call_assign common_status_update ch_input"
                             title="Reject" data-id="'.$get_data->id.'" data-action="product"  />
                            <span></span>
                        </label>';
                    }
            })
            ->editColumn("total_episode",function($get_data){
                $episode_count = SubProduct::where('product_id',$get_data->id)->count();
                if($episode_count>0){
                    return '<a class="btn btn-warning btn-rounded btn-condensed btn-sm" href="'.url('view_sub_product').'/'.$get_data->id.'"><i class="fa fa-eye"></i> View '.$episode_count.' </a>';
                }else{
                    return '<a class="btn btn-warning btn-rounded btn-condensed btn-sm" href="'.route('sub_product.create').'"><i class="fa fa-plus"></i> Add </a>';
                }
            })
            ->editColumn("created_at",function($get_data){
                return date("Y-m-d", strtotime(@$get_data->created_at));
            })
            ->editColumn("action",function($get_data){

                $cr_form = '<form id="form_del_'.$get_data->id.'" action="'.route('product.destroy',$get_data->id).'" method="POST">
                            <input type="hidden" name="_token" value="'.csrf_token().'" />';
 
                            $cr_form .= '<a class="btn btn-info btn-rounded btn-condensed btn-sm s_btn1 " href="'.route('product.show',$get_data->id).'" ><i class="fa fa-eye"></i></a>';

              
                if(Auth::user()->can('product-edit')){

                    $cr_form .= '<a class="btn btn-default btn-rounded btn-condensed btn-sm" href="'.route('product.edit',$get_data->id).'"><i class="fa fa-pencil"></i></a> ';
 
                }   

                $cr_form .= '<input type="hidden" name="_method" value="DELETE"> ';

                /*if(Auth::user()->can('product-delete')){
                    $cr_form .= '<button type="button" data-id="'.$get_data->id.'" class="btn btn-danger btn-rounded btn-condensed btn-sm del-confirm" ><i class="fa fa-trash"></i></button>'; 

                } */
                $cr_form .='</form>';

                return $cr_form;
            }) 
            ->rawColumns(['media_url','total_episode','status','action'])->make(true);

    }

    public function create()
    {   
        $user_id = Auth::id(); 
        $GetCategory = Category::orderBy('id','desc')->where('status','1')->get();   
         
        return view('admin.product.create',compact('GetCategory'));
    }
 
    public function store(Request $request)
    {
        request()->validate([
            'category_id' => 'required|integer',  
            'product_name' => 'required',   
            'status' => 'required|integer', 
        ]);
         
        $input = $request->all();
        
        $res_data = Product::where('product_name',$request->product_name)->first();
         

        $input['created_by'] = Auth::id();
        $input['edited_by'] = Auth::id(); 

        if($request->hasFile('media_url')){   
            $media_img_path = $request->media_url->store('media');   
            $input['media_url'] = $media_img_path;
        }
 
        $prop_data = Product::create($input);
        $property_id = $prop_data->id;
             
        return redirect()->route('product.index')->with('success','Sub Category added successfully.');
    }
   
    public function show($id)
    {   
        $get_data = Product::find($id); 
 
        return view('admin.product.show',compact('get_data'));
    }
    
    public function edit($id)
    {
        $user_id = Auth::id();
        $get_data = Product::find($id); 
        
        $GetCategory = Category::orderBy('id','desc')->get();  
        
        return view('admin.product.edit',compact('get_data','GetCategory'));
    }
   
    public function update(Request $request, $id)
    { 
        request()->validate([
            'category_id' => 'required|integer',  
            'product_name' => 'required',   
            'status' => 'required|integer',  
        ]);
          
        $input = $request->all();
        $input['edited_by'] = Auth::id(); 
        
        $res_data = Product::where('product_name', '!=' ,$request->product_name)->first();
         

        if($request->hasFile('media_url')){   
            $media_img_path = $request->media_url->store('media');   
            $input['media_url'] = $media_img_path;
        }

        $res_data = Product::find($id)->update($input);
         
        return redirect()->route('product.index')->with('success','Sub Category updated successfully');
         

    }
 
    public function destroy($id)
    {  
        $insert = Product::where('id',$id)->delete();

        return redirect()->route('product.index')->with('success','Sub Category deleted successfully');
    }
 
}