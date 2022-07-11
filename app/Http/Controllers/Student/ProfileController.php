<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Modules\Student\StudentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class ProfileController extends Controller
{
    protected $model;
    public function __construct()
    {
        $this->model = new StudentService();
    }
    public function index(Request $request){
        $data = $this->model->getStudentId(Auth::id());
        
        return view('student.profile',
            ['data' => $data]
        );
    }
    public function downloadId()
    {
        $model = new StudentService();
        $data = $model->getStudentId(auth()->user()->id);
        if($data->image!=null){
            $pdf = PDF::loadView('student.id-card-view', compact('data'));
            $pdf->setPaper('A4', '');
            $filename = $data->users->name. '.pdf';
            return $pdf->stream($filename);
        }
        return redirect()->back()->with('warning','Sorry! you can not download the IDCARD');
        
      
    }
    
}
