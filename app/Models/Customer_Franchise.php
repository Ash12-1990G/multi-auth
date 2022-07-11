<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer_Franchise extends Model
{
    use HasFactory;
    protected $table = 'customer_franchise';
    protected $fillable = [
        'customer_id',
        'franchise_id',
        'amount',
        'discount',
        'concession',
        'due',
        'payment_option',
        'payment_status',
        'service_taken',
        'service_ends',
        'remarks',

    ];
    public function franchises()
    {
        return $this->belongsTo(Franchise::class,'franchise_id');
    }
    public function Customers()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }
    public function customerPayments()
    {
        return $this->hasMany(CustomerPayment::class);
    }
}
