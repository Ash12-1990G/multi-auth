<?php
namespace App\Modules\Course;

use App\Models\Course;
use Illuminate\Support\Facades\DB;

class CourseService
{

    public $model;
    //public $modelClass = Student::class;

    public function __construct()
    {
        $this->model = new Course;
    }
    public function getCourses($search){
        //return $this->model->select('id','name','course_code')->where('name', 'LIKE', "%$search%")->orWhere('course_code', 'LIKE', "%$search%")->get();
       
        return $this->model->select(
            DB::raw("CONCAT(courses.name,' - ',courses.course_code)  AS fullcourse,id")
        )->where('name', 'LIKE', "%$search%")->orWhere('course_code', 'LIKE', "%$search%")->get();
    }
    public function getCoursesById($id){
        return $this->model->with('syllabus')->select('id','name','description')->find($id);
    }
    
    
   
}