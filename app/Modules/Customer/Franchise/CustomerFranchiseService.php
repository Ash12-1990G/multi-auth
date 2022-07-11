<?php

namespace App\Modules\Customer\Franchise;

use App\Models\Customer_Franchise;
use App\Models\Franchise;

class CustomerFranchiseService
{
    public $model;
    public function __construct()
    {
        $this->model = new Customer_Franchise();
    }
    public function getCustomersFranchise($id){
        return $this->model->where('customer_id',$id)->pluck('franchise_id');
    }
    public function getCustomersTotalFranchise($id){
        return $this->model->where('customer_id',$id)->count();
    }
    
    public function updateById($data,$id){
        $serviceCls = $this->model->find($id);
        return $serviceCls->update($data);
    }
    public function getCfById($id){
        return $this->model->with(['customers'=>function($q){
            $q->with('users:id,name');
        }])->with(['franchises'=>function($q){
            $q->select('id','name','franchise_code');
        }])->findOrFail($id);
    }
    public function getAttributeValues($cf){
        return $this->model->find($cf);
    }

}