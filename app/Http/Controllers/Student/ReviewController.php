<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Student;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    
    public function addReview(Request $request)
    {
        $student = Student::where('user_id',auth()->user()->id)->first();
        $this->validate($request,[
            'rating' => ['required', 'in:1,2,3,4,5'],
            'comment' => 'required',
            'course_id' => 'required|exists:course_student,course_id,student_id,'.$student->id,
        ]);
        $review = new Review();
        $review->rating = $request->rating;
        $review->comment = $request->comment;   
        $review->user_id= auth()->user()->id;
        $review->course_id= $request->course_id;
        $review->save();
        return redirect()->back()->with('success', 'Your review has been added successfully!');
    }
}
