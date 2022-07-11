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
       
        return $this->model->with(['customers'=>function($q){
            $q->with('users:id,name,email');
        }])->with('users:id,name')->findOrFail($id);
    }
    public function getTotalStudentByCenter($id){
        return $this->model->where('customer_id',$id)->count();
    }
    public function sumStudentAmount($id){
        return $this->model->withSum('courses as total','course_student.price')->where('customer_id',$id)->get();
    }
    public function sumStudentDue($id){
        return $this->model->withSum('courses as totaldue','course_student.due')->where('customer_id',$id)->get();
    }
    public function getStudentByCenter($id){
       $customerid = auth()->user()->customers->id;
        return $this->model->with(['customers'=>function($q) use ($customerid){
            $q->with('users:id,name,email');
        }])->with('users:id,name')->where('customer_id',$customerid)->findOrFail($id);
    }
    public function getNameIdWithCustomer($id){
        return $this->model->with(['customers'=>function($q){
            $q->with('users:id,name,email');
        }])->with('users:id,name')->where('customer_id',auth()->user()->customers->id)->findOrFail($id);
    }
   
    public function getStudentId($id){
       
        return $this->model->with(['customers'=>function($q){
            $q->with('users:id,name,email');
        }])->where('user_id',$id)->first();
    }
    public function getStudentCourses($student_id,$customer_id){
        return $this->model->where('customer_id',$customer_id)->find($student_id);
    }
    public function CheckMail($id,$email){
        $res = $this->model->with(['customers'=>function($q){
            $q->with('users:id,name,email');
        }])->findOrFail($id);
        if($res->customers->users->email==$email){
            return true;
        }
        return false;
    }
}