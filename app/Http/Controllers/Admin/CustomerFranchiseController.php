<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer_Franchise;
use App\Models\Franchise;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerFranchiseController extends Controller
{
    public function index(Request $request){
        $data = Customer_Franchise::orderBy('id','DESC')->paginate(5);
      //dd($data);
        return view('admin.customer_franchise.index',compact('data'))
        ->with('i', ($request->input('page', 1) - 1) * 5);

    }
    public function create(){
        return view('admin.customer_franchise.create');
    }
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'slug' => 'required|unique:courses,slug',
            'description' => 'required|string',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'meta_title' => 'required|string',
            'meta_description' => 'required|string',
        ]);

        $course['name'] = $request->input('name');
        $course['slug'] = $request->input('slug');
        $course['description'] = $request->input('description');
        $course['price'] = $request->input('price');
        $course['meta_title'] = $request->input('meta_title');
        $course['meta_description'] = $request->input('meta_description');

        customer_franchise::create($course);
        return redirect()->route('custfranchise.index')
                        ->with('success','Course created successfully');
        
    }
    public function edit($id){
        $course = customer_franchise::findOrFail($id);
        //dd($user->user->phone);
        return view('admin.customer_franchise.edit',compact('course'));
    }
    public function update(Request $request, $id){
        $this->validate($request, [
            'customer_id' => 'required',
            'franchise_id' => 'required|unique:courses,slug,'.$id,
            'payment_option' => ['required'|Rule::in(['installment', 'full'])],
            'service_taken' => 'required|date',
            'service_ends' => 'required|date',
        ]);
        $others_available = customer_franchise::where('customer_id',$request->input('customer_id'))->where('customer_id',$request->input('franchise_id'))->where('id','<>',$id)->count();
        if($others_available > 0){
            return redirect()->route('custfranchise.index')
                        ->with('warning','The furchise has already purchased by the customer ');
        }
        $input = customer_franchise::find($id);
        $fanchise = Franchise::find($request->input('franchise_id'));
        $input['customer_id'] = $request->input('customer_id');
        $input['franchise_id'] = $request->input('franchise_id');
        $input['amount'] = $fanchise->amount;
        $input['discount'] = $fanchise->discount;
        $input['due'] = $fanchise->amount;
        $input['payment_status'] = 'pending';
        $input['service_taken'] = $request->input('service_taken');
        $input['service_ends'] = $request->input('service_taken');

        $input->update();
             return redirect()->route('custfranchise.index')
                        ->with('success','Course updated successfully');
    }
    public function destroy($id)
    {
        $data = Customer_Franchise::findOrFail($id);
        $data->delete();

        return redirect('/customer_franchise')->with('success', 'Franchise successfully deleted from customer');
    }
}
