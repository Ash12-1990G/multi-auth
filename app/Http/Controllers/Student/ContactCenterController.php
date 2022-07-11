<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Jobs\ContactMailJob;
use App\Modules\Student\StudentCourse\HasCourse;
use App\Modules\Student\StudentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactCenterController extends Controller
{
    protected $student;
    public function __construct()
    {
        $this->student = new StudentService();

        
    }
    public function getCustomerInfo(){
        $stu = $this->student->getStudentId(Auth::id());
        if($stu->count()){
            $model = new HasCourse();
            
            $center = $model->getCenter($stu->id);
            //dd($center->customers->users);
        }
        return view('student.contact_center',compact('center'));
    }
    public function sendMail(Request $request){
        $this->validate($request, [
            'to' => 'required|email|exists:users,email',
            'subject'=> 'required',
            'message' => 'required',
        ]);
        $stu = $this->student->getStudentId(Auth::id());
        
        $res = $this->student->CheckMail($stu->id,$request->to);
  
        if(!$res){
            return redirect()->back()->with('error','Email is invalid');
        }
        $details = ['to' => $request->to,
        'subject' => $request->subject,
        'from' => auth()->user()->email,
        'message' => $request->message,
        ];
        $emailJob = (new ContactMailJob($details))->delay(Carbon::now()->addMinutes(1));
        dispatch($emailJob);
        return redirect()->route('student.centers')
                        ->with('success','Mail has sent successfully');
    }
}
