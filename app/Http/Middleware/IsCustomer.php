<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsCustomer
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
            if(Auth::user()->hasRole(['Franchise-Admin']))
            {
                //return redirect(route('admin.dashboard'));
                return $next($request);
            }
            else
            {
                Auth::logout();
                return redirect()->route('customer.signin')->with('status','Access Denied! as you are not a admin');
            }
            
        }
        else{
            return redirect()->route('customer.signin');

        }
        
        
    }
}
