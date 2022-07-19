<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Auth;

use App\Models\Category;
use App\Models\Specialist; 
use App\Models\SubscribedPlan; 
use App\Models\Country; 
use yajra\Datatables\Datatables;  
use Str;

class UserController extends Controller
{ 
    public function index(Request $request,$type="")
    { 
        $get_role = DB::table('roles')->orderBy('name','asc')->where('id','!=','1')->get(['id','name']); 
        $get_rej_message = '';
 
        return view('users.index',compact('get_rej_message','get_role','type'));       
    }
    
    public function subscripted_user_list()
    { 
        $type="";
        $record_type="subscribed";
        $get_role = DB::table('roles')->orderBy('name','asc')->where('id','!=','1')->get(['id','name']); 
        $get_rej_message = '';
 
        return view('users.index',compact('get_rej_message','get_role','type','record_type'));       
    }

    public function status_update(Request $request)
    {   
        request()->validate([
            'record_id' => 'required|integer',  
            'status' => 'required|integer', 
        ]);
 
        User::where('id',$request->record_id)->update(array('status'=>$request->status));
        
        return response()->json(['status'=>1,'message'=>'User status updated.']); 
    } 
  
    public function call_data(Request $request)
    {  
        if(@$record_type=="subscribed"){
            $get_data = SubscribedPlan::leftjoin('users','users.id','=','subscribed_plans.user_id')->orderBy('users.id','desc')->get(['users.*']);
        }else{
            if($request->role_id){
                $get_data = User::orderBy('status','desc')->where('role_id','!=','1')->where('role_id',$request->role_id)->get();
            }else{
                $get_data = User::orderBy('status','desc')->where('role_id','!=','1')->get();
            } 
        }
            
        return Datatables::of($get_data)
            ->addIndexColumn()
            ->editColumn("name",function($get_data){
                return $get_data->name;                                                                  
            }) 
            ->editColumn("role",function($get_data){
               return $get_data->getRoleNames()->name;
               
            }) 
            ->editColumn("subscription_status_mn",function($get_data){
               $userSubscription = SubscribedPlan::where('user_id',$get_data->id)->orderBy('id','desc')->limit(1)->first(['status']);

                $subscription_status = "";
                if(@$userSubscription->status=='1')
                    $subscription_status = '<label class="btn btn-xs btn-primary">Active</label>';
                else if(@$userSubscription->status=='2')
                    $subscription_status = '<label class="btn btn-xs btn-warning">Cancelled</label>'; 
                else if(@$userSubscription->status=='3')
                    $subscription_status = '<label class="btn btn-xs btn-primary">Upgrated</label>';  
                else if(@$userSubscription->status=='4')
                    $subscription_status = '<label class="btn btn-xs btn-danger">Expired</label>';
                else
                    $subscription_status = '<label class="btn btn-xs btn-warning">InActive</label>'; 

                return $subscription_status;
               
            })
            ->editColumn("status",function($get_data){
               if(@$get_data->status=='1'){
                    return '<label class="switch switch-small">
                        <input type="checkbox" checked value="1" class="common_status_update ch_input"
                         title="Unblock" data-id="'.$get_data->id.'" data-action="user"  />
                        <span></span>
                    </label>';
                }else{
                    return '<label class="switch switch-small">
                        <input type="checkbox" value="0" class="common_status_update ch_input"
                         title="Block" data-id="'.$get_data->id.'" data-action="user"  />
                        <span></span>
                    </label>';
                }
               
            })
            ->editColumn("created_at",function($get_data){
                return date("Y-m-d", strtotime($get_data->created_at));
            })
            ->editColumn("action",function($get_data){

                $userSubscription = SubscribedPlan::where('user_id',$get_data->id)->count();

                $cr_form = '<form id="form_del_'.$get_data->id.'" action="'.route('users.destroy',$get_data->id).'" method="POST">
                            <input type="hidden" name="_token" value="'.csrf_token().'" />';
 
               $cr_form .= '<a class="btn btn-info btn-rounded btn-condensed btn-sm s_btn1 " href="'.route('users.show',$get_data->id).'" title="User Detail"><i class="fa fa-eye"></i></a>';
                        
                if(Auth::user()->can('user-edit')){

                    $cr_form .= '<a class="btn btn-default btn-rounded btn-condensed btn-sm" href="'.route('users.edit',$get_data->id).'"><i class="fa fa-pencil"></i></a> ';
 
                }  
                if($userSubscription>0){    
                    $cr_form .= '<a class="btn btn-warning btn-rounded btn-condensed btn-sm s_btn1 "
                     href="'.url('subscribed_plan').'/'.$get_data->id.'" title="Subscribed Plans" ><i class="fa fa-eye"></i></a>';
                }

                $cr_form .= '<input type="hidden" name="_method" value="DELETE"> ';

                if(Auth::user()->can('user-delete')){
                    /*$cr_form .= '<button type="button" data-id="'.$get_data->id.'" class="btn btn-danger btn-rounded btn-condensed btn-sm del-confirm" ><i class="fa fa-trash"></i></button>'; */

                } 
                $cr_form .='</form>';

                return $cr_form;
             })->rawColumns(['subscription_status_mn','status','action'])->make(true);

    } 

