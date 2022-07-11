<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function login(Request $request){
        
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        
        if(Auth::attempt($request->only('email', 'password'), $request->filled('remember'))){
            
            if(Auth::user()->hasRole('Franchise-Admin')){
               
                return redirect()->intended(route('customer.dashboard'));
            }
            else{
                Auth::logout();
                return redirect()->intended(route('customer.signin'));
            }
            
        }
        return redirect()->route('customer.signin')->withInput($request->only('email'))->withErrors([
            'email' => [trans('auth.failed')],
        ]);
    }
    public function index(){
        return view('frontend.login.customerlogin');
    }
}
