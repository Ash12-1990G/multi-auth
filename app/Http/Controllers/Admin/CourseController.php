<?php

namespace App\Http\Controllers\Admin;

use App\Models\Course;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request){
        $data = Course::search(request(['search']))->orderBy('id','DESC')->paginate(5);
      //dd($data);
        return view('admin.courses.index',compact('data'))
        ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    public function create(){
        return view('admin.courses.create');
    }
    public function show($id){
        $course = Course::find($id);
        //dd($student);
        return view('admin.courses.show',compact('course'));
    }
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'code'=> 'required|unique:courses,code',
            'slug' => 'required|unique:courses,slug',
            'description' => 'required|string',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'meta_title' => 'required|string',
            'meta_description' => 'required|string',
        ]);

        $course['name'] = $request->input('name');
        $course['code'] = $request->input('code');
        $course['slug'] = $request->input('slug');
        $course['description'] = $request->input('description');
        $course['price'] = $request->input('price');
        $course['meta_title'] = $request->input('meta_title');
        $course['meta_description'] = $request->input('meta_description');

        Course::create($course);
        return redirect()->route('courses.index')
                        ->with('success','Course created successfully');
        
    }
    public function edit($id){
        $course = Course::findOrFail($id);
        //dd($user->user->phone);
        return view('admin.courses.edit',compact('course'));
    }
    public function update(Request $request, $id){
        $this->validate($request, [
            'name' => 'required',
            'code'=> 'required|unique:courses,code,'.$id,
            'slug' => 'required|unique:courses,slug,'.$id,
            'description' => 'required|string',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'meta_title' => 'required|string',
            'meta_description' => 'required|string',
        ]);
        $course = Course::find($id);
        $course['name'] = $request->input('name');
        $course['code'] = $request->input('code');
        $course['slug'] = $request->input('slug');
        $course['description'] = $request->input('description');
        $course['price'] = $request->input('price');
        $course['meta_title'] = $request->input('meta_title');
        $course['meta_description'] = $request->input('meta_description');

        $course->update();
             return redirect()->route('courses.index')
                        ->with('success','Course updated successfully');
    }
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->syllabus()->delete();
        $course->delete();

        return redirect('/courses')->with('success', 'Course successfully deleted');
    }
}
