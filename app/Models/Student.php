<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'customer_id',
        'admission',
        'phone',
        'birth',
        'gender',
        'alt_phone',
        'father_name',
        'mother_name',
        'education',
        'id_type',
        'id_number',
        'image',
        'address1',
        'city1',
        'state1',
        'pincode1',
        'address2',
        'city2',
        'state2',
        'pincode2',
        'status',
    ];
    protected $dates = ['birth','admission'];
    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function customers()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }
    public function courses(){
        return $this->belongsToMany(Course::class,'course_student')
        
        ->withPivot('id','roll_no', 'start_date','price','discount')
        ->withTimestamps();
    }
    
    
  
    // public function studentCourses()
    // {
    //     return $this->hasMany(StudentCourse::class);
    // }
    
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
