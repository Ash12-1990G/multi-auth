<?php

namespace App\Http\Controllers\Admin;

use App\Models\Course;
use App\Http\Controllers\Controller;
use App\Models\Franchise;
use App\Models\Syllabus;
use App\Modules\Student\StudentCourse\HasCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:course-list', ['only' => ['index','getDatatable']]);
         $this->middleware('permission:course-create', ['only' => ['create','store']]);
         $this->middleware('permission:course-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:course-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request){
      
        if(request()->ajax()){
            return self::getDatatable();
        }
       
      
        return view('admin.courses.index');
    }

    public function getDatatable(){
        
            $data = Course::with('franchises:id,name,franchise_code')->get();
        
        
        $user = auth()->user();
        return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('name', function($row) {
            return '<p class="text-primary"><span class="text-dark text-weight-bold">'.$row->course_code.'</span> <br>'.$row->name.'</span> </p>';
        })
        ->editColumn('franchise', function($row) {
            return '<p class="text-primary"><span class="text-dark text-weight-bold">'.$row->franchises->franchise_code.'</span> <br>'.$row->franchises->name.'</span> </p>';
        })
        ->editColumn('price', function($row) {
            return '<span class="fw-bold text-danger"><i class="fas fa-rupee-sign"></i> '.$row->price.'</span>';
        })
        
        ->addColumn('action', function($row) use ($user){
            $btn = '';
            if ($user->can('review-show')) {
                $btn .= '<a class="btn btn-warning btn-sm mb-1" href="'.route('course.reviews',['course'=>$row->id]).'">Reviews</a> ';
            }
            if ($user->can('syllabus-show')) {
                $btn .= '<a class="btn btn-secondary btn-sm mb-1" href="'.route('syllabus.show',$row->id).'">Syllabus</a> ';
            }
            if ($user->can('ebook-list')) {
                $btn .= '<a class="btn btn-info btn-sm mb-1" href="'.route('ebooks.index',$row->id).'">Ebook</a> ';
            }
           
                if ($user->can('course-show')) {
                    $btn .= '<a class="btn btn-success btn-sm" href="'.route('courses.show',$row->id).'">Show</a> ';
                } 
                if ($user->can('course-edit')) {
                    $btn .= '<a class="btn btn-primary btn-sm" href="'.route('courses.edit',$row->id).'"><i class="fas fa-pencil-alt"></i></a> ';
                } 
                if ($user->can('course-delete')) {
                    $btn .= \Form::open(['method' => 'DELETE','route' => ['courses.destroy', $row->id],'style'=>'display:inline']) .
                    \Form::button('<i class="fas fa-trash"></i>', ['type' => 'submit','class'=>'btn btn-danger btn-sm']).
                    \Form::close();
                    
                } 
            return $btn;
        })
        ->rawColumns(['name','franchise','price','action'])
        ->make(true);
    }
    
    public function create(){
        
        return view('admin.courses.create');
    }
    public function show($id){
        $course = Course::find($id);
        return view('admin.courses.show',compact('course'));
    }
    
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'slug' => 'required|unique:courses,slug',
            'franchise_id' => 'required|exists:franchises,id',
            'description' => 'required|string',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        if ($request->hasFile('image')) {
            
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            // Get Filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just Extension
            $extension = $request->file('image')->getClientOriginalExtension();
            // Filename To store
            $fileNameToStore = $filename.'_'. time().'.'.$extension;
            // Upload Image
            
            $path = $request->file('image')->storeAs('public/courses', $fileNameToStore);
            $course['image'] = $fileNameToStore;
        }
        $course['name'] = $request->input('name');
        $course['slug'] = $request->input('slug');
        $course['franchise_id'] = $request->input('franchise_id');
        $course['course_code'] = '';
        $course['description'] = $request->input('description');
        $course['price'] = $request->input('price');
        $course['meta_title'] = $request->input('meta_title');
        $course['meta_description'] = $request->input('meta_description');

        $added_course = Course::create($course);
        $added_course['course_code'] =  'CRSE'.date('Y'). str_pad($added_course->id, 4, '0', STR_PAD_LEFT);
        $added_course->save();
        return redirect()->route('courses.index')
                        ->with('success','Course created successfully');
        
    }
    public function edit($id){
        $course = Course::with(['franchises' => function ($query) {
            $query->select('id', 'name');
        }])->findOrFail($id);
        return view('admin.courses.edit',compact('course'));
    }
    public function update(Request $request, $id){
        $this->validate($request, [
            'name' => 'required',
            'franchise_id' => 'required|exists:franchises,id',
            'slug' => 'required|unique:courses,slug,'.$id,
            'description' => 'required|string',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        ]);
        $course = Course::find($id);
        $course['name'] = $request->input('name');
        $course['slug'] = $request->input('slug');
        $course['description'] = $request->input('description');
        $course['price'] = $request->input('price');
        $course['meta_title'] = $request->input('meta_title');
        $course['meta_description'] = $request->input('meta_description');
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);
           
            $orignal_image = $course->getOriginal('image');
            
            if($orignal_image!=NULL){
                $exists = Storage::exists('courses/'. $orignal_image);
                if ($exists) {
                    Storage::delete('courses/'. $orignal_image);
                }
            }
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            // Get Filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just Extension
            $extension = $request->file('image')->getClientOriginalExtension();
            // Filename To store
            $fileNameToStore = $filename. '_'. time().'.'.$extension;
            // Upload Image
            $path = $request->file('image')->storeAs('public/courses', $fileNameToStore);
            $course['image'] = $fileNameToStore;
        }
        //$course['course_code'] =  'CRSE'.date('Y'). str_pad($course->id, 4, '0', STR_PAD_LEFT);
        $course->update();
             return redirect()->route('courses.index')
                        ->with('success','Course updated successfully');
    }
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        //dd($course->students()->count());
        if($course->students()->count()==0){
            $course->syllabus()->delete();
            $course->ebooks()->delete();
            $orignal_image = $course->getOriginal('image');
            if($orignal_image!=NULL){
                $exists = Storage::exists('public/courses/'. $orignal_image);
                if ($exists) {
                    Storage::delete('public/courses/'. $orignal_image);
                }
            }
            $course->delete();

            return redirect()->route('courses.index')->with('success', 'Course successfully deleted');
        }
        return redirect()->route('courses.index')->with('warning', 'This course has been assigned to a student. Hence, course can not be deleted.');
    }
}
