<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\Customer\Franchise\CustomerFranchiseService;
use App\Modules\Customer\Payment\CustomerPaymentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CustomerPaymentController extends Controller
{
    protected $service;
    protected $model;

    public function __construct()
    {
        $this->middleware('permission:customer-payment-list', ['only' => ['index','getDatatable']]);
        $this->middleware('permission:customer-payment-add', ['only' => ['create','store']]);
        $this->middleware('permission:customer-payment-edit', ['only' => ['edit','update','updateConcession','editConcession']]);
        $this->middleware('permission:customer-payment-delete', ['only' => ['destroy']]);
        $this->service = new CustomerFranchiseService();
        $this->model = new CustomerPaymentService();
    }
    public function index(Request $request){
        $customer_franchise = $request->customer_franchise;
        $paid = $this->model->getPaidByCustFranchise($customer_franchise);
        $details = $this->service->getCfById($customer_franchise);
        //dd($details);
        if(request()->ajax()){
            
            return self::getDatatable($request->customer_franchise);
        }
        return view('admin.customers.payment.index',['details'=>$details,'paid'=>$paid]);
    }
    public function getDatatable($id){
        $data = $this->model->getPaymentByCustFranchise($id);
        
        $user = auth()->user();
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
        
        
        ->addColumn('action', function($row) use ($user){
            $btn = '';
            
            if ($user->can('customer-payment-edit')) {
                $btn .= '<a class="btn btn-primary btn-sm mb-1" href="'.route('customer.payment.edit',["customer_franchise"=>$row->customer_franchise_id,"id"=>$row->id]).'"><i class="fas fa-pencil-alt"></i></a> ';
            }
            if ($user->can('customer-payment-delete')) {
                $btn .= \Form::open(['method' => 'DELETE','route' => ['customer.payment.destroy', $row->id],'style'=>'display:inline']) .
                \Form::button('<i class="fas fa-trash"></i>', ['type' => 'submit','class'=>'btn btn-danger btn-sm mb-1']).
                \Form::close();
                
            }
            return $btn;
        })
        ->rawColumns(['paid','paid date','remarks','action'])
        ->make(true);
    }
    public function create(Request $request){
        $details = $this->service->getCfById($request->customer_franchise);
        return view('admin.customers.payment.create',['details'=>$details]);
    }
    public function store(Request $request){
        $messages = [
            'p_date.required' => 'The payment date field is required.',
            'p_date.date' => 'The payment date field has invalid date format.',
        ];
        $this->validate($request, [
            'customer_franchise_id' => 'required|exists:customer_franchise,id',
            'paid' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'p_date' => 'required|date',
            'remarks' => 'nullable|string',
        ],$messages);
        $cf= $this->service->getAttributeValues($request->customer_franchise_id);
        if($request->paid>$cf->due){
            return redirect()->back()->with('error','Paying amount is more than due amount.');
        }  
        $data['due'] = $cf->due - $request->paid;
        if($data['due']==0){
            $data['payment_status'] = "paid";
        }
        
        $input = $request->all();
        $this->model->storePayment($input);
        
        $this->service->updateById($data,$request->customer_franchise_id);
        return redirect()->route('customer.payment.index',$request->input('customer_franchise_id'))
                        ->with('success','Payment added successfully');
        
    }
   
    public function edit(Request $request){
        $payment = $this->model->getPaymentById($request->id);
        $details = $this->service->getCfById($request->customer_franchise);
        return view('admin.customers.payment.edit',['details'=>$details,'payment'=>$payment]);
    }
    public function update(Request $request,$id){
        $messages = [
            'p_date.required' => 'The payment date field is required.',
            'p_date.date' => 'The payment date field has invalid date format.',
        ];
        $this->validate($request, [
           
            
            'p_date' => 'required|date',
            'remarks' => 'nullable|string',
        ],$messages);
     
        
        $input = $this->model->getPaymentById($id);
       
        $input['p_date'] = $request->p_date;
        $input['remarks'] = $request->remarks;
       
        $input->save();
        return redirect()->route('customer.payment.index',$input->customer_franchise_id)
                        ->with('success','Payment updated successfully');
    }
    public function destroy($id){
        $data = $this->model->deleteById($id);
        $cf= $this->service->getAttributeValues($data->customer_franchise_id);
        $pay['due'] = $cf->due + $data->paid;
        if($pay['due']===0){
            $pay['payment_status'] = "paid";
        }
        else{
            $pay['payment_status'] = "pending";
        }
        $this->service->updateById($pay,$data->customer_franchise_id);
        $data->delete();

        return redirect()->back()->with('success', 'Payment successfully deleted from customer');
    }
}
