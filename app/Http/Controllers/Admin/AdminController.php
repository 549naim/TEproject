<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::orderBy('id', 'desc');

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('roles', function ($row) {
                    return $row->getRoleNames()->map(function ($role) {
                        return '<span class="badge badge-success">' . $role . '</span>';
                    })->implode(' ');
                })
                ->addColumn('action', function ($row) {
                    $btn = '<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#edit_admin_modal" id="edit_admin" data-id="' . $row->id . '">
                            <i class="fas fa-pen"></i>
                        </button>';

                    $btn .= ' <button type="button" class="btn btn-danger btn-sm" id="delete_admin" data-id="' . $row->id . '">
                            <i class="fas fa-trash"></i>
                        </button>';
                    return $btn;
                })
                ->rawColumns(['action', 'roles'])
                ->make(true);
        }

        $roles = Role::pluck('name', 'name')->all();
        return view('admin.index', compact('roles'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->except('confirm-password', 'roles');
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return response()->json([
            'success' => true,
            'message' => 'Admin created successfully!'
        ]);
    }

    public function admin_edit($id)
    {
        $admin = User::findOrFail($id);
        $roles = $admin->getRoleNames();

        return response()->json([
            'data' => $admin,
            'roles' => $roles
        ]);
    }

    public function admin_update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'roles' => 'required'
        ]);

        $admin = User::findOrFail($request->id);

        $admin->update($request->only(['name', 'email']));
        $admin->syncRoles($request->input('roles'));

        return response()->json([
            'success' => true,
            'message' => 'Admin updated successfully!'
        ]);
    }

    public function admin_delete($id)
    {
        $admin = User::findOrFail($id);
        $admin->delete();

        return response()->json([
            'success' => true,
            'message' => 'Admin deleted successfully!'
        ]);
    }
}
