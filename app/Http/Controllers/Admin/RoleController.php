<?php

namespace App\Http\Controllers\Admin;


use DataTables;
use App\Models\User;
use App\Models\Agent;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;


use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:role_list|role_create|role_edit', ['only' => ['index']]);
         $this->middleware('permission:role_create', ['only' => ['createRole','createPermission','role_permission']]);
         $this->middleware('permission:role_edit', ['only' => ['edit,update']]);
         $this->middleware('permission:role_delete', ['only' => ['role_delete','permission_delete']]);
         $this->middleware('permission:role_pemission-edit', ['only' => ['role_edit','permission_edit','role_update','permission_update']]);
         $this->middleware('permission:admin_list', ['only' => ['adminList']]);
         $this->middleware('permission:admin_create', ['only' => ['adminCreate','adminStore']]);
         $this->middleware('permission:admin_edit', ['only' => ['adminEdit','adminUpdate']]);
         $this->middleware('permission:admin_delete', ['only' => ['adminDelete']]);
         $this->middleware('permission:admin_filter', ['only' => ['filter_admin_list','filter_user_list']]);
         
    }

    public function createRole(Request $request){
        // toastr()->success('Your account has been suspended.');
        $request->validate([
            'name' => 'required',
        ]);
        $role = Role::create(['name' => $request->input('name')]);
        // return response()->json(["message" =>  "Role Created Successfuly !"]);
        return redirect()->back()->with('success','Role created successfully');
    }
    public function createPermission(Request $request){
        $request->validate([
            'name' => 'required',
        ]);
        $role = Permission::create(['name' => $request->input('name')]);
        return redirect()->back()->with('success','Permission Created Successfuly !');
    }

    public function role_delete($id){
        $role = Role::find($id);
        $role->delete();
        return redirect()->back()->with('success','Role deleted successfully');
        // return response()->json(["message" =>  "Role deleted Successfuly !"]);
    }

    public function permission_delete($id){
        $role = Permission::find($id);
        $role->delete();
        return redirect()->back()->with('success','Permission deleted Successfuly !');
        // return response()->json(["message" =>  "Permission deleted Successfuly !"]);
    }
    public function role_edit($id){
        $role = Role::find($id);

        return response()->json(['role'=>$role]);
    }

    public function permission_edit($id){
        $permission = Permission::find($id);

        return response()->json(['permission'=>$permission]);

    }

    public function role_update(Request $request){

        $request->validate([
            'role_id'=>'required',
            'name' => 'required',
        ]);

        $role = Role::find($request->input('role_id'));
        $role->name = $request->input('name');
        $role->save();
        return redirect()->back()->with('success','Role Updated Successfuly !');
        // return response()->json(["message" =>  "Role Updated Successfuly !"]);
    }

    public function permission_update(Request $request){
        $request->validate([
            'permission_id'=>'required',
            'name' => 'required',
        ]);
        $role = Permission::find($request->input('permission_id'));
        $role->name = $request->input('name');
        $role->save();
        return redirect()->back()->with('success','Permission Updated Successfuly !');
    }


    public function index( Request $request)
    {
        $permission = Permission::get();
        $rolePermissions = [];
        $roles = Role::orderBy('id','DESC')->get();

        $permissions = Permission::orderBy('id','DESC')->get();
        return view('role.index',compact('roles','permissions','rolePermissions','permission'));
    }

    public function role_permission(Request $request){
        $role_id = $request->input('role_id');
        $role = Role::find($role_id);
        if ($request->ajax()) {
            $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$role_id)
            ->pluck('role_has_permissions.permission_id')
            ->all();
            return response()->json(['rolePermissions'=>$rolePermissions]);
        }

        $permission = Permission::get();
        return view('pages.role.role_permission',compact('role','permission','rolePermissions'));

    }


     public function edit($id)
     {
         $role = Role::find($id);
         $permission = Permission::get();
         $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
             ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
             ->all();
         return view('pages.role.edit',compact('role','permission','rolePermissions'));
     }

   
      public function update(Request $request, $id)
     {
        $this->validate($request, [
                    'role_id' => 'required',
                    'permission' => 'required',
                 ]);

         $role = Role::find($request->input('role_id'));
         $role->name = $role->name;
         $role->save();
         $role->permissions()->sync($request->input('permission'));
         return redirect()->back()
                         ->with('success','Role updated successfully');
     }


}
