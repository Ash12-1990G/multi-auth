<?php

namespace App\Modules\Student;

use App\Models\Student;

class StudentService
{

    public $model;
    //public $modelClass = Student::class;

    public function __construct()
    {
        $this->model = new Student;
    }
    public function getNameId($id){
       
        return $this->model->with('users:id,name')->findOrFail($id);
    }
    public function getStudentId($id){
       
        return $this->model->where('user_id',$id)->first();
    }
}