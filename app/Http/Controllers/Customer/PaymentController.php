<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Modules\Customer\CustomerService;
use App\Modules\Customer\Payment\CustomerPaymentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PaymentController extends Controller
{
    public function transactionWithAdmin(){
        $service =  new CustomerPaymentService();
        $data = $service->getPaymentByCustomer(auth()->user()->customers->id);
       
        
        if(request()->ajax()){
            
            return self::getDatatable($data);
        }
        
        return view('customer.transactionWithAdmin');
    }
    public function getDatatable($data){
        return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('franchise', function($row){
            return '<p class="text-primary"><span class="text-dark text-weight-bold">'.$row->customerfranchises->franchises->name.'</span><br>'.$row->customerfranchises->franchises->subname.'<br><span class="text-danger">'.$row->customerfranchises->franchises->franchise_code.'</span></p>';     
        })
        ->editColumn('paid', function($row){
            return '<i class="fas fa-rupee-sign text-success "></i> '.$row->paid;
        })
        ->editColumn('paid date', function($row){
            $date = Carbon::parse($row->p_date)->format('F j, Y');
            return '<i class="fas fa-calendar text-warning "></i> '.$date;
        })
       
        ->rawColumns(['franchise','paid','paid date'])
        ->make(true);
    }
}
