<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Franchise extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'franchise_code',
        'subname',
        'details',
        'cost',
        'discount',
        'service_period',
        'service_interval',
        'image',
    ];
    // public function scopeSearch($query, array $filters){
    //     $query->when($filters['q'] ?? false,function($query,$search){
    //         $query
    //             ->where('name','like','%'.$search.'%')
    //             ->orWhere('franchise_code','like','%'.$search.'%');

    //     });
    // }
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
