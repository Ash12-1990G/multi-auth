<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function profile(Request $request){
        $data = auth()->user();
        //dd($data);
        return view('customer.profile',
            ['data' => $data]
        );
    }
}
