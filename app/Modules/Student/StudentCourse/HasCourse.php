<?php
namespace App\Modules\Student\StudentCourse;

use App\Models\StudentCourse;

class HasCourse
{

    public $model;

    public function __construct()
    {
        $this->model = new StudentCourse;
    }
    public function storeData($data){
        return $this->model->create($data);
    }
    public function updateData($data,$id){
        $modelCls = $this->model->find($id);
        return $modelCls->update($data);
    }
    public function getAllById($id){
        return $this->model->with('courses:id,name')->find($id);
    }
    public function deleteById($id){
        $query = $this->model->findOrFail($id);
       return $query->delete();
    }
    public function getCourseById($id){
        return $this->model->with('courses:id,name')->where('student_id',$id)->get();
    }
    public function getCourseInfo($id){
        return $this->model->with('courses')->where('student_id',$id)->paginate(6);
    }
}