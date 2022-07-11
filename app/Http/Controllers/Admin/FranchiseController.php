<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Franchise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;
use Yajra\DataTables\Facades\DataTables;

class FranchiseController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:customer-franchise-list', ['only' => ['index','getFranchise']]);
        $this->middleware('permission:customer-franchise-show', ['only' => ['show']]);
        $this->middleware('permission:customer-franchise-add', ['only' => ['create','store']]);
        $this->middleware('permission:customer-franchise-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:customer-franchise-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request){
        if(request()->ajax()){
            return self::getFranchise();
        }
        return view('admin.franchise.index');
    }
    public function getFranchise(){
        $data = Franchise::orderBy('id','ASC')->get();
        
        $user = auth()->user();
        return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('franchise', function($row){
            return '<span class="text-primary">'.$row->name.' </span> <br><span class="text-muted">'.$row->subname.'</span>';
        })
        // ->editColumn('duration', function($row){
        //     return '<span class="text-danger font-weight-bold">'.$row->service_period.' '.$row->service_interval.'</span>';
        // })
        ->editColumn('cost', function($row){
            return '<span class="text-success font-weight-bold"><i class="fas fa-rupee-sign"></i> '.$row->cost.'</span>';
        })
        
        ->addColumn('action', function($row) use ($user){
            $btn = '';
                 
                if ($user->can('franchise-show')) {
                    $btn .= '<a class="btn btn-success btn-sm" href="'.route('franchises.show',$row->id).'">Show</a> ';
                } 
                if ($user->can('franchise-edit')) {
                    $btn .= '<a class="btn btn-primary btn-sm" href="'.route('franchises.edit',$row->id).'"><i class="fas fa-pencil-alt"></i></a> ';
                } 
                if ($user->can('franchise-delete')) {
                    $btn .= \Form::open(['method' => 'DELETE','route' => ['franchises.destroy', $row->id],'style'=>'display:inline']) .
                    \Form::button('<i class="fas fa-trash"></i>', ['type' => 'submit','class'=>'btn btn-danger btn-sm']).
                    \Form::close();
                    
                } 
            return $btn;
        })
        ->rawColumns(['franchise','cost','action'])
        ->make(true);
    }
    public function create(){
        return view('admin.franchise.create');
    }
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'subname'=> 'required',
            'details' => 'required',
            'cost' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            
        ]);
        //'discount' => 'nullable|regex:/^\d+(\.\d{1,2})?$/|min:1|digits_between: 1,99',
        $input = $request->all();
        //dd($input);
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);
            $filenameWithExt = $request->file('image')->getClientOriginalName ();
            // Get Filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just Extension
            $extension = $request->file('image')->getClientOriginalExtension();
            // Filename To store
            $fileNameToStore = $filename. '_'. time().'.'.$extension;
            // Upload Image
            $path = $request->file('image')->storeAs('public/franchise', $fileNameToStore);
            $input['image'] = $fileNameToStore;
        }
        
        $input['franchise_code'] = '';

        $added_franchise = Franchise::create($input);
        $added_franchise['franchise_code'] =  'FCH'.date('Y'). str_pad($added_franchise->id, 5, '0', STR_PAD_LEFT);
        $added_franchise->save();
        return redirect()->route('franchises.index')
                        ->with('success','Franchise created successfully');
        
    }
    public function show($id){
        $franchise = Franchise::findOrFail($id);
        $course = $franchise->courses()->select('name','price','description')->limit(5)->get();
        //dd($course);
        return view('admin.franchise.show',compact('franchise','course'));
    }
    public function edit($id){
        $franchise = Franchise::findOrFail($id);
        //dd($user->user->phone);
        return view('admin.franchise.edit',compact('franchise'));
    }
    public function update(Request $request, $id){
        $this->validate($request, [
            'name' => 'required',
            'subname'=> 'required|unique:courses,code',
            'details' => 'required',
            'cost' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            
        ]);
        $input = $request->all();
        $franchise = Franchise::find($id);
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);
            $orignal_image = $franchise->image;
            if($orignal_image!==NULL){
                $exists = Storage::exists('franchise/'. $orignal_image);
                if ($exists) {
                    Storage::delete('franchise/'.$orignal_image);
                }
            }
            $filenameWithExt = $request->file('image')->getClientOriginalName ();
            // Get Filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just Extension
            $extension = $request->file('image')->getClientOriginalExtension();
            // Filename To store
            $fileNameToStore = $filename. '_'. time().'.'.$extension;
            // Upload Image
            $path = $request->file('image')->storeAs('public/franchise', $fileNameToStore);
            $input['image'] = $fileNameToStore;
        }
        
        $franchise->update($input);
             return redirect()->route('franchises.index')
                        ->with('success','Franchise updated successfully');
    }
    public function destroy($id)
    {
        $franchise = Franchise::findOrFail($id);
        $course = $franchise->courses()->count();
        if($course==0){
            $orignal_image = $franchise->image;
                if($orignal_image!==NULL){
                    $exists = Storage::exists('franchise/'. $orignal_image);
                    if ($exists) {
                        Storage::delete('franchise/'.$orignal_image);
                    }
                }
            $franchise->delete();

            return redirect()->route('franchises.index')->with('success', 'Franchise successfully deleted');
        }
        return redirect()->route('franchises.index')->with('warning', 'Franchise can not be deleted.');
    }
}
