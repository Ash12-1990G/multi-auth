<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        //  dd($request->user());
        if (! $request->expectsJson()) {
            if($request->route()->getPrefix()=='/student'){
                return route('student.signin');
            }
            else if($request->route()->getPrefix()=='/customer'){
                return route('customer.signin');
            }
            
            return route('login');
        }
    }
}
