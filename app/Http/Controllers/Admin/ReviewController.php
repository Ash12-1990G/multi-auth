<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\Course\CourseService;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:review-show', ['only' => ['index']]);
    }
    public function index(Request $request){
       
        $course = $request->course;
        $service = new CourseService();
        $data = $service->getReviewByCourse($course);
        $reviews = $data->users()->with('students:id,user_id,image')->paginate(10);
//dd($reviews);
        return view('admin.reviews.index',compact('data','reviews'))->with('i', ($request->input('page', 1) - 1) * 5);
    }
}
