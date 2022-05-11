<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentCourse extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'course_id',
        'start_date',
        'price',
        'discount',
     ];
    protected $dates = ['start_date'];
    protected $table = 'student_has_courses';
    public function students()
    {
        return $this->belongsTo(Student::class,'student_id');
    }
    public function courses()
    {
        return $this->belongsTo(Course::class,'course_id');
    }
}
