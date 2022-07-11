<?php

namespace App\Modules\Franchise;

use App\Models\Customer_Franchise;
use App\Models\Franchise;

class FranchiseService
{
    public $model;
    public function __construct()
    {
        $this->model = new Franchise();
    }
    public function getFranchisePriceById($id){
        return $this->model->select('id','cost')->find($id);
    }
    public function getFranchiseByName($name,$customer){
        
       $arr = Customer_Franchise::where('customer_id',$customer)->pluck('franchise_id');
       $cn = $this->model;
       if($name!=''){
        $cn = $cn->where('name','LIKE',"%$name%")->orWhere('franchise_code','LIKE',"%$name%");
       }
       $cn = $cn->whereNotIn('id',$arr)->get();
       
       
       return $cn;
    }
    
}