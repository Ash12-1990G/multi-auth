<?php
namespace App\Modules\Student\StudentCourse;

use App\Models\Customer;
use App\Models\Student;
use App\Models\StudentCourse;
use App\Modules\Student\StudentService;

class HasCourse
{

    public $service;

    public function __construct()
    {
        $this->service = new StudentCourse;
    }
    public function getCourse($id){
        return $this->service->find($id);
    }
    public function storeData($data){
        return $this->service->create($data);
    }
    public function updateData($data,$id){
        $serviceCls = $this->service->find($id);
        
        return $serviceCls->update($data);
    }
    public function deleteByCustomer($id){
        $customerid = auth()->user()->customers->id;
        return $this->service->with(['students'=> function($q) use ($customerid){
            $q->where('customer_id',$customerid);
        }])->find($id);
    }
    public function getCenter($studentid){
        $model = new StudentService();
        return $model->getNameId($studentid);
        // return $this->service->with(['students'=>function($q){
        //     $q->with('users:id,name,email')->first();
        // }])->where('student_id',$studentid)->get()->unique('customer_id');
    }

    public function getAllById($id){
        if(auth()->user()->hasRole('Franchise-Admin')){
            $customerid = auth()->user()->customers->id;
            return $this->service->with(['students'=>function($q){
                $q->with(['customers'=>function($q){
                    $q->with('users:id,name');
                }]);
                
            }])->whereHas('students',function($q) use ($customerid){
                $q->where('customer_id',$customerid);    
            })->with('courses:id,name')->find($id);
        }
        return $this->service->with(['students'=>function($q){
            $q->with(['customers'=>function($q){
                $q->with('users:id,name');
            }]);
            
        }])->with('courses:id,name')->find($id);
    }
    public function deleteById($id){
        $query = $this->service->findOrFail($id);
       return $query->delete();
    }
    public function getCourseById($id){
        return $this->service->with('courses:id,name')->where('student_id',$id)->get();
    }
    public function getCourseInfo($studentid){
        return $this->service->with('courses')->where('student_id',$studentid)->paginate(6);
    }
    public function getStudentCourse($studentid){
        return $this->service->where('student_id',$studentid)->count();
    }
    public function hasCourseByAnyStudent($id){
        return $this->service->where('course_id',$id)->count();
    }
    public function checkStudentCourse($course){
        return $this->service->where('student_id',auth()->user()->students->id)->where('course_id',$course)->count();
    }
}