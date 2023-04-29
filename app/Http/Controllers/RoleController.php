<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use App\Models\user;

class RoleController extends Controller
{
    public function role(){
        $permissions = permission::all();
        $roles = Role::all();
        $users = user::all();
        return view('admin.role.role',[
            'permissions'=>$permissions,
            'roles'=>$roles,
            'users'=>$users,
        ]);
    }
    public function pemission_store(Request $request){
        Permission::create(['name' => $request->permission_name]);
        return back();
    }
    public function role_store(Request $request){
        $role = Role::create(['name' => $request->role_name]);
        $role->givePermissionTo($request->permission);
        return back();
    }
    public function assign_role(Request $request){
        $user = user::find($request->user_id);
        $user->assignRole($request->role);
        return back();
    }
    public function remove_role($user_id){
        $user = User::find($user_id);
        $user->syncRoles([]);
        $user->syncPermissions([]);
        return back();
    }
    public function delete_permission($role_id){
        $role = Role::find($role_id);
        $role->syncPermissions([]);
        $role->delete();
        return back();
    }
}
