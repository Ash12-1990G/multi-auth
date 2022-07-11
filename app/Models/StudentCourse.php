<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class StudentCourse extends Pivot
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'roll_no',
        'course_id',
        'start_date',
        'price',
        'discount',
        'due',
        'concession',
        'payment_option',
        'payment_status'
     ];
     public $incrementing = true;
    protected $dates = ['start_date'];
    protected $table = 'course_student';
    public function courses(){
        return $this->belongsTo(Course::class,'course_id');
    }
    public function students(){
        return $this->belongsTo(Student::class,'student_id');
    }
    public function studentPayments(){
        return $this->hasMany(StudentPayment::class,'id');
    }
}