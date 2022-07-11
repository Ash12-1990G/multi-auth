<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{

    public function changePassword(Request $request)
    {
        
        $data_val  = User::findOrFail(Auth::id());
        //dd(Carbon::now()->toDateTimeString());
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        
        $data_val->update(['password'=> Hash::make($request->password)]);

        return redirect()->back()->with('success', 'Password has changed successfully.');
    }
}
