<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        // dd($next($request));
      
        $guards = empty($guards) ? [null] : $guards;
        $users = Auth::user();
       
        $otherRoles = Role::whereNotIn('name', ['Franchise-Admin','Student-Admin'])->pluck('name')->toArray();
        foreach ($guards as $guard) {
            
            if (Auth::guard($guard)->check()) {
                //return redirect(RouteServiceProvider::HOME);
                // to admin dashboard
                if($users->hasAnyRole($otherRoles)) {
                   
                    return redirect(route('admin.dashboard'));
                }

                // to user dashboard
                else if($users->hasRole('Student-Admin')) {
                    return redirect(route('student.dashboard'));
                }
                else if($users->hasRole('Franchise-Admin')) {
                    return redirect(route('customer.dashboard'));
                }
            }
        }

        return $next($request);
    }
}
