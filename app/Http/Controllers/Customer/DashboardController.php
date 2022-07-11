<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Modules\Customer\CustomerService;
use App\Modules\Customer\Franchise\CustomerFranchiseService;
use App\Modules\Student\StudentService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $franchise;
    protected $student;
    protected $service;

    public function __construct()
    {
        $this->service = new CustomerService();
        $this->franchise = new CustomerFranchiseService();
        $this->student = new StudentService();
       
    }
    public function index(){
        $customer = $this->service->getCustomerByUserId(Auth()->user()->id);
        $totalFranchise = $this->franchise->getCustomersTotalFranchise($customer->id);
        $totalStudent = $this->student->getTotalStudentByCenter($customer->id);
        $studentTotal = $this->student->sumStudentAmount($customer->id)->sum('total');
        $studentDue = $this->student->sumStudentDue($customer->id)->sum('totaldue');
        $customerTotal = $this->service->sumCustomerAmount($customer->id);
        
        $customerDue = $this->service->sumCustomerDue($customer->id);
       
        return view('customer.dashboard',['totalFranchise'=>$totalFranchise,'totalStudent'=>$totalStudent,'studentTotal'=>$studentTotal,'studentDue'=>$studentDue,'customerTotal'=>$customerTotal,'customerDue'=>$customerDue]);
    }
}
