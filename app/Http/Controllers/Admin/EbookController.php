<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Ebook;
use App\Modules\Course\Ebooks\EbookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;


class EbookController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ebook-list', ['only' => ['index','getDatatable']]);
        $this->middleware('permission:ebook-add', ['only' => ['create','store']]);
        $this->middleware('permission:ebook-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:ebook-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request,$course_id){
        // $ebook =  Ebook::where('course_id',$course_id)->paginate(5);
        $course =  Course::find($course_id);
        //dd($course);
        if(request()->ajax()){
            return self::getDatatable($course_id);
        };
        return view('admin.ebooks.index',compact('course'));
    }
    public function getDatatable($course_id){
        $data = Ebook::where('course_id',$course_id)->get();
        $user = auth()->user();
        return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('title', function($row) {
            return '<p class="text-primary" > '.$row->title.'</p>';
        })
        ->editColumn('author', function($row) {
            return $row->author;
        })
        ->editColumn('book cover', function($row) {
            return '<img class="img-fluid" width="80" height="50" src="'.asset('storage/ebooks/'.$row->coverpath).'">';
        })
        ->addColumn('action', function($row) use ($user){
            $btn = '';
            $btn .= '<a class="btn btn-dark btn-sm" href="'.route('ebooks.download',$row->bookpath).'"><i class="fas fa-download"></i></a> ';
                if ($user->can('ebook-edit')) {
                    $btn .= '<a class="btn btn-primary btn-sm" href="'.route('ebooks.edit',$row->id).'"><i class="fas fa-pencil-alt"></i></a> ';
                } 
                if ($user->can('ebook-delete')) {
                    $btn .= \Form::open(['method' => 'DELETE','route' => ['ebooks.destroy', $row->id],'style'=>'display:inline']) .
                    \Form::button('<i class="fas fa-trash"></i>', ['type' => 'submit','class'=>'btn btn-danger btn-sm']).
                    \Form::close();
                    
                } 
            return $btn;
        })
        ->rawColumns(['title','author','book cover','action'])
        ->make(true);
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
        $path = $request->file('bookpath')->storeAs('ebooks', $fileNameToStore);
        
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
    public function download($pdf)
    {
        
        $book = new EbookService();
        return $book->ebookDownload($pdf);
       
        
    }
    public function destroy($id){
        $book = Ebook::findOrFail($id);
        $course = $book->course_id;
        $bookpath = storage_path('app/ebooks/' . $book->bookpath);

        if(File::exists($bookpath)){
            File::delete($bookpath);
        }
        if(Storage::exists('public/ebooks/' . $book->coverpath)){
            Storage::delete('public/ebooks/' . $book->coverpath);
        }
        $book->delete();
        return redirect()->route('ebooks.index',$course)
                        ->with('success','User deleted successfully');
    }
}
