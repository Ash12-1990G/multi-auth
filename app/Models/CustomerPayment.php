<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPayment extends Model
{
    use HasFactory;
    protected $table = 'customer_payments';
    protected $fillable = [
        'customer_franchise_id',
        'paid',
        'p_date',
        'remarks',
    ];
  
    public function customerfranchises()
    {
        return $this->belongsTo(Customer_Franchise::class,'customer_franchise_id');
    }
}
