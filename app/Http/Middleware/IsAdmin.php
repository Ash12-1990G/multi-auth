<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
       
        if (Auth::check()) {
            if(Auth::user()->hasRole(['super-admin']))
            {
                //return redirect(route('admin.dashboard'));
                return $next($request);
            }
            else
            {
                Auth::logout();
                return redirect('/admin/login')->with('status','Access Denied! as you are not a admin');
            }
            
        }
        else{
            return redirect('/admin/login');

        }
       
        
    }
}
