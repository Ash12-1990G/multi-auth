<?php

namespace App\Modules\Customer;

use App\Models\Customer;

class CustomerService
{
    public $model;
    public function __construct()
    {
        $this->model = new Customer;
    }
    public function getCustomerById($id){
       
        return $this->model->with('users:id,name')->findOrFail($id);
    }
    public function sumCustomerAmount($id){
        return $this->model->withSum('franchises as total','customer_franchise.amount')->find($id);
    }
    public function sumCustomerDue($id){
        return $this->model->withSum('franchises as totaldue','customer_franchise.due')->find($id);
    }
    public function getCustomerByUserId($id){
       
        return $this->model->where('user_id',$id)->without('franchises','students')->first();
    }
    public function getCustomerByName($name){
       
        return $this->model->with('users:id,name')->whereHas('users',function($q) use ($name){
            $q->where('name','LIKE',"%$name%")->orderBy('name');
        })->get();
    }
  
    public function getCustomerFranchise($id){
        return $this->model;
    }
    
}