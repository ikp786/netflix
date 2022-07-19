<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Models\ContactDetail;
use Auth;
use yajra\Datatables\Datatables;

class ContactDetailController extends Controller
{  
    function __construct()
    { 
        $this->middleware('permission:contact_us-list|contact_us-create|contact_us-edit|contact_us-delete', ['only' => ['index','show']]);
        $this->middleware('permission:contact_us-create', ['only' => ['create','store']]);
        $this->middleware('permission:contact_us-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:contact_us-delete', ['only' => ['destroy']]);
    }
     
    public function index()
    {
        $get_data = ContactDetail::latest()->paginate(5);
        return view('admin.contact_us.index',compact('get_data'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
     
    public function create()
    {
        
    }
 
    public function store(Request $request)
    {
        
    }
    
    public function status_update(Request $request)
    {   
        request()->validate([
            'record_id' => 'required|integer',  
            'status' => 'required|integer', 
        ]);

        ContactDetail::where('id',$request->record_id)->update(array('status'=>$request->status));
        
        return response()->json(['status'=>1,'message'=>'Enquiry status updated.']); 
    } 

    public function support_reply_submit(Request $request)
    {
         request()->validate([
            'support_id' => 'required|integer',  
            'support_reply' => 'required', 
        ]);

        ContactDetail::where('id',$request->support_id)->update(array('support_reply'=>$request->support_reply));
     
        return response()->json(['statusCode'=>1,'message'=>'Reply submitted.']); 
    }

    public function call_data(Request $request)
    {  
        $get_data = ContactDetail::orderBy('created_at','asc')->get();

 
        return Datatables::of($get_data)
            ->addIndexColumn()
            ->editColumn("user_name",function($get_data){ 
                return (isset($get_data->user_name)) ? $get_data->user_name : "";
            })
            ->editColumn("email",function($get_data){ 
                return (isset($get_data->email)) ? $get_data->email : "";
            })
            ->editColumn("mobile",function($get_data){ 
                return (isset($get_data->mobile)) ? $get_data->mobile : "";
            })
            ->editColumn("enquiry",function($get_data){ 
                return (isset($get_data->enquiry)) ? $get_data->enquiry : "";
            })
            ->editColumn("status",function($get_data){  
                if($get_data->status=='1')
                    $subscription_status = '<label class="btn btn-xs btn-primary">Resolved</label>'; 
                else
                    $subscription_status = '<label class="btn btn-xs btn-primary">Pending</label>';

                return $subscription_status;
            })
            ->editColumn("created_at",function($get_data){
                return date("Y-m-d", strtotime($get_data->created_at));
            })
            ->editColumn("action",function($get_data){

                $cr_form = '<form id="form_del_'.$get_data->id.'" action="'.route('contact_us.destroy',$get_data->id).'" method="POST">
                            <input type="hidden" name="_token" value="'.csrf_token().'" />';
 
                            $cr_form .= '<a class="btn btn-info btn-rounded btn-condensed btn-sm s_btn1 " href="'.route('contact_us.show',$get_data->id).'" ><i class="fa fa-eye"></i></a>';
 

                $cr_form .= '<input type="hidden" name="_method" value="DELETE"> ';

                if(Auth::user()->can('contact_us-delete')){
                    $cr_form .= '<button type="button" data-id="'.$get_data->id.'" class="btn btn-danger btn-rounded btn-condensed btn-sm del-confirm" ><i class="fa fa-trash"></i></button>'; 

                } 
                $cr_form .='</form>';

                return $cr_form;
            }) 
            ->rawColumns(['status','action'])->make(true);

    }

    public function show($id)
    {
        $get_data = ContactDetail::find($id); 
        return view('admin.contact_us.show',compact('get_data'));
    }
    
    public function edit(ContactDetail $get_data)
    {
       
    }
   
    public function update(Request $request, $id)
    {
        
    }
  
    public function destroy($id)
    {  
        $insert = ContactDetail::where('id',$id)->delete();

        return redirect()->route('contact_us.index')->with('success','Contact deleted successfully');
    }
}