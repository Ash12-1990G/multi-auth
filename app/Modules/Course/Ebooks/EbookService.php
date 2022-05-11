<?php
namespace App\Modules\Course\Ebooks;

use App\Models\Ebook;
use Illuminate\Support\Facades\File;

class EbookService
{

    public $model;
    //public $modelClass = Student::class;

    public function __construct()
    {
        $this->model = new Ebook;
    }
    
    public function getBookByCourse($id){
        return $this->model->where('course_id',$id)->paginate(1);
    }
    public function ebookDownload($file_name)
    {
        $pathToFile = storage_path('app/ebooks/' . $file_name);
        if(File::exists($pathToFile)){
           // $fileName = $book->title.'.pdf';
            $headers = ['Content-Type: application/pdf'];
            return response()->download($pathToFile);
        }
        return response()->with('fail','File do not exist.');      
       
        
    }
    
    
   
}