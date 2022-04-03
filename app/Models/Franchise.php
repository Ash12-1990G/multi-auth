<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Franchise extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'subname',
        'details',
        'cost',
        'discount',
        'service_period',
        'service_interval',
        'image',
    ];
    public function scopeSearch($query, array $filters){
        $query->when($filters['search'] ?? false,function($query,$search){
            $query
                ->where('name','like','%'.$search.'%');
        });
    }
}
