<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Review;
use App\Modules\Course\CourseService;
use App\Modules\Course\Ebooks\EbookService;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class FranchiseCourseController extends Controller
{
        
    public function franchiseList(Request $request){
        $data = auth()->user()->customers->franchises()->paginate(5);
        return view('customer.franchise',compact('data'));
    }
    public function franchiseCourses($franchise){
        $model = new CourseService();
        $data = $model->getCoursesByFranchise($franchise);
        //dd($data);
        return view('customer.course',compact('data'));
    }
    public function courseView($course,$tab){

        $item = new CourseService();
        $data = $item->getCoursesById($course);
        $review = $data->users()->paginate(10);
        // $ebook = new EbookService();
        // $ebooks = $ebook->getBookByCourse($course);
        //dd($data->users());
        if($tab!=='description' && $tab!=='syllabus' && $tab!=='ebook' && $tab!='review'){
            abort(404);
        }
        
        return view('customer.viewcourse',compact('data','tab','review'));
    }
    public function getEbooks(Request $request){
        $ebooks = [];
        $ebook = new EbookService();
        if (request()->ajax()) {
            
            $ebooks = $ebook->getBookByCourse($request->course_id);
        }
        return response()->json($ebooks);
    }
       
    public function download($file)
    {
        
        $book = new EbookService();
        return $book->ebookDownload($file);
       
        
    }
    
}
