<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Student;
use App\Models\StudentCourse;
use App\Modules\Student\StudentService;
use App\Modules\Course\CourseService;
use App\Modules\Student\StudentCourse\HasCourse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class StudentCourseController extends Controller
{
    public $service;
    public $cls;

    public function __construct(){
      
        $this->service = new StudentService();
        
    }

    public function index(){
       $data = $this->service->getNameId(request()->student_id);
        if(request()->ajax()){
            return self::getDatatable(request()->student_id);
        };
        
        return view('admin.students.courses.index',compact('data'));
    }
    public function getDatatable($id){
        $data = StudentCourse::with('courses:id,name')->where('student_id',$id)->get();
        //$data = Student::with('users')->orderBy('id','ASC')->get();
        
        $user = auth()->user();
        return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('course name', function($row) {
            return $row->courses->name;
        })
        ->editColumn('price', function($row){
            return '<span class="fw-bold text-danger"><i class="fas fa-rupee-sign"></i> '.$row->price.'</span>';
        })
        ->editColumn('start date', function($row){
            $start_date = Carbon::parse($row->start_date)->format('F j, Y');
            return '<span class="text-success">'.$start_date.'</span>';
        })
        ->addColumn('action', function($row) use ($user){
            $btn = '';
                // if ($user->can('student-course-show')) {
                //     $btn .= '<a class="btn btn-success btn-sm" href="'.route('students.show',$row->id).'">Show</a> ';
                // } 
                if ($user->can('student-course-edit')) {
                    $btn .= '<a class="btn btn-primary btn-sm" href="'.route('studentcourse.edit',$row->id).'"><i class="fas fa-pencil-alt"></i></a> ';
                } 
                if ($user->can('student-course-delete')) {
                    $btn .= \Form::open(['method' => 'DELETE','route' => ['studentcourse.destroy', $row->id],'style'=>'display:inline']) .
                    \Form::button('<i class="fas fa-trash"></i>', ['type' => 'submit','class'=>'btn btn-danger btn-sm']).
                    \Form::close();
                    
                } 
            return $btn;
        })
        ->rawColumns(['course name','price','start date','action'])
        ->make(true);
    }
    public function create(){
        $data = $this->service->getNameId(request()->student_id);
        return view('admin.students.courses.create',compact('data'));
    }
    public function autoSeachCourse(Request $request){
        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $course = new CourseService();
            // if($request->has('selectedid')){
            //     $selectedid = $request->has('selectedid');
            // }
            // else{
            //     $selectedid = '';
            // }
            $data = $course->getCourses($search);
        }
         
        //dd($request);
        return response()->json($data);
    }
    public function selectedCourse(Request $request){
        $data = [];
        //dd($request);
        //$data = Course::where('id',3)->first();
        if($request->has('id')){
            $id = $request->id;
            $course = new CourseService();
            $data = $course->getCourseById($id);
        }
        //dd($request);
        return response()->json($data);
    }
    public function store(Request $request){
        $student = $request->input('student_id');
        $this->validate($request, [
            'student_id' => 'required|exists:students,id',
            'course_id' => ['required_with:student_id','exists:courses,id',Rule::unique('student_has_courses')->where('student_id',$student)],
            'start_date' => ['regex:/^(\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01]))$/'],
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        ]);
        $input = $request->all();
        $input['discount'] = 0;
        $stucourse = new HasCourse();
        $val = $stucourse->storeData($input);
        return redirect()->route('studentcourses.index',$request->student_id)
                        ->with('success','Course added successfully');
    }
    public function edit($id){
        $stucourse = new HasCourse();
        $data = $stucourse->getAllById($id);
        return view('admin.students.courses.edit',compact('data'));
    }
    public function update(Request $request, $id){
        $student = $request->input('student_id');
        $this->validate($request, [
            'student_id' => 'required|exists:students,id',
            'course_id' =>  ['required_with:student_id','exists:courses,id',Rule::unique('student_has_courses')->where('student_id',$student)->whereNot('id',$id)],
            'start_date' => ['regex:/^(\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01]))$/'],
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        ]);
        
        $input = $request->all();
        $stucourse = new HasCourse();
        $val = $stucourse->updateData($input,$id);
        return redirect()->route('studentcourses.index',$request->student_id)
                        ->with('success','Course added successfully');
    }
    public function destroy($id)
    {
        $stucourse = new HasCourse();
        $val = $stucourse->deleteById($id);
        return redirect()->back()
                        ->with('success','Course deleted successfully');
    }
}
