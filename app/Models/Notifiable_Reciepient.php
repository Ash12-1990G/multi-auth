<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifiable_Reciepient extends Model
{
    use HasFactory;
    protected $table = 'notifiable_reciepients';
    protected $fillable = [
        
        'notification_id',
        'user_id',
        'read_at',
        'delete_at',
        
    ];
    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function notifications()
    {
        return $this->belongsTo(Notification::class,'notification_id');
    }
}
