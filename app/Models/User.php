<?php

namespace App\Models;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_super',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function students()
    {
        return $this->hasOne(Student::class);
    }
    public function customers()
    {
        return $this->hasOne(Customer::class);
    }
    //override sendEmailVerificationNotification to send email verification in queue
    public function sendEmailVerificationNotification()
    {
            $this->notify(new \App\Notifications\Auth\QueuedVerifyEmail);
                
    }
    
    public function scopeSearchCustomer($query, array $filters){
        
        $query->when($filters['q'] ?? false,function($query,$search){
          
            $query
            ->where('name', 'LIKE', "%$search%");
            
                // ->whereHas('customers', function ($query) use ($search) {
                //     $query->orWhere('center_code','like','%'.$search.'%');
                // });
               
                
        });
    }
    
}
