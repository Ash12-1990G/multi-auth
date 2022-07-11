<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{
    use HasFactory;
    public function notifiable_reciepients()
    {
        return $this->hasMany(Notifiable_Reciepient::class);
    }
    public function availableNotice() {
        return $this->notifiable_reciepients()->where('user_id','=', auth()->user()->id)->where('delete_at','=',NULL);
    }
    public static function checkNotice($query) {
        $query->notifiable_reciepients()->where('user_id','=', auth()->user()->id)->where('delete_at','=',NULL);
    }
    public static function groupCheck($role_id,$user_id){
        $data = Notification::select('notifications.*')
        ->leftJoin('notifiable_reciepients',function ($join) use ($user_id) {
            $join->on('notifications.id', '=', 'notifiable_reciepients.notification_id')->where('notifiable_reciepients.user_id', $user_id);
        })->where('notifiable_reciepients.notification_id','=',NULL)->where('notifications.notifiable_type','Spatie\Permission\Models\Role')->where('notifications.notifiable_id',$role_id)->get();
        return $data;
    }
    public static function customerGroupNotifice($role_id,$user_id){
        $data = Notification::select('notifications.*')
        ->leftJoin('notifiable_reciepients',function ($join) use ($user_id) {
            $join->on('notifications.id', '=', 'notifiable_reciepients.notification_id')->where('notifiable_reciepients.user_id', $user_id);
        })->where('notifiable_reciepients.notification_id','=',NULL)->where('notifications.notifiable_type','Spatie\Permission\Models\Role')->where('notifications.notifiable_id',$role_id)->count();
        return $data;
    }
    public static function customerIndividualUnreadNotice($user_id){
        return Notification::where('type','App\Notifications\PostNotice')->where('notifiable_type','App\Models\User')->where('notifiable_id',$user_id)->where('read_at',NULL)->count();
    }
    public static function scopeCustomerIndividualNotice($query,$user_id){
        $query->where('type','App\Notifications\PostNotice')->where('notifiable_type','App\Models\User')->where('notifiable_id',$user_id)->count();
    }
    
    
}
