<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Modules\Course\CourseService;
use App\Modules\Course\Ebooks\EbookService;
use App\Modules\Student\StudentCourse\HasCourse;
use Illuminate\Http\Request;
use App\Modules\Student\StudentService;
use Illuminate\Support\Facades\Auth;

class JoinedCoursesController extends Controller
{
    protected $course;
    protected $ebook;


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
        $check = $this->course->checkStudentCourse($course);
        if($check==0){
            abort(404);
        }
        $item = new CourseService();
        $data = $item->getCoursesById($course);
        $review = Review::where('course_id',$course)->where('user_id',auth()->user()->id)->first();
        // $ebook = new EbookService();
        // $ebooks = $ebook->getBookByCourse($course);
        
        if($tab!=='description' && $tab!=='syllabus' && $tab!=='ebook' && $tab!='review'){
            abort(404);
        }
        //dd($review);
        return view('student.viewcourse',compact('data','tab','review'));
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
        
        return $this->book->ebookDownload($file);
       
        
    }
    
}
