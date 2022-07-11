<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'franchise_id',
        'name',
        'course_code',
        'slug',
        'description',
        'price',
        'image',
        'meta_title',
        'meta_description'
    ];
    // public function scopeSearch($query, array $filters){
    //     $query->when($filters['search'] ?? false,function($query,$search){
    //         $query
    //             ->where('name','like','%'.$search.'%');
    //     });
    // }
    public function syllabus(){
        return $this->hasOne(Syllabus::class);
    }
    public function ebooks(){
        return $this->hasMany(Syllabus::class);
    }
    public function franchises(){
        return $this->belongsTo(Franchise::class,'franchise_id');
    }
    public function students(){
        return $this->belongsToMany(Student::class,'course_student')
        
        ->withPivot('id','roll_no', 'start_date','price','discount')
        ->withTimestamps();
    }
   
    public function users()
    {
        return $this->belongsToMany(User::class,'reviews','course_id','user_id')
        ->withPivot('id','user_id','course_id','rating','comment','created_at')
        ->withTimestamps();
    }
}
