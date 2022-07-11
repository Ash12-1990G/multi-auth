<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Franchise;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(){
        
       $users = User::whereHas('roles',function($q){
        $q->whereNotIn('name', ['Franchise-Admin','Student-Admin','super-admin']);
       })->count();
       $students =  User::role('Student-Admin')->count();
       $customers =  User::role('Franchise-Admin')->count();
       $franchise =  Franchise::count();
        return view('admin.dashboard',compact('students','customers','franchise','users'));
    }
    public function passwordChangeView(){
       
        return view('auth.passwords.changepassword');
    }
}
