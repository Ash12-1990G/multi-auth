<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ConfirmsPasswords;
use Illuminate\Support\Facades\Auth;

class ConfirmPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Confirm Password Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password confirmations and
    | uses a simple trait to include the behavior. You're free to explore
    | this trait and override any functions that require customization.
    |
    */

    use ConfirmsPasswords;

    /**
     * Where to redirect users when the intended url fails.
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function redirectTo()
    {
        $userrole = Auth::user()->getRoleNames();
        $user = explode(',', $userrole);
        if(in_array('super-admin',$user)){
            return $this->redirectTo = '/admin/dashboard';
        }
        else if(in_array('Student-Admin',$user)){
            return $this->redirectTo = '/student/dashboard';
        }
        else if(in_array('Franchise-Admin',$user)){
            return $this->redirectTo = '/customer/dashboard';
        }
        else{
            return $this->redirectTo = '/admin/dashboard';
        }
    }
}
