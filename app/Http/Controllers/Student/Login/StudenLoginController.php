<?php

namespace App\Http\Controllers\Student\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class StudenLoginController extends Controller
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
            if(!Auth::user()->hasRole('Student-Admin')){
                Auth::logout();
                return redirect()->intended(route('student.signin'));
            }
            return redirect()->intended(route('student.dashboard'));
        }
        return redirect()->route('student.signin')->withInput($request->only('email'))->withErrors([
            'email' => [trans('auth.failed')],
        ]);
    }
    public function index(){
        return view('frontend.login.studentlogin');
    }  
}
