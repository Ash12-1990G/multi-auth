<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use DB;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;


class RoleController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
         $this->middleware('permission:role-create', ['only' => ['create','store']]);
         $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    public function index()
    {   
        
        if(request()->ajax()){
            return self::getRoles();
        }
            return view('admin.roles.index');
    }
    public function getRoles(){
        $roles = Role::orderBy('id','DESC')->withCount('users')->get();
        $user = Auth::user();
        return DataTables::of($roles)
        ->addIndexColumn()
        ->addColumn('action', function($role) use ($user){
            $btn = '';
            if($role->name !== 'super-admin' && $role->name !== 'Franchise-Admin' && $role->name !== 'Student-Admin'){
                if ($user->can('role-show')) {
                    $btn .= '<a class="btn btn-success btn-sm" href="'.route('roles.show',$role->id).'">Show</a> ';
                } 
                if ($user->can('role-edit')) {
                    $btn .= '<a class="btn btn-primary btn-sm" href="'.route('roles.edit',$role->id).'"><i class="fas fa-pencil-alt"></i></a> ';
                } 
                if ($user->can('role-delete') && $role->users_count==0) {
                    $btn .= \Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) .
                    \Form::button('<i class="fas fa-trash"></i>', ['type' => 'submit','class'=>'btn btn-danger btn-sm']).
                    \Form::close();
                    
                } 
            }
            return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }
    
    
    public function create()
    {
        $permission = Permission::where('id','>',10)->orderBy('name')->get();
        return view('admin.roles.create',compact('permission'));
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);
    
        $role = new Role(['name' => $request->input('name')]);
        $role->save();
        $role->syncPermissions($request->input('permission'));
    
        return redirect()->route('roles.index')
                        ->with('success','Role created successfully');
    }
   
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();
    
        return view('admin.roles.show',compact('role','rolePermissions'));
    }
    
    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
        
        return view('admin.roles.edit',compact('role','permission','rolePermissions'));
    }
  
    public function update(Request $request, $id)
    {
        
        $this->validate($request, [
            'name' => 'required|unique:roles,name,'.$id,
            'permission' => 'required',
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
        
            Role::find($id)->delete();
        
            return redirect()->route('roles.index')
            ->with('success', 'Role deleted successfully');
       
        
    }

}
