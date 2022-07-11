<?php

namespace App\Models;

use App\Modules\Student\StudentCourse\HasCourse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'customer_id',
        'center_code',
        'cust_name',
        'phone',
        'alt_phone',
        'address',
        'city',
        'state',
        'pincode',
        'location',
        'latitude',
        'longitude',
    ];

    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function franchises()
    {
        return $this->belongsToMany(Franchise::class,'customer_franchise')
        
        ->withPivot('id','amount','discount','due','payment_option','payment_status','service_taken','service_ends','remarks')
        ->withTimestamps();
    }
    public function customerPayments()
    {
        return $this->hasMany(CustomerPayment::class,'customer_id');
    }
    public function scopeSearch($query, array $filters){
        $query->when($filters['search'] ?? false,function($query,$search){
            $query
                ->where('phone','like','%'.$search.'%')
                ->orWhereHas('users', function ($query) use ($search) {
                    $query->where('name', 'like', '%'.$search.'%')
                        ->orWhere('email','like','%'.$search.'%');
                });
        });
    }
}
