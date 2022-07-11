<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Franchise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AutocompleteController extends Controller
{
    public function selectFranchise(Request $request){
        $data = [];
       
        if($request->has('q')){
            $search = $request->q;
            $data = Franchise::select(DB::raw("CONCAT(franchises.name,' - ',franchises.franchise_code) as display_name,id"))
      
            		->where('name', 'LIKE', "%$search%")
                    ->orWhere('franchise_code', 'LIKE', "%$search%")
            		->get();
            
        }
        if($request->has('editval') && $request->has('editval')!=''){
            $editval = $search = $request->editval;
        }
        
        
        return response()->json($data);
        
    }
}
