<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Modules\Student\StudentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    protected $model;
    public function __construct()
    {
        $this->model = new StudentService();
    }
    public function index(Request $request){
        $data = $this->model->getStudentId(Auth::id());
        
        return view('student.profile',
            ['data' => $data]
        );
    }
    
}
