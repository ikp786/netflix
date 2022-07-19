<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Models\Page;
use Auth;

use yajra\Datatables\Datatables;

class PageController extends Controller
{  
    function __construct()
    { 
        /*$this->middleware('permission:page-list|page-create|page-edit|page-delete', ['only' => ['index','show']]);
        $this->middleware('permission:page-create', ['only' => ['create','store']]);
        $this->middleware('permission:page-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:page-delete', ['only' => ['destroy']]);  */ 
    }
     
    public function index()
    {    
        return view('admin.page.index',[]);    
    }
     
    public function call_data(Request $request)
    {
        $get_data = Page::orderBy('page_name','asc')->get();
    
        return Datatables::of($get_data)
            ->addIndexColumn()
            ->editColumn("page_name",function($get_data){
                return $get_data->page_name;
            }) 
            ->editColumn("page_content",function($get_data){
                return $get_data->page_content;
            })
            ->editColumn("created_at",function($get_data){
                return date("Y-m-d", strtotime($get_data->created_at));
            })
            ->editColumn("action",function($get_data){
                
                $cr_form = '';
                
                /*$cr_form = '<a class="btn btn-info btn-rounded btn-condensed btn-sm s_btn1 " href="'.route('page.show',$get_data->id).'" ><i class="fa fa-eye"></i></a>';*/

                $cr_form .= '<a class="btn btn-default btn-rounded btn-condensed btn-sm" href="'.route('page.edit',$get_data->id).'"><i class="fa fa-pencil"></i></a>';  

                return $cr_form;
            })->rawColumns(['page_content','action'])->make(true);

    }

    public function create()
    {    
        return view('admin.page.create',[]);   
    }
 
    public function store(Request $request)
    {
        request()->validate([  
            'page_name' => 'required',  
            'page_content' => 'required',   
        ]);
         
        $input = $request->all();
       
        $page_data = Page::create($input);
        $page_id = $page_data->id;
       
        return redirect()->route('page.index')->with('success','Page created successfully.');
    }
   
    public function show($id)
    {   
        $get_data = Page::find($id);  

        return view('admin.page.show',compact('get_data'));
    }
    
    public function edit($id)
    {
        $user_id = Auth::id();
        $get_data = Page::find($id);  

        return view('admin.page.edit',compact('get_data'));
    }
   
    public function update(Request $request, $id)
    { 
        request()->validate([
            'page_name' => 'required',  
            'page_content' => 'required',    
        ]);
          
        $input = $request->all(); 
          
        $res_data = Page::find($id)->update($input);

        return redirect()->route('page.index')->with('success','Page updated successfully');
    }
  
}