<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPayment extends Model
{
    use HasFactory;
    protected $table = 'student_payments';
    protected $fillable = [
        'course_student_id',
        'paid',
        'p_date',
        'remarks',
    ];
    
    public function courseStudents()
    {
        return $this->belongsTo(StudentCourse::class,'course_student_id');
    }
}
