<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
 
    public function redirectTo()
    {
        $userrole = Auth::user()->getRoleNames();
        $user = explode(',', $userrole);
       
        if(in_array('super-admin',$user)){
            return $this->redirectTo = '/admin/dashboard';
        }
        else if(in_array('Student-Admin',$user)){
            Auth::logout();
            return $this->redirectTo = '/student/login';
        }
        else if(in_array('Franchise-Admin',$user)){
            Auth::logout();
            return $this->redirectTo = '/customer/login';
        }
        else{
            return $this->redirectTo = '/admin/dashboard';
        }
        
    }
   
}
