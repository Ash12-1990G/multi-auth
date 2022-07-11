<?php

namespace App\Providers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Spatie\Permission\Models\Role;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Paginator::useBootstrap();
        Schema::defaultStringLength(191);
        Paginator::defaultView('vendor/pagination/bootstrap-4');
        View::composer(['admin.layouts.navbar'], function ($view) {
            if(Auth::user()->hasRole(['super-admin'])){
                $view->with('notification',Auth::user()->unreadNotifications->count());
            }
            else if($user = Auth::user()->hasRole(['Franchise-Admin'])){
                $role = Role::where('name','Franchise-Admin')->first();
                 $unread = Notification::customerGroupNotifice($role->id,Auth::id());
                 $unread = $unread + Notification::customerIndividualUnreadNotice(Auth::id());
                $view->with('notification',$unread);
               // $view->with('notification',);
            }
            else if($user = Auth::user()->hasRole(['Student-Admin'])){
                $role = Role::where('name','Student-Admin')->first();
                 $unread = Notification::groupCheck($role->id,Auth::id());
                $view->with('notification',$unread->count());
            }
            
           
                
            
            
        });
    }
}
