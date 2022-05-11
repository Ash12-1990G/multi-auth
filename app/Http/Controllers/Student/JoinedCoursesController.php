<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Modules\Course\CourseService;
use App\Modules\Course\Ebooks\EbookService;
use App\Modules\Student\StudentCourse\HasCourse;
use Illuminate\Http\Request;
use App\Modules\Student\StudentService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class JoinedCoursesController extends Controller
{
    public $course;
    public $ebook;

    public function __construct()
    {
        $this->course = new HasCourse();
        $this->ebook = new EbookService();
    }
    public function index(Request $request){
        $student = new StudentService();
        $data = $student->getStudentId(Auth::id());
        $course = $this->course->getCourseInfo($data->id); 
        // dd($course);
        return view('student.joinedcourse',compact('course'))->with('i', ($request->input('page', 1) - 1) * 5);
    }
    public function show($course,$tab){
        $item = new CourseService();
        $data = $item->getCoursesById($course);
        // $ebook = new EbookService();
        // $ebooks = $ebook->getBookByCourse($course);
        
        if($tab!=='description' && $tab!=='syllabus' && $tab!=='ebook'){
            abort(404);
        }
       // dd($data);
        return view('student.viewcourse',compact('data','tab'));
    }
    public function getEbooks(Request $request){
        $ebooks = [];
        if (request()->ajax()) {
            
            $ebooks = $this->ebook->getBookByCourse($request->course_id);
        }
        return response()->json($ebooks);
    }
    
    public function download($file)
    {
        
        $book = new EbookService();
        return $book->ebookDownload($file);
       
        
    }
    
}
