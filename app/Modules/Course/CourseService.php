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
    public function getCoursesByFranchise($id){
        return $this->model->where('franchise_id',$id)->paginate(10);
    }
    public function getCourses($search,$franchise){
        //return $this->model->select('id','name','course_code')->where('name', 'LIKE', "%$search%")->orWhere('course_code', 'LIKE', "%$search%")->get();
       
        return $this->model->select(
            DB::raw("CONCAT(courses.name,' - ',courses.course_code)  AS fullcourse,id")
        )->where('name', 'LIKE', "%$search%")->orWhere('course_code', 'LIKE', "%$search%")->whereIn('franchise_id',$franchise)->get();
    }
    public function getCoursesById($id){
        return $this->model->with('syllabus')->select('id','name','description')->find($id);
    }
    public function getCoursePriceById($id){
        return $this->model->select('id','price')->find($id);
    }
    public function getReviewByCourse($id){
        return $this->model->find($id);
    }
    
    
   
}