<?php

namespace App\Modules\Customer\Payment;

use App\Models\Customer;
use App\Models\Customer_Franchise;
use App\Models\CustomerPayment;
use App\Models\Franchise;

class CustomerPaymentService
{
    public $model;
    public function __construct()
    {
        $this->model = new CustomerPayment();
    }
    public function getPaymentByCustFranchise($id){
        return $this->model->where('customer_franchise_id',$id)->get();
    }
    public function getPaidByCustFranchise($id){
        return $this->model->where('customer_franchise_id',$id)->sum('paid');
    }
    
    public function deleteById($id){
        return $this->model->findOrFail($id);
    }
    public function storePayment($input){
        return $this->model->create($input);
    }
    public function getPaymentById($id){
        return $this->model->findOrFail($id);
    }
    public function getPaymentByCustomer($id){
        return $this->model->with('customerfranchises:id,franchise_id,customer_id')->whereHas('customerfranchises',function($q) use ($id){
            $q->where('customer_id',$id);
        })->get();
    }
    
    
    
}