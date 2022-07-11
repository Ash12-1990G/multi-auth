<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\StudentPayment;
use App\Modules\Student\StudentCourse\HasCourse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StudentPaymentController extends Controller
{   
    protected $service;
    protected $model;

    public function __construct()
    {
        $this->model = new StudentPayment;
        $this->service = new HasCourse();
    }
    public function index(Request $request){
        
        $details = $this->service->getCourse($request->courseid);
      
        if(request()->ajax()){
            
            return self::getDatatable($request->courseid);
        }
        return view('customer.payment.index',['details'=>$details]);
    }
    public function getDatatable($id){
        $data = $this->model->where('course_student_id',$id)->get();
        
        return DataTables::of($data)
        ->addIndexColumn()
        
        ->editColumn('paid', function($row) {
            return '<span class="fw-bold text-info"><i class="fas fa-rupee-sign"></i> '.$row->paid.'</span>';
        })
       
        
        ->editColumn('paid date', function($row) {
            $start_date = Carbon::parse($row->p_date)->format('F j, Y');
            return '<span class="fw-bold text-dark">'.$start_date .'</span>';
        })
        ->editColumn('remarks', function($row) {
            return '<p>'.$row->remarks.'</p>';
        })
        
        
        ->addColumn('action', function($row){
            $btn = '';
            
            
                $btn .= '<a class="btn btn-primary btn-sm mb-1" href="'.route('student.payment.edit',["paymentid"=>$row->id]).'"><i class="fas fa-pencil-alt"></i></a> ';
            
                $btn .= \Form::open(['method' => 'DELETE','route' => ['student.payment.destroy', ["paymentid"=>$row->id]],'style'=>'display:inline']) .
                \Form::button('<i class="fas fa-trash"></i>', ['type' => 'submit','class'=>'btn btn-danger btn-sm mb-1']).
                \Form::close();
           
            return $btn;
        })
        ->rawColumns(['paid','paid date','remarks','action'])
        ->make(true);
    }
    public function create(Request $request){
        $details = $this->service->getCourse($request->courseid);
        return view('customer.payment.create',['details'=>$details]);
    }
    public function store(Request $request){
        $messages = [
            'p_date.required' => 'The payment date field is required.',
            'p_date.date' => 'The payment date field has invalid date format.',
        ];
        $this->validate($request, [
            'course_student_id' => 'required|exists:course_student,id',
            'paid' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'p_date' => 'required|date',
            'remarks' => 'nullable|string',
        ],$messages);
        //dd($request);
        $cf= $this->service->getCourse($request->course_student_id);
        if($request->paid>$cf->due){
            return redirect()->back()->with('error','Paying amount is more than due amount.');
        }  
        $data['due'] = $cf->due - $request->paid;
        if($data['due']==0){
            $data['payment_status'] = "paid";
        }
        
        $input = $request->all();
        //dd($input);
        $this->model->create($input);
        
        $this->service->updateData($data,$request->course_student_id);
        return redirect()->route('student.payment.index',['courseid'=>$request->input('course_student_id')])
                        ->with('success','Payment added successfully');
        
    }
   
    public function edit(Request $request){
        $payment = $this->model->findOrFail($request->paymentid);
        return view('customer.payment.edit',compact('payment'));
    }
    public function update(Request $request,$paymentid){
        $messages = [
            'p_date.required' => 'The payment date field is required.',
            'p_date.date' => 'The payment date field has invalid date format.',
        ];
        $this->validate($request, [
            'p_date' => 'required|date',
            'remarks' => 'nullable|string',
        ],$messages);
     
        
        $input = $this->model->find($paymentid);
       
        $input['p_date'] = $request->p_date;
        $input['remarks'] = $request->remarks;
       
        $input->save();
        return redirect()->route('student.payment.index',['courseid'=>$input->course_student_id])
                        ->with('success','Payment updated successfully');
    }
    public function destroy($paymentid){
        $data = $this->model->findOrFail($paymentid);
        //$cf= $this->service->getAttributeValues($data->customer_franchise_id);
        $cf = $data->courseStudents;
        $pay['due'] = $cf->due + $data->paid;
        if($pay['due']===0){
            $pay['payment_status'] = "paid";
        }
        else{
            $pay['payment_status'] = "pending";
        }
        $this->service->updateData($pay,$data->course_student_id);
        $data->delete();

        return redirect()->back()->with('success', 'Payment successfully deleted from customer');
    }
}
