<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Jobs\SendEmailJob;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:user-list', ['only' => ['index','getUsers']]);
        $this->middleware('permission:user-show', ['only' => ['show']]);
        $this->middleware('permission:user-add', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
                
        if(request()->ajax()){
            return self::getUsers();
        }
        return view('admin.users.index');
    }
    public function getUsers(){
        $data = User::whereHas('roles',function($q){
            $q->whereNotIn('name',['Super-Admin','Student-admin','Franchise-Admin']);
        })->orderBy('id','DESC')->get();
        
        $user = auth()->user();
        return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('roles', function($row){
            $btn = '';
            if(!empty($row->getRoleNames())){
                foreach($row->getRoleNames() as $val){
                    $btn .= '<h4 class="badge badge-dark font-weight-normal">'.$val.'</h4>';
                }
            }
            return $btn;
        })
        ->addColumn('action', function($row) use ($user){
            $btn = '';
                // if ($user->can('role-show')) {
                //     $btn .= '<a class="btn btn-success btn-sm" href="'.route('roles.show',$role->id).'">Show</a> ';
                // } 
                if ($user->can('user-edit')) {
                    $btn .= '<a class="btn btn-primary btn-sm" href="'.route('users.edit',$row->id).'"><i class="fas fa-pencil-alt"></i></a> ';
                } 
                if ($user->can('user-delete')) {
                    $btn .= \Form::open(['method' => 'DELETE','route' => ['users.destroy', $row->id],'style'=>'display:inline']) .
                    \Form::button('<i class="fas fa-trash"></i>', ['type' => 'submit','class'=>'btn btn-danger btn-sm']).
                    \Form::close();
                    
                } 
            return $btn;
        })
        ->rawColumns(['roles','action'])
        ->make(true);
    }
    public function create()
    {
        $roles = Role::whereNotIn('name', ['super-admin','Student-admin','Franchise-Admin'])->get();
        return view('admin.users.create',compact('roles'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'roles'    => 'required|array|min:1',
            'roles.*'  => 'required|distinct|exists:roles,id'
        ]);
//'password' => 'required|same:confirm-password',
        $input = $request->all();
        $random = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!$%^&!$%^&');
        $password = substr($random, 0, 10);
        $input['password'] = Hash::make($password);
        $mailData = [
            'name' => $input['name'],
            'type' => 'user',
            'email' => $input['email'],
            'password' => $password
        ];
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
        //dispatching job for mailing
        dispatch(new SendEmailJob($mailData));
        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }
    // public function show($id)
    // {
    //     $user = User::find($id);
    //     return view('admin.users.show',compact('user'));
    // }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::whereNotIn('name', ['super-admin','Student-admin','Franchise-Admin'])->get();
        
        $userRole = $user->roles->pluck('id','name')->all();

        return view('admin.users.edit',compact('user','roles','userRole'));
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'roles'    => 'required|array|min:1',
            'roles.*'  => 'required|distinct|exists:roles,id'
        ]);

        $input = $request->all();
        $user = User::find($id);
        $user->update($input);
        $user->syncRoles($request->get('roles'));
        
        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }
    
    public function destroy($id)
    {

        $user = User::findOrFail($id);
        // $roles = $user->getRoleNames();
        // $user->removeRole($roles);
        $user->delete();


        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }
}
