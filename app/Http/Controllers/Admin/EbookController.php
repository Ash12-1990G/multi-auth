<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Ebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EbookController extends Controller
{
    public function index(Request $request,$course_id){
        $ebook =  Ebook::where('course_id',$course_id)->paginate(5);
        $course =  Course::find($course_id);
        //dd($course);
        return view('admin.ebooks.index',compact('ebook','course'))
        ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    public function create($course_id){
        $course = Course::find($course_id);
        return view('admin.ebooks.create',compact('course'));
    }
    public function store(Request $request){
        
        $this->validate($request, [
            'course_id' => 'required|exists:courses,id',
            'title'=> 'required|string',
            'author'=> 'required|string',
            'bookpath'=> 'required|file|mimes:pdf',
            'coverpath' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        //upload book
        $filenameWithExt = $request->file('bookpath')->getClientOriginalName ();
        // Get Filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        // Get just Extension
        $extension = $request->file('bookpath')->getClientOriginalExtension();
        // Filename To store
        $fileNameToStore = $filename. '_'. time().'.'.$extension;
        // Upload Image
        $path = $request->file('bookpath')->storeAs('public/ebooks', $fileNameToStore);
        
        // upload cover
        $filecover = $request->file('coverpath')->getClientOriginalName ();
    
        $filecovername = pathinfo($filecover, PATHINFO_FILENAME);
        
        $cover_extension = $request->file('coverpath')->getClientOriginalExtension();
        
        $cover_store = $filecovername. '_'. time().'.'.$cover_extension;
        // Upload Image
        $path_cover = $request->file('coverpath')->storeAs('public/ebooks', $cover_store);

        $input = $request->all();
        $input['bookpath'] = $fileNameToStore; 
        $input['coverpath'] = $cover_store; 
        Ebook::create($input);
        return redirect()->route('ebooks.index',$request->input('course_id'))
                        ->with('success','Book uploaded successfully');
    }
    public function edit($id){
        $book = Ebook::findOrFail($id);
        return view('admin.ebooks.edit',compact('book'));
    }
    public function update(Request $request, $id){
        $this->validate($request, [
            'title'=> 'required|string',
            'author'=> 'required|string',
        ]);
        
        $input = $request->all();
        $book = Ebook::find($id);
        $book->update($input);
        return redirect()->route('ebooks.index',$book->course_id)
                        ->with('success','Book updated successfully');

    }
    public function destroy($id){
        $book = Ebook::findOrFail($id);
        $book->delete();
        Storage::delete(['ebooks/'.$book->bookpath, 'ebooks/'.$book->coverpath]);
        return redirect()->route('ebooks.index',$book->course_id)
                        ->with('success','User deleted successfully');
    }
}
