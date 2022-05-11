<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer_Franchise extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'customer_id',
        'franchise_id',
        'amount',
        'discount',
        'due',
        'payment_option',
        'payment_status',
        'service_taken',
        'service_ends',
        'remarks',

    ];
}
