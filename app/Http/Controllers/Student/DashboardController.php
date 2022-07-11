<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Modules\Student\StudentCourse\HasCourse;
use App\Modules\Student\StudentService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        $courses_in_total=0;
        
        $student = new StudentService();
        $data = $student->getStudentId(Auth::id());
        if($data->count()){
            $model = new HasCourse();
            $courses_in_total = $model->getStudentCourse($data->id);
        }
        
        return view('student.dashboard',compact('courses_in_total'));
    }
}
