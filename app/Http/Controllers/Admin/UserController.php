<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Jobs\SendEmailJob;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // $data = User::with(['roles'=>function($q){
        //     $q->whereNotIn('name',['Student-admin','Franchise-Admin']);
        // }])->orderBy('id','DESC')->paginate(5);
        $data = User::whereHas('roles',function($q){
            $q->whereNotIn('name',['Super-Admin','Student-admin','Franchise-Admin']);
        })->orderBy('id','DESC')->paginate(5);
        //dd($data);
        return view('admin.users.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * 5);
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
        $roles = $user->getRoleNames();
        $user->removeRole($roles);
        $user->delete();


        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }
}
