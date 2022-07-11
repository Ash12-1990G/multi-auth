<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ArtisanController extends Controller
{
    public function optimize() 
    {
        Artisan::call('optimize');
    }

    public function clear() 
    {
        Artisan::call('optimize:clear');
    }
}