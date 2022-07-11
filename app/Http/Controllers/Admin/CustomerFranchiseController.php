<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Customer_Franchise;
use App\Models\Franchise;
use App\Models\Student;
use App\Modules\Customer\CustomerService;
use App\Modules\Franchise\FranchiseService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class CustomerFranchiseController extends Controller
{
    protected $service;
    public function __construct()
    {
        $this->middleware('permission:customer-franchise-list', ['only' => ['index','getDatatable']]);
        $this->middleware('permission:customer-franchise-show', ['only' => ['show']]);
        $this->middleware('permission:customer-franchise-add', ['only' => ['create','store']]);
        $this->middleware('permission:customer-franchise-add|customer-franchise-edit', ['only' => ['autoSeachFranchise','selectedFranchise']]);
        $this->middleware('permission:customer-franchise-edit', ['only' => ['edit','update','updateConcession','editConcession']]);
        $this->middleware('permission:customer-franchise-delete', ['only' => ['destroy']]);
        $this->service = new CustomerService();
    }
    public function index(Request $request){
        $customer = $request->customer;
        
        $details = $this->service->getCustomerById($customer);
       //dd($details->franchises);
        if(request()->ajax()){
            
            return self::getDatatable($details,$customer);
        }
              //dd($data);
        return view('admin.customers.customerfranchise.index',['customer_id'=>$customer,'customer_data'=>$details]);

    }
    public function getDatatable($details,$customer){
        $data = $details->franchises;
        // $data = Customer_Franchise::with('franchises:id,name,franchise_code')->where('customer_id',$customer)->get();
        $user = auth()->user();
        return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('franchise', function($row) {
            return '<p class="text-primary"><span class="text-dark text-weight-bold">'.$row->franchise_code.'</span> <br>'.$row->name.'</span> </p>';
        })
        ->editColumn('total amount', function($row) {
            return '<span class="fw-bold text-info"><i class="fas fa-rupee-sign"></i> '.$row->pivot->amount.'</span>';
        })
       
        ->editColumn('due', function($row) {
            if($row->pivot->due==0){
                return $row->pivot->due;
            }
            return '<span class="fw-bold text-danger"><i class="fas fa-rupee-sign"></i> '.$row->pivot->due.'</span>';
        })
        ->editColumn('payment option', function($row) {
            return '<span class="fw-bold text-dark">'.$row->pivot->payment_option.'</span>';
        })
        ->editColumn('payment status', function($row) {
            if($row->pivot->payment_status=="paid"){
                $str = "bg-success";
                $pstr = "text-success";
            }
            else{
                $str = "bg-danger"; 
                $pstr = "text-danger";
            }
            $paid = $row->pivot->amount - $row->pivot->due;
            $percent = ($paid/$row->pivot->amount)*100;
            return '<div class="bg-white py-2 px-1"><div class="progress progress-sm active"><div class="progress-bar '.$str.' progress-bar-striped" role="progressbar" aria-valuenow="'.$percent.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$percent.'%"><span class="sr-only"></span></div></div><p class="mb-0 '.$pstr.'">'.ucfirst($row->pivot->payment_status).' </p></div>';
        })
        ->editColumn('service starts', function($row) {
            $start_date = Carbon::parse($row->pivot->service_taken)->format('F j, Y');
            return '<span class="fw-bold text-dark">'.$start_date .'</span>';
        })
        ->editColumn('service ends', function($row) {
            $end_date = Carbon::parse($row->pivot->service_ends)->format('F j, Y');
            return '<span class="fw-bold text-dark">'.$end_date.'</span>';
        })
        
        
        ->addColumn('action', function($row) use ($user){
            $btn = '';
            if ($user->can('customer-payment-index')) {
                $btn .= '<a class="btn btn-secondary btn-sm mb-1" href="'.route('customer.payment.index',["customer_franchise"=>$row->pivot->id]).'">Payment</a> ';
            }
            if ($user->can('customer-franchise-show')) {
                $btn .= '<a class="btn btn-success btn-sm mb-1" href="'.route('customer_franchise.show',["id"=>$row->pivot->id]).'">Show</a> ';
            } 
            if ($user->can('customer-franchise-edit')) {
                $btn .=  '<button type="button" class="btn btn-warning btn-sm mb-1" id="getEditConcessionData'.$row->id.'" data-id="'.$row->id.'" onclick="callModal(event,'.$row->id.');">Concession</button> ';
                
                $btn .= '<a class="btn btn-primary btn-sm mb-1" href="'.route('customer_franchise.edit',["customer"=>$row->pivot->customer_id,"id"=>$row->pivot->id]).'"><i class="fas fa-pencil-alt"></i></a> ';
            }
            if ($user->can('customer-franchise-delete')) {
                $btn .= \Form::open(['method' => 'DELETE','route' => ['customer_franchise.destroy', $row->pivot->id],'style'=>'display:inline']) .
                \Form::button('<i class="fas fa-trash"></i>', ['type' => 'submit','class'=>'btn btn-danger btn-sm mb-1']).
                \Form::close();
                
            }
            return $btn;
        })
        ->rawColumns(['franchise','total amount','due','payment option','payment status','service starts','service ends','action'])
        ->make(true);
    }
    public function autoSeachFranchise(Request $request,$customer){
        $data = [];
        //dd($request->customer);
        $search = '';
        $franchise = '';
        if($customer){
           
            if($request->has('q')){
                $search = $request->q;
            }
          
            $model = new FranchiseService;
            $data = $model->getFranchiseByName($search,$customer);
            
        }
       
        //dd($data);
        return response()->json($data);
    }
    public function selectedFranchise(Request $request){
        $data = [];
        if($request->has('id')){
            $id = $request->id;
            $course = new FranchiseService();
            $data = $course->getFranchisePriceById($id);
        }
        //dd($request);
        return response()->json($data);
    }
    public function create(Request $request){
        $details = $this->service->getCustomerById($request->customer);
        
        return view('admin.customers.customerfranchise.create',['customer'=>$request->customer,'customer_name'=>$details->users->name,'customer_code'=>$details->center_code]);
    }
    public function store(Request $request){
        $this->validate($request, [
            'customer_id' => 'required|exists:customers,id',
            'franchise_id' => 'required|exists:franchises,id',
            'amount' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'payment_option' => ['required',Rule::in(['installment', 'full'])],
            // 'payment_status' => ['required',Rule::in(['paid', 'pending'])],
            'service_taken' => 'required|date',
            'service_ends' => 'required|date|after_or_equal:service_taken',
        ]);

       $input = $request->all();
       //dd($input);
        $input['discount'] = 0;
        $input['concession'] = 0;
        $input['due'] = $request->input('amount');
        $input['payment_status'] = 'pending';
        customer_franchise::create($input);
        return redirect()->route('customer_franchise.index',['customer'=>$request->input('customer_id')])
                        ->with('success','Franchise added successfully');
        
    }
    public function show($id){
        $data = customer_franchise::with('franchises')->findOrFail($id);
        $details = $this->service->getCustomerById($data->customer_id);
        return view('admin.customers.customerfranchise.show',['data'=>$data,'customer_name'=>$details->users->name,'customer_code'=>$details->center_code]);
    }
    public function edit(Request $request){
        $data = customer_franchise::with('franchises')->findOrFail($request->id);
        $details = $this->service->getCustomerById($request->customer);
        return view('admin.customers.customerfranchise.edit',['data'=>$data,'customer_name'=>$details->users->name,'customer_code'=>$details->center_code]);
    }
    public function update(Request $request, $id){
        $this->validate($request, [
            'franchise_id' => 'required|exists:franchises,id',
            'amount' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'payment_option' => ['required',Rule::in(['installment', 'full'])],
            // 'payment_status' => ['required',Rule::in(['paid', 'pending'])],
            'service_taken' => 'required|date',
            'service_ends' => 'required|date|after_or_equal:service_taken',
        ]);
        $input = customer_franchise::findOrFail($id);
        if($input->customerPayments()->count()==0){
            $input['franchise_id'] = $request->franchise_id;
            $input['amount'] = $request->amount;
            $input['due'] = $request->amount;
            $input['payment_option'] = $request->payment_option;
            $input['service_taken'] = $request->service_taken;
            $input['service_ends'] = $request->service_ends;
        
            $input->save();
            return redirect()->route('customer_franchise.index',['customer'=>$input->customer_id])
                            ->with('success','Franchise updated successfully');
        }
        return redirect()->route('customer_franchise.index',['customer'=>$input->customer_id])
                            ->with('warning','Sorry you cannot modify the fields');
    }
    public function editConcession($id)
    {
        $data = customer_franchise::find($id);

        $html = '
                <div class="form-group">
                    <label>Concession Amount</label>
                    <input type="text" class="form-control" name="concession" id="editConcession" value="'.$data->concession.'">
                </div>';

        return response()->json(['html'=>$html]);
    }
    public function updateConcession(Request $request, $id)
    {
        $data = customer_franchise::find($id);
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
        $data = Customer_Franchise::findOrFail($id);
        $data->customerPayments()->delete();
        $data->delete();

        return redirect('/customer_franchise')->with('success', 'Franchise successfully deleted from customer');
    }
}