    public function create()
    {
        $roles = Role::where('id','!=','1')->pluck('name','id')->all();

        $get_country = Country::orderBy('countries_name','asc')->get(['countries_id','countries_name']);

        return view('users.create',compact('roles','get_country'));
    }
    
    public function store(Request $request)                                     
    {   
        $this->validate($request, [
            'name' => 'required', 
            'phone' => 'required|unique:users,phone',
            'email' => 'required|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);
        
        $input = $request->all(); 
        
        
        if($request->hasFile('profile_photo_path')){   
            $profile_photo_img_path = $request->profile_photo_path->store('profile_photo_path'); 
            $input['profile_photo_path'] = $profile_photo_img_path;
        } 
 
        $input['email'] = $input['email']; 

        $input['verify_code'] = '';
        $input['email_verified_at'] = date("Y-m-d h:m:s",strtotime("now"));
        $input['phone_verified_at'] = date("Y-m-d h:m:s",strtotime("now"));

        $input['password'] = Hash::make($input['password']);
        $input['role_id'] = $input['roles'][0];
           
        $user = User::create($input);

        $user_id = $user->id;
        $user->assignRole($request->input('roles'));
         
        return redirect()->route('users.index')->with('success','User created successfully');
    }
     
    public function show($id)
    { 
        $user = User::find($id);

        $get_country = Country::orderBy('countries_name','asc')->where('countries_id',@$user->country)->first(['countries_id','countries_name']);

        $userSubscription = SubscribedPlan::where('user_id',$id)->orderBy('id','desc')->limit(1)->first(['status']);

        $subscription_status = "";
        if(@$userSubscription->status=='1')
            $subscription_status = '<label class="btn btn-xs btn-primary">Active</label>';
        else if(@$userSubscription->status=='2')
            $subscription_status = '<label class="btn btn-xs btn-warning">Cancelled</label>'; 
        else if(@$userSubscription->status=='3')
            $subscription_status = '<label class="btn btn-xs btn-primary">Upgrated</label>';  
        else if(@$userSubscription->status=='4')
            $subscription_status = '<label class="btn btn-xs btn-danger">Expired</label>';
 
        $page_title = 'user';

        return view('users.show_patient',compact('user','page_title','subscription_status','get_country'));
        
    }
     
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','id')->all();      
        $userRole = $user->getUserRole()->pluck('name','id')->all();
        $get_country = Country::orderBy('countries_name','asc')->get(['countries_id','countries_name']);
        $page_title = 'user';
 
        return view('users.edit_patient',compact('user','roles','userRole','page_title','get_country')); 
    }

    public function profile_show()
    {
        $id = Auth::id();
        $user = User::find($id); 
        $page_title = "profile";
        return view('users.show',compact('user','page_title'));
 
    }
     
    public function profile_edit()
    {
        $id = Auth::id();

        $user = User::find($id);
        $roles = Role::pluck('name','id')->all();      
        $userRole = $user->getUserRole()->pluck('name','id')->all();
        
        $page_title = "profile"; 
 
        return view('users.edit_patient',compact('user','roles','userRole','page_title'));

    }
    
    public function setting_edit()
    {
        $id = Auth::id();

        $user = User::find($id);
        $roles = Role::pluck('name','id')->all();      
        $userRole = $user->getUserRole()->pluck('name','id')->all();
        
        $page_title = "setting"; 
 
        return view('users.edit_setting',compact('user','roles','userRole','page_title'));

    }

    public function update(Request $request, $id)
    { 
        $this->validate($request, [
            'name' => 'required', 
            'phone' => 'required|unique:users,phone,'.$id,
            'password' => 'same:confirm-password' 
        ]); 
 
        $input = $request->all();

        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }
        
        $page_title = ($request->page_title) ?  $request->page_title  : 'user';

        $user = User::find($id);

        $input['verify_code'] = '';
        $input['email_verified_at'] = date("Y-m-d h:m:s",strtotime("now"));
        $input['phone_verified_at'] = date("Y-m-d h:m:s",strtotime("now"));

        if($request->hasFile('profile_photo_path')){   
            $profile_photo_img_path = $request->profile_photo_path->store('profile_photo_path'); 
            $input['profile_photo_path'] = $profile_photo_img_path;
        } 

        $user->update($input);
        
        if($page_title=='profile'){
            $user_id = Auth::id();
            return redirect()->route('users.show',$user_id)->with('success','Profile updated successfully');
        }else{
            return redirect()->route('users.index')->with('success','User updated successfully');
        } 
    }
   
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')->with('success','User deleted successfully');
    }
 
    public function logout(Request $request){
        Auth::logout();
        return redirect('/login');
    }

    public function fr_logout(Request $request){
        Auth::logout();
        return redirect('/');
    }
}