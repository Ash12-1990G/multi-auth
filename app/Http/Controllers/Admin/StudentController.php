<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Jobs\SendEmailJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Auth\Events\Registered;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        
        $data = Student::with('users')->search(request(['search']))->orderBy('id','DESC')->paginate(5);
      //dd($data);
        return view('admin.students.index',compact('data'))
        ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    public function create(){
        return view('admin.students.create');
    }
    public function show($id){
        $student = Student::with('users')->find($id);
        //dd($student);
        return view('admin.students.show',compact('student'));
    }
    public function store(Request $request)
    {
        $messages = [
            'address1.required' => 'The address field is required.',
            'state1.required' => 'The address field is required.',
            'city1.required' => 'The city field is required.',
            'pincode1.required' => 'The pincode field is required.',
            'pincode1.regex' => 'The pincode format is invalid.',
            'address2.required_with' => 'The address field of permanent address is required when state / city / pincode of same is present.',
            'state2.required_with' => 'The state field of permanent address is required when address / city / pincode of same is present.',
            'city2.required_with' => 'The city field of permanent address is required when address / state / pincode of same is present.',
            'pincode2.required_with' => 'The pincode field of permanent address is required when address / state / city of same is present.',
            'pincode2.regex' => 'The pincode format is invalid.',
        ];
        $this->validate($request, [
            'name' => 'required|regex:/^[a-zA-Z]+ [a-zA-Z]+$/',
            'email' => 'required|email|unique:users,email',
            'phone' => ['regex:/^(\+)[1-9]{1}([0-9][\s]*){9,16}$/'],
            'birth' => ['regex:/^(\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01]))$/'],
            'admission' => ['regex:/^(\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01]))$/'],
            'gender' => 'required',
            'alt_phone' => ['nullable','regex:/^(\+)[1-9]{1}([0-9][\s]*){9,16}$/'],
            'father_name' => 'required|regex:/^[a-zA-Z]+ [a-zA-Z]+$/',
            'address1'=> 'required|string',
            'state1' => 'required|string',
            'city1' => 'required|string',
            'pincode1' => ['required','regex:/^\d{4}$|^\d{6}$/'],
            'address2'=> 'required_with:state2,city2,pincode2',
            'state2' => 'required_with:address2,city2,pincode2',
            'city2' => 'required_with:address2,state2,pincode2',
            'pincode2' => ['nullable','required_with:address2,state2,city2','regex:/^\d{4}$|^\d{6}$/'],
        ], $messages);
        $random = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!$%^&!$%^&');
        $password = substr($random, 0, 10);
        $input['name'] = $request->input('name');
        $input['email'] = $request->input('email');
        $input['password'] = Hash::make($password);

        $mailData = [
            'name' => $input['name'],
            'type' => 'student',
            'email' => $input['email'],
            'password' => $password
        ];
        
        
//dd($student);
        $user = User::create($input);
        $user->assignRole('Student-Admin');
        $student['user_id'] = $user->id;
        $student['admission'] = $request->input('admission');
        $student['phone'] = $request->input('phone');
        $student['birth'] = $request->input('birth');
        $student['gender'] = $request->input('gender');
        $student['alt_phone'] = $request->input('alt_phone');
        
        $student['father_name'] = $request->input('father_name');
        $student['address1'] = $request->input('address1');
        $student['state1'] = $request->input('state1');
        $student['city1'] = $request->input('city1');
        $student['pincode1'] = $request->input('pincode1');
        $student['address2'] = $request->input('address2');
        $student['state2'] = $request->input('state2');
        $student['city2'] = $request->input('city2');
        $student['pincode2'] = $request->input('pincode2');
        //dd($student);    
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
            $path = $request->file('image')->storeAs('public/students', $fileNameToStore);
            $student['image'] = $fileNameToStore;
        }
        
        $stu = Student::create($student);
        //dispatching to queue
        dispatch(new SendEmailJob($mailData));
        //dispatching to verify email to queue
        $user->sendEmailVerificationNotification();
        return redirect()->route('students.index')
                        ->with('success','Student created successfully');
    }
    public function edit($id){
        $user = Student::findOrFail($id);
        //dd($user->user->phone);
        return view('admin.students.edit',compact('user'));
    }
    public function update(Request $request, $id){
        $student = Student::find($id);
        $messages = [
            'address1.required' => 'The address field is required.',
            'state1.required' => 'The address field is required.',
            'city1.required' => 'The city field is required.',
            'pincode1.required' => 'The pincode field is required.',
            'pincode1.regex' => 'The pincode format is invalid.',
            'address2.required_with' => 'The address field of permanent address is required when state / city / pincode of same is present.',
            'state2.required_with' => 'The state field of permanent address is required when address / city / pincode of same is present.',
            'city2.required_with' => 'The city field of permanent address is required when address / state / pincode of same is present.',
            'pincode2.required_with' => 'The pincode field of permanent address is required when address / state / city of same is present.',
            'pincode2.regex' => 'The pincode format is invalid.',
        ];
        $this->validate($request, [
            'name' => 'required|regex:/^[a-zA-Z]+ [a-zA-Z]+$/',
            'email' => 'required|email|unique:users,email,'.$student->user_id,
            'phone' => ['regex:/^(\+)[1-9]{1}([0-9][\s]*){9,16}$/'],
            'birth' => ['regex:/^(\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01]))$/'],
            'admission' => ['regex:/^(\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01]))$/'],
            'gender' => 'required',
            'alt_phone' => ['nullable','regex:/^(\+)[1-9]{1}([0-9][\s]*){9,16}$/'],
            'father_name' => 'required|regex:/^[a-zA-Z]+ [a-zA-Z]+$/',
            'address1'=> 'required|string',
            'state1' => 'required|string',
            'city1' => 'required|string',
            'pincode1' => ['required','regex:/^\d{4}$|^\d{6}$/'],
            'address2'=> 'required_with:state2,city2,pincode2',
            'state2' => 'required_with:address2,city2,pincode2',
            'city2' => 'required_with:address2,state2,pincode2',
            'pincode2' => ['nullable','required_with:address2,state2,city2','regex:/^\d{4}$|^\d{6}$/'],
        ], $messages);

        
        $input['name'] = $request->input('name');
        $input['email'] = $request->input('email');
        $student['phone'] = $request->input('phone');
        $student['birth'] = $request->input('birth');
        $student['gender'] = $request->input('gender');
        $student['alt_phone'] = $request->input('alt_phone');
        $student['admission'] = $request->input('admission');
        $student['father_name'] = $request->input('father_name');
        $student['address1'] = $request->input('address1');
        $student['state1'] = $request->input('state1');
        $student['city1'] = $request->input('city1');
        $student['pincode1'] = $request->input('pincode1');
        $student['address2'] = $request->input('address2');
        $student['state2'] = $request->input('state2');
        $student['city2'] = $request->input('city2');
        $student['pincode2'] = $request->input('pincode2');
        //dd($student);
     
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);
            $orignal_image = $student->getOriginal('image');
            if($orignal_image!==NULL){
                $exists = Storage::exists('storage/students/'. $orignal_image);
                if ($exists) {
                    Storage::delete('storage/students/'. $orignal_image);
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
            $path = $request->file('image')->storeAs('public/students', $fileNameToStore);
            $student['image'] = $fileNameToStore;
        }
        
        $student->update();
        $student->users()->update($input);
        return redirect()->route('students.index')
                        ->with('success','Student updated successfully');
    }
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->users()->delete();
        $orignal_image = $student->getOriginal('image');
        if($orignal_image!==NULL){
            $exists = Storage::exists('storage/students/'. $orignal_image);
            if ($exists) {
                Storage::delete('storage/students/'. $orignal_image);
            }
        }
        $student->delete();

        return redirect('/students')->with('success', 'Student successfully deleted');
    }
}
