<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use App\Jobs\SendEmailJob;
use App\Modules\Customer\CustomerService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:customer-list', ['only' => ['index','getDatatable']]);
        $this->middleware('permission:customer-show', ['only' => ['show']]);
        $this->middleware('permission:customer-add', ['only' => ['create','store']]);
        $this->middleware('permission:customer-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:customer-delete', ['only' => ['destroy']]);
    }
    public function checkLocationRadius(Request $request){
        $address_count = GeoLocationController::checkIfAddressWithin($request->input('latitude'),$request->input('longitude'),0);
        //return response()->json(['status'=>'success','message' => $address_count]); 
        if($address_count>0){
           return response()->json(['status'=>'error','message' => "Unfortunately, the start-up location is within 10 kilometers of another customer's location."]);  
        }
        else{
            return response()->json(['status'=>'success','message' => "This start-up location is not within 10 kilometers of another customer's location."]);  
        }
    }
    public function index(Request $request)
    {
       
        
        if(request()->ajax()){
            return self::getDatatable();
        };
        return view('admin.customers.index');
    }
    public function getDatatable(){
        $data = Customer::with('users')->orderBy('id','ASC')->get();
        $user = auth()->user();
        return DataTables::of($data)
        ->addIndexColumn()
        ->editColumn('institute', function($row) {
            return '<p class="text-primary" ><span class="text-dark text-weight-bold">'.$row->center_code.'</span> '.$row->users->name.'</p>';
        })
        ->editColumn('owner', function($row) {
            return $row->users->name;
        })
        
        ->editColumn('email', function($row){
            return '<i class="fas fa-envelope text-primary "></i> '.$row->users->email;
        })
        ->editColumn('phone', function($row){
            return '<i class="fas fa-phone text-danger"></i> '.$row->phone.' '.$row->alt_phone;
        })
        ->editColumn('discount(in %)', function($row){
            return '<span class="text-danger font-weight-bold"> '.$row->cost.'</span>';
        })
        ->addColumn('action', function($row) use ($user){
            $btn = '';
                if ($user->can('customer-show')) {
                    $btn .= '<a class="btn btn-success btn-sm mb-1" href="'.route('customers.show',$row->id).'">Show</a> ';
                } 
                if ($user->can('customer-franchise-list')) {
                $btn .= '<a class="btn btn-info btn-sm mb-1" href="'.route('customer_franchise.index',['customer'=>$row->id]).'">Franchise</a> ';
                }
                if ($user->can('customer-edit')) {
                    $btn .= '<a class="btn btn-primary btn-sm mb-1" href="'.route('customers.edit',$row->id).'"><i class="fas fa-pencil-alt"></i></a> ';
                } 
                if ($user->can('customer-delete')) {
                    $btn .= \Form::open(['method' => 'DELETE','route' => ['customers.destroy', $row->id],'style'=>'display:inline']) .
                    \Form::button('<i class="fas fa-trash"></i>', ['type' => 'submit','class'=>'btn btn-danger btn-sm mb-1']).
                    \Form::close();
                    
                } 
            return $btn;
        })
        ->rawColumns(['institute','owner','email','phone','action'])
        ->make(true);
    }
    public function create(){
       
        return view('admin.customers.create');
    }
    public function show($id){
        $customer = Customer::with('users')->find($id);
        //dd($student);
        return view('admin.customers.show',compact('customer'));
    }
    public function store(Request $request)
    {
        
        $messages = [
            'address.required' => 'The address field is required.',
            'cust_name.required' => 'The customer name is required.',
            'cust_name.regex' => 'Invalid name',
            'state.required' => 'The address field is required.',
            'city.required' => 'The city field is required.',
            'pincode.required' => 'The pincode field is required.',
            'pincode.regex' => 'The pincode format is invalid.',
            'location.required' => 'The start-up location must not be empty',
            
        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'cust_name' => 'required|regex:/^[a-zA-Z]+ [a-zA-Z]+$/',
            'email' => 'required|email|unique:users,email',
            'phone' => ['regex:/^(\+)[1-9]{1}([0-9][\s]*){9,16}$/'],
            'alt_phone' => ['nullable','regex:/^(\+)[1-9]{1}([0-9][\s]*){9,16}$/'],
            'address'=> 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'pincode' => ['required','regex:/^^\d{4}$|^\d{6}$/'],
            'location'=> 'required|string',
        ], $messages);
        if ($validator->fails()){
            return response()->json(['errors'=>$validator->errors()]);
        }
        //geolocation API
        
        if($request->input('latitude')=='' || $request->input('longitude')==''){
            //return response()->json(['warning'=> 'Start-up location not found']);
            $validator->after(function ($validator) {
                if ($this->somethingElseIsInvalid()) {
                    $validator->errors()->add(
                        'location', 'Start-up location not found'
                    );
                }
            });

        }
        
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        // $response = GeoLocationController::getGeocodeFromAPI($request->input('location'));

        // if($response==null){
        //     return redirect()->back()->with('warning', 'No internet access. Try again')->withInput();
        // }
        // if(isset($response->geocoding->errors)){
        //     return redirect()->back()->with('warning', 'Start-up location length must be greater than zero')->withInput();
        // }
        // if(count($response->features)==0){
        //     return redirect()->back()->with('warning', 'Start-up location not found')->withInput();

        // }
        // $longitude = $response->features[0]->geometry->coordinates[0];
        // $latitude = $response->features[0]->geometry->coordinates[1];

        $address_count = GeoLocationController::checkIfAddressWithin($latitude,$longitude,0);
        if($address_count>0){
            //return response()->json(['warning'=> "Unfortunately, the start-up location is within 10 kilometers of another customer's location."]);
            $validator->after(function ($validator) {
                if ($this->somethingElseIsInvalid()) {
                    $validator->errors()->add(
                        'location', "Unfortunately, the start-up location is within 10 kilometers of another customer's location"
                    );
                }
            });
        }
        
        
        //Geolocatio API
        //random password generation
        $random = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!$%^&!$%^&');
        $password = substr($random, 0, 10);
        //random password generation
        $input['name'] = $request->input('name');
        $input['email'] = $request->input('email');
        $input['password'] = Hash::make($password);

        $mailData = [
            'name' => $input['name'],
            'type' => 'customer',
            'email' => $input['email'],
            'password' => $password
        ];
        //insert in user table
        $user = User::create($input);
        //assign role
        $user->assignRole('Franchise-Admin');
        $customer['user_id'] = $user->id;
        $customer['cust_name'] = $request->input('cust_name');
        $customer['phone'] = $request->input('phone');
        $customer['alt_phone'] = $request->input('alt_phone');
        $customer['address'] = $request->input('address');
        $customer['state'] = $request->input('state');
        $customer['city'] = $request->input('city');
        $customer['pincode'] = $request->input('pincode');
        $customer['location'] = $request->input('location');
        $customer['latitude'] = $latitude;
        $customer['longitude'] = $longitude;
        $customer['center_code'] = '';
        $cust = Customer::create($customer);
        
        $cust['center_code'] =  '0650'. str_pad($cust->id, 1, '0', STR_PAD_LEFT);
        
        $cust->save();
        //dispatching to job credential mails

        dispatch(new SendEmailJob($mailData));
        //dispatching to verify email to queue
        $user->sendEmailVerificationNotification();
        return response()->json(['success'=>'Customer created successfully']);
        //return redirect()->route('customers.index')->with('success','Customer created successfully');
    }
    public function edit($id){
        $customer = Customer::findOrFail($id);
        //dd($user->user->phone);
        return view('admin.customers.edit',compact('customer'));
    }
    public function update(Request $request, $id){
        $customer = Customer::find($id);
        $messages = [
            'address.required' => 'The address field is required.',
            'cust_name.required' => 'The customer name is required.',
            'cust_name.regex' => 'Invalid name',
            'state.required' => 'The address field is required.',
            'city.required' => 'The city field is required.',
            'pincode.required' => 'The pincode field is required.',
            'pincode.regex' => 'The pincode format is invalid.',
            'location.required' => 'The start-up location must not be empty',
            
        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'cust_name' => ['required','regex:/^([a-zA-Z0-9]+|[a-zA-Z0-9]+\s{1}[a-zA-Z0-9]{1,}|[a-zA-Z0-9]+\s{1}[a-zA-Z0-9]{3,}\s{1}[a-zA-Z0-9]{1,})$/'],
            'email' => 'required|email|unique:users,email,'.$customer->user_id,
            'phone' => ['regex:/^(\+)[1-9]{1}([0-9][\s]*){9,16}$/'],
            'alt_phone' => ['nullable','regex:/^(\+)[1-9]{1}([0-9][\s]*){9,16}$/'],
            'address'=> 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'pincode' => ['required','regex:/^^\d{4}$|^\d{6}$/'],
            'location'=> 'required|string',
        ], $messages);
        
        if ($validator->fails()){
            return response()->json(['errors'=>$validator->errors()]);
        }
        //geolocation API
        
        if($request->input('latitude')=='' || $request->input('longitude')==''){
            //return response()->json(['warning'=> 'Start-up location not found']);
            $validator->after(function ($validator) {
                if ($this->somethingElseIsInvalid()) {
                    $validator->errors()->add(
                        'location', 'Start-up location not found'
                    );
                }
            });

        }
        
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        
        // $response = GeoLocationController::getGeocodeFromAPI($request->input('location'));
     
        // if($response==null){
        //     return redirect()->back()->with('warning', 'No internet access. Try again')->withInput();
        // }
        // if(isset($response->geocoding->errors)){
        //     return redirect()->back()->with('warning', 'Start-up location length must be greater than zero')->withInput();
        // }
        // if( count($response->features)==0){
        //     return redirect()->back()->with('warning', 'Start-up location not found')->withInput();

        // }
        
        // $longitude = $response->features[0]->geometry->coordinates[0];
        // $latitude = $response->features[0]->geometry->coordinates[1];

        $address_count = GeoLocationController::checkIfAddressWithin($latitude,$longitude,$id);
        if($address_count>0){
            //return response()->json(['warning'=> "Unfortunately, the start-up location is within 10 kilometers of another customer's location."]);
            $validator->after(function ($validator) {
                if ($this->somethingElseIsInvalid()) {
                    $validator->errors()->add(
                        'location', "Unfortunately, the start-up location is within 10 kilometers of another customer's location"
                    );
                }
            });
        }
        
        //Geolocatio API

        
        $input['name'] = $request->input('name');
        $input['email'] = $request->input('email');
        $customer['phone'] = $request->input('phone');
        $customer['cust_name'] = $request->input('cust_name');
        $customer['alt_phone'] = $request->input('alt_phone');
        $customer['address'] = $request->input('address');
        $customer['state'] = $request->input('state');
        $customer['city'] = $request->input('city');
        $customer['pincode'] = $request->input('pincode');
        $customer['location'] = $request->input('location');
        $customer['latitude'] = $latitude;
        $customer['longitude'] = $longitude;
       // $customer['center_code'] =  '0650'. str_pad($customer->id, 1, '0', STR_PAD_LEFT);
        $customer->update();
        $customer->users()->update($input);
        return response()->json(['success'=>'Customer updated successfully']);
    }
    
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        if($customer->franchises()->count()==0){
            $customer->users()->removeRole('Franchise-Admin');
            $customer->users()->delete();
            $customer->students()->users()->delete();
            $customer->students()->delete();
            $customer->delete();
            return redirect('/customers')->with('success', 'Customer successfully deleted');
        }
        return redirect('/customers')->with('warning', 'Customer can not be deleted');
        
    }
}