<?php

namespace App\Http\Controllers\Admin;


use App\Models\User;
use App\Models\Agent;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;


use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:role_list|role_create|role_edit', ['only' => ['index']]);
        $this->middleware('permission:role_create', ['only' => ['createRole', 'createPermission', 'role_permission']]);
        $this->middleware('permission:role_edit', ['only' => ['edit,update']]);
        $this->middleware('permission:role_delete', ['only' => ['role_delete', 'permission_delete']]);
        // $this->middleware('permission:role_pemission_edit', ['only' => ['role_edit', 'permission_edit', 'role_update', 'permission_update']]);
    }

    public function createRole(Request $request)
    {
        // toastr()->success('Your account has been suspended.');
        $request->validate([
            'name' => 'required',
        ]);
        $role = Role::create(['name' => $request->input('name')]);
        return response()->json(["message" => "Role Created Successfuly !"]);
        // return redirect()->back()->with('success','Role created successfully');
    }
    public function createPermission(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $role = Permission::create(['name' => $request->input('name')]);
        return response()->json(["message" => "Permission Created Successfuly !"]);
        // return redirect()->back()->with('success','Permission Created Successfuly !');
    }

    public function role_delete($id)
    {
        $role = Role::find($id);
        $role->delete();
        // return redirect()->back()->with('success','Role deleted successfully');
        return response()->json(["message" => "Role deleted Successfuly !"]);
    }

    public function permission_delete($id)
    {
        $role = Permission::find($id);
        $role->delete();
        // return redirect()->back()->with('success','Permission deleted Successfuly !');
        return response()->json(["message" => "Permission deleted Successfuly !"]);
    }
    public function role_edit($id)
    {
        $role = Role::find($id);

        return response()->json(['role' => $role]);
    }

    public function permission_edit($id)
    {
        $permission = Permission::find($id);

        return response()->json(['permission' => $permission]);
    }

    public function role_update(Request $request)
    {

        $request->validate([
            'role_id' => 'required',
            'name' => 'required',
        ]);

        $role = Role::find($request->input('role_id'));
        $role->name = $request->input('name');
        $role->save();
        // return redirect()->back()->with('success','Role Updated Successfuly !');
        return response()->json(["message" => "Role Updated Successfuly !"]);
    }

    public function permission_update(Request $request)
    {
        $request->validate([
            'permission_id' => 'required',
            'name' => 'required',
        ]);
        $role = Permission::find($request->input('permission_id'));
        $role->name = $request->input('name');
        $role->save();
        return response()->json(["message" => "Permission Updated Successfuly !"]);
        // return redirect()->back()->with('success','Permission Updated Successfuly !');
    }


    public function index(Request $request)
    {
        $permission = Permission::get();
        $rolePermissions = [];
        $roles = Role::orderBy('id', 'DESC')->get();

        $permissions = Permission::orderBy('id', 'DESC')->get();
        return view('role.index', compact('roles', 'permissions', 'rolePermissions', 'permission'));
    }

    public function roleList(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::orderBy('id', 'DESC')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#edit_role_name" id="edit_role" data-id="' . $row->id . '">
                                                <i class="fas fa-pen"></i>
                                            </button>';
                    // $btn .= ' <button type="button" class="btn btn-danger btn-sm" id="delete_role"
                    //                             data-id="' . $row->id . '">
                    //                             <i class="fas fa-trash"></i>
                    //                         </button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function PermissionList(Request $request)
    {
        if ($request->ajax()) {
            $data = Permission::orderBy('id', 'DESC')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#edit_permission_name" id="edit_permission_name"
                                                data-id="' . $row->id . '">
                                                <i class="fas fa-pen"></i>
                                            </button>';
                    // $btn .= ' <button type="button" class="delete btn btn-danger btn-sm" id="delete_permission"
                    //                             data-id="' . $row->id . '">
                    //                             <i class="fas fa-trash"></i>
                    //                         </button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }


    public function role_permission(Request $request)
    {
        $role_id = $request->input('role_id');
        $role = Role::find($role_id);
        if ($request->ajax()) {
            $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $role_id)
                ->pluck('role_has_permissions.permission_id')
                ->all();
            return response()->json(['rolePermissions' => $rolePermissions]);
        }
    }


    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();
        return view('pages.role.edit', compact('role', 'permission', 'rolePermissions'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'role_id' => 'required',
            'permission' => 'nullable|array', // Accepts null or array
        ]);

        $role = Role::findOrFail($request->input('role_id'));

        // Optional: update other role fields if needed
        $role->name = $role->name;
        $role->save();

        // Sync only if permission is provided
        if ($request->has('permission') && is_array($request->input('permission'))) {
            $role->permissions()->sync($request->input('permission'));
        } else {
            $role->permissions()->sync([]); // Optionally detach all if not provided
        }

        return response()->json([
            "message" => "Role-wise permissions updated successfully!"
        ]);
    }

}
