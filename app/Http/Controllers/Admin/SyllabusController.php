<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Syllabus;
use Illuminate\Http\Request;

class SyllabusController extends Controller
{
    public function show($course_id){
        $syllabus =  Syllabus::where('course_id',$course_id)->first();
        $courses =  Course::find($course_id);
        
        return view('admin.syllabus.show',compact('syllabus','courses'));
    }
    public function create($course_id){
        $course = Course::find($course_id);
        return view('admin.syllabus.create',compact('course'));
    }
    public function store(Request $request){
        
        $this->validate($request, [
            'course_id' => 'required|exists:courses,id',
            'description'=> 'required',
        ]);
        $input = $request->all();
        Syllabus::create($input);
        return redirect()->route('syllabus.show',$request->input('course_id'))
                        ->with('success','Syllabus created successfully');
    }
    public function edit($id){
        $syllabus = Syllabus::with('courses')->findOrFail($id);
        return view('admin.syllabus.edit',compact('syllabus'));
    }
    public function update(Request $request,$id){
        
        $this->validate($request, [
            'description'=> 'required',
        ]);
        $syllabus = Syllabus::find($id);
        $syllabus->description = $request->input('description');
        
        return redirect()->route('syllabus.show',$syllabus->course_id)
                        ->with('success','Syllabus updated successfully');
    }
}
