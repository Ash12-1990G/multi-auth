<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Franchise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FranchiseController extends Controller
{
    public function index(Request $request){
        $data = Franchise::search(request(['search']))->orderBy('id','DESC')->paginate(5);
      //dd($data);
        return view('admin.franchise.index',compact('data'))
        ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    public function create(){
        return view('admin.franchise.create');
    }
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'subname'=> 'required|unique:courses,code',
            'details' => 'required',
            'cost' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'discount' => 'nullable|regex:/^\d+(\.\d{1,2})?$/|min:1|digits_between: 1,99',
        ]);
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
        

        Franchise::create($input);
        return redirect()->route('franchises.index')
                        ->with('success','Franchise created successfully');
        
    }
    public function show($id){
        $franchise = Franchise::findOrFail($id);
        //dd($user->user->phone);
        return view('admin.franchise.show',compact('franchise'));
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
            'discount' => 'nullable|regex:/^\d+(\.\d{1,2})?$/|min:1|digits_between: 1,99',
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
}
