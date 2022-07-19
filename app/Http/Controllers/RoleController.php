<?php
    
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use yajra\Datatables\Datatables;
use DB;
use Auth;    
class RoleController extends Controller
{
    function __construct()
    {
     
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
        $this->middleware('permission:role-create', ['only' => ['create','store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    
    public function index(Request $request)
    {  
        return view('roles.index',[]);  
    } 

    public function call_data(Request $request)
    {
        $get_data = Role::orderBy('id','desc')->get();

        return Datatables::of($get_data)
            ->addIndexColumn()
            ->editColumn("name",function($get_data){
                return $get_data->name;
            })  
            ->editColumn("created_at",function($get_data){
                return date("Y-m-d", strtotime($get_data->created_at));
            })
            ->editColumn("action",function($get_data){

                $cr_form = '<form id="form_del_'.$get_data->id.'" action="'.route('roles.destroy',$get_data->id).'" method="POST">
                            <input type="hidden" name="_token" value="'.csrf_token().'" />';
 
                            $cr_form .= '<a class="btn btn-info btn-rounded btn-condensed btn-sm s_btn1 " href="'.route('roles.show',$get_data->id).'" ><i class="fa fa-eye"></i></a>';

              
                if(Auth::user()->can('role-edit')){

                    $cr_form .= '<a class="btn btn-default btn-rounded btn-condensed btn-sm" href="'.route('roles.edit',$get_data->id).'"><i class="fa fa-pencil"></i></a> ';
 
                }    
                $cr_form .='</form>';

                return $cr_form;
             })->rawColumns(['status','action'])->make(true);

    } 

    public function create()
    {
        $permission = Permission::get();
        return view('roles.create',compact('permission'));
    }
     
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name', 
        ]);
    
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));
    
        return redirect()->route('roles.index')->with('success','Role created successfully');
    }

    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();
    
        return view('roles.show',compact('role','rolePermissions'));
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')->all();
    
        return view('roles.edit',compact('role','permission','rolePermissions'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required', 
        ]);
    
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();
    
        $role->syncPermissions($request->input('permission'));
    
        return redirect()->route('roles.index')
                        ->with('success','Role updated successfully');
    }

    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('roles.index')->with('success','Role deleted successfully');
    }
}