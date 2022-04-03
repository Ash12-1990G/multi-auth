<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ebook extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_id',
        'title',
        'author',
        'bookpath',
        'coverpath',
    ];
    public function courses()
    {
        return $this->belongsTo(Course::class,'course_id');
    }
}
