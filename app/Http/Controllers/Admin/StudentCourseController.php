<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Student;
use App\Models\StudentCourse;
use App\Modules\Student\StudentService;
use App\Modules\Course\CourseService;
use App\Modules\Customer\CustomerService;
use App\Modules\Customer\Franchise\CustomerFranchiseService;
use App\Modules\Student\StudentCourse\HasCourse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class StudentCourseController extends Controller
{
    public $service;
    public $cls;

    public function __construct(){
      
        $this->middleware('permission:student-course-list', ['only' => ['index','getDatatable']]);
        $this->middleware('permission:student-course-add', ['only' => ['create','store']]);
        $this->middleware('permission:student-course-add|student-course-edit', ['only' => ['searchCustomer','autoSeachCourse','selectedCourse']]);
        $this->middleware('permission:student-course-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:student-course-delete', ['only' => ['destroy']]);
        $this->service = new StudentService();
    }
    public function index(Request $request){
        if(auth()->user()->hasRole('Franchise-Admin')){
            $data = $this->service->getStudentByCenter(request()->student_id);
        }
        else{
            $data = $this->service->getNameId(request()->student_id);
        }
       

       $student = StudentCourse::with('courses:id,name')->where('student_id',request()->student_id)->get();
     
        if(request()->ajax()){
            return self::getDatatable($student);
        };
        
        return view('admin.students.courses.index',compact('data'));
    }
    public function getDatatable($data){
      
        
        $user = auth()->user();
        return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('roll no', function($row) {
            return $row->roll_no;
        })
        ->editColumn('course name', function($row) {
            return $row->courses->name;
        })
        ->editColumn('price', function($row){
            return '<span class="fw-bold text-success"><i class="fas fa-rupee-sign"></i> '.$row->price.'</span>';
        })
        ->editColumn('due', function($row){
            if($row->due>0){
                return '<span class="fw-bold text-danger"><i class="fas fa-rupee-sign"></i> '.$row->due.'</span>';
            }
            return '<span class="fw-bold text-danger">'.$row->due.'</span>';
            
        })
        ->editColumn('payment option', function($row) {
            return '<span class="fw-bold text-dark">'.$row->payment_option.'</span>';
        })
        ->editColumn('payment status', function($row) {
            if($row->payment_status=="paid"){
                $str = "bg-success";
                $pstr = "text-success";
            }
            else{
                $str = "bg-danger"; 
                $pstr = "text-danger";
            }
            $paid = $row->price - $row->due;
            $percent = ($paid/$row->price)*100;
            return '<div class="bg-white py-2 px-1"><div class="progress progress-sm active"><div class="progress-bar '.$str.' progress-bar-striped" role="progressbar" aria-valuenow="'.$percent.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$percent.'%"><span class="sr-only"></span></div></div><p class="mb-0 '.$pstr.'">'.ucfirst($row->payment_status).' </p></div>';
        })
        ->editColumn('start date', function($row){
            $start_date = Carbon::parse($row->start_date)->format('F j, Y');
            return '<span class="text-success">'.$start_date.'</span>';
        })
        ->addColumn('action', function($row) use ($user){
            $btn = '';
            if($user->role('Franchise-Admin')){
                $editUrl ='customer.studentcourses.edit';
                $destroyUrl = 'customer.studentcourses.destroy';
            }
            else{
                $editUrl ='studentcourse.edit';
                $destroyUrl = 'studentcourse.destroy';
            } 
                if ($user->hasRole('Franchise-Admin')) {
                    $btn .= '<a class="btn btn-secondary btn-sm mb-1" href="'.route('student.payment.index',['courseid'=>$row->id]).'">Payment</a> ';
                }
                if ($user->can('student-course-edit')) {
                    $btn .=  '<button type="button" class="btn btn-success btn-sm mb-1" id="getEditConcessionData'.$row->id.'" data-id="'.$row->id.'" onclick="callModal(event,'.$row->id.');">Concession</button> ';
                    $btn .= '<a class="btn btn-primary btn-sm mb-1" href="'.route($editUrl,$row->id).'"><i class="fas fa-pencil-alt"></i></a> ';
                } 
                if ($user->can('student-course-delete')) {
                    $btn .= \Form::open(['method' => 'DELETE','route' => [$destroyUrl, $row->id],'style'=>'display:inline']) .
                    \Form::button('<i class="fas fa-trash"></i>', ['type' => 'submit','class'=>'btn btn-danger btn-sm mb-1']).
                    \Form::close();
                    
                } 
            return $btn;
        })
        ->rawColumns(['roll no','course name','price','due','payment option','payment status','start date','action'])
        ->make(true);
    }
    public function create(){
        if(auth()->user()->hasRole('Franchise-Admin')){
            $data = $this->service->getStudentByCenter(request()->student_id);
        }
        else{
            $data = $this->service->getNameId(request()->student_id);
        }
        
               
        return view('admin.students.courses.create',compact('data'));
    }
    
    public function searchCustomer(Request $request){
        $data = [];
        if($request->has('q')){
            $name = $request->q;
            $customer_id = $request->customer_id;
            $model = new CustomerService();
            $data = $model->getCustomerById($customer_id);
        }
         
        //dd($request);
        return response()->json($data);
    }
    public function autoSeachCourse(Request $request){
        $data = [];
        if($request->has('id')){
            $customer = $request->id;
            if($request->has('q')){
                $search = $request->q;
            }
            else{
                $search = ''; 
            }
            $franchise = new CustomerFranchiseService();
            $customer_franchise  = $franchise->getCustomersFranchise($customer);
            if($customer_franchise->count()){
                $course = new CourseService();
            $data = $course->getCourses($search,$customer_franchise);
            }
            
        }
        
         
        //dd($customer_franchise);
        return response()->json($data);
    }
    public function selectedCourse(Request $request){
        $data = [];
        //dd($request);
        //$data = Course::where('id',3)->first();
        if($request->has('id')){
            $id = $request->id;
            $course = new CourseService();
            $data = $course->getCoursePriceById($id);
        }
        //dd($request);
        return response()->json($data);
    }
    public function store(Request $request){
        $student = $request->input('student_id');
       
        $this->validate($request, [
            'student_id' => 'required|exists:students,id',
            'course_id' => ['required_with:student_id','exists:courses,id',Rule::unique('course_student')->where('student_id',$student)],
            'start_date' => ['regex:/^(\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01]))$/'],
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'payment_option' => ['required',Rule::in(['installment','full'])],

        ]);
        $input = $request->all();
        $input['due'] = $request->input('price');
        $input['concession'] = 0;
        $input['discount'] = 0;
        $stucourse = new HasCourse();
        $time = Carbon::now()->timestamp;
        $input['roll_no'] = $time;
        if($request->input('due')==0){
            $input['payment_status']='paid';
        }
        else{
            $input['payment_status']='pending';
        }
        $val = $stucourse->storeData($input);
        
        $val['roll_no'] = $time.$val->id;
        $val->save();
        if(auth()->user()->hasRole('Franchise-Admin')){
            return redirect()->route('customer.studentcourses.index',$request->student_id)
            ->with('success','Course added successfully'); 
        }
        return redirect()->route('studentcourses.index',$request->student_id)
                        ->with('success','Course added successfully');
    }
    public function edit($id){
        $stucourse = new HasCourse();
        $data = $stucourse->getAllById($id);        
        if($data==null){
            abort(404);
        }
        return view('admin.students.courses.edit',compact('data'));
    }
    public function update(Request $request, $id){
       
        $student = $request->input('student_id');
        $messages = [
            'customer_id.required' => 'Select any center.',
            'customer_id.exists' => 'Selected center do not exist', 
        ];
        $this->validate($request, [
            'student_id' => 'required|exists:students,id',
            'course_id' =>  ['required_with:student_id','exists:courses,id',Rule::unique('course_student')->where('student_id',$student)->whereNot('id',$id)],
            'start_date' => ['regex:/^(\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01]))$/'],
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            // 'concession' => ['required','regex:/^\d+(\.\d{1,2})?$/','lte:price'],
            'payment_option' => ['required',Rule::in(['installment','full'])],
        ],$messages);
        
        $input = $request->all();
        $input['due']=$request->input('price');
        $stucourse = new HasCourse();
        $stu = $stucourse->getcourse($id);
        if($stu->studentPayments()->count()==0){
            $val = $stucourse->updateData($input,$id);
            if(auth()->user()->hasRole('Franchise-Admin')){
                return redirect()->route('customer.studentcourses.index',$request->student_id)
                            ->with('success','Course added successfully'); 
            }
            
            return redirect()->route('studentcourses.index',$request->student_id)
                            ->with('success','Course added successfully');
        }
        if(auth()->user()->hasRole('Franchise-Admin')){
            return redirect()->route('customer.studentcourses.index',$request->student_id)
                        ->with('warning','Sorry you cannot modify the fields'); 
        }
        
        return redirect()->route('studentcourses.index',$request->student_id)
                        ->with('warning','Sorry you cannot modify the fields');
    }
    public function editConcession($id)
    {
        
        if(auth()->user()->hasRole('Franchise-Admin')){
            $customerid = auth()->user()->customers->id;
            $data = StudentCourse::whereHas('students',function($q) use ($customerid){
                $q->where('customer_id',$customerid);    
            })->find($id);
        }
        else{
            $data = StudentCourse::find($id);

        }
        

        $html = '
                <div class="form-group">
                    <label>Concession Amount</label>
                    <input type="text" class="form-control" name="concession" id="editConcession" value="'.$data->concession.'">
                </div>';

        return response()->json(['html'=>$html]);
    }
    public function updateConcession(Request $request, $id)
    {
        $data = StudentCourse::find($id);
        $validator = Validator::make($request->all(), [
            'concession' => ['required','regex:/^\d+(\.\d{1,2})?$/',function ($attribute, $value, $fail) use ($data){
                if ($value > $data->due) {
                    $fail('The '.$attribute.' amount must not exceeds the due amount');
                }
            },
        ],
        ]);
        
        // $validator->after(function ($validator) use ($request,$data){
        //     if($request->input('concession')>$data->due){
        //         $validator->errors()->add('concession', 'Concession amount must not exceeds the due amount.');
        //     }
        // });
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $due = $data->due - $request->input('concession');
        if($due==0){
            $status='paid';
        }
        $status='pending';
        $data->update(['concession'=>$request->input('concession'),'due'=>$due,'payment_status'=>$status]); 
        return response()->json(['success'=>'Concession amount inserted successfully']);
        
    }
    public function destroy($id)
    {
        $stucourse = new HasCourse();
        if(auth()->user()->hasRole('Franchise-Admin')){
            $data = $stucourse->deleteByCustomer($id);
           
            //dd($data);
            if($data==null){
                abort(404);
            }
        }
        //dd();
        $hascourse = $stucourse->getcourse($id);
        //$d = StudentCourse::find($id);
        //dd($d->studentPayments());
        $hascourse->studentPayments()->delete();
        $val = $stucourse->deleteById($id);
        return redirect()->back()
                        ->with('success','Course deleted successfully');
    }
}
