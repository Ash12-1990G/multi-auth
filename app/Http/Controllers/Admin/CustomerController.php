<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use App\Jobs\SendEmailJob;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        
        $data = Customer::with('users')->search(request(['search']))->orderBy('id','DESC')->paginate(5);
      //dd($data);
        return view('admin.customers.index',compact('data'))
        ->with('i', ($request->input('page', 1) - 1) * 5);
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
            'state.required' => 'The address field is required.',
            'city.required' => 'The city field is required.',
            'pincode.required' => 'The pincode field is required.',
            'pincode.regex' => 'The pincode format is invalid.',
            'location.required' => 'The start-up location must not be empty',
            
        ];
        $this->validate($request, [
            'name' => 'required|regex:/^[a-zA-Z]+ [a-zA-Z]+$/',
            'email' => 'required|email|unique:users,email',
            'phone' => ['regex:/^(\+)[1-9]{1}([0-9][\s]*){9,16}$/'],
            'alt_phone' => ['nullable','regex:/^(\+)[1-9]{1}([0-9][\s]*){9,16}$/'],
            'address'=> 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'pincode' => ['required','regex:/^^\d{4}$|^\d{6}$/'],
            'location'=> 'required|string',
        ], $messages);

        //geolocation API

        $response = GeoLocationController::getGeocodeFromAPI($request->input('location'));

        if($response==null){
            return redirect()->back()->with('warning', 'No internet access. Try again')->withInput();
        }
        if(isset($response->geocoding->errors)){
            return redirect()->back()->with('warning', 'Start-up location length must be greater than zero')->withInput();
        }
        if(isset($response->geocoding->warnings) || count($response->features)==0){
            return redirect()->back()->with('warning', 'Start-up location not found')->withInput();

        }
        $longitude = $response->features[0]->geometry->coordinates[0];
        $latitude = $response->features[0]->geometry->coordinates[1];

        $address_count = GeoLocationController::checkIfAddressWithin($latitude,$longitude);
        if($address_count>0){
            return redirect()->back()->with('warning', "Unfortunately, the start-up location is within 10 kilometers of another customer's location.")->withInput();
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
        $customer['phone'] = $request->input('phone');
        $customer['alt_phone'] = $request->input('alt_phone');
        $customer['address'] = $request->input('address');
        $customer['state'] = $request->input('state');
        $customer['city'] = $request->input('city');
        $customer['pincode'] = $request->input('pincode');
        $customer['location'] = $request->input('location');
        $customer['latitude'] = $latitude;
        $customer['longitude'] = $longitude;

        $cust = Customer::create($customer);
        //dispatching to job credential mails

        dispatch(new SendEmailJob($mailData));
        //dispatching to verify email to queue
        $user->sendEmailVerificationNotification();
        
      
        
        
        return redirect()->route('customers.index')
                        ->with('success','Customer created successfully');
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
            'state.required' => 'The address field is required.',
            'city.required' => 'The city field is required.',
            'pincode.required' => 'The pincode field is required.',
            'pincode.regex' => 'The pincode format is invalid.',
            'location.required' => 'The start-up location must not be empty',
            
        ];
        $this->validate($request, [
            'name' => 'required|regex:/^[a-zA-Z]+ [a-zA-Z]+$/',
            'email' => 'required|email|unique:users,email,'.$customer->user_id,
            'phone' => ['regex:/^(\+)[1-9]{1}([0-9][\s]*){9,16}$/'],
            'alt_phone' => ['nullable','regex:/^(\+)[1-9]{1}([0-9][\s]*){9,16}$/'],
            'address'=> 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'pincode' => ['required','regex:/^^\d{4}$|^\d{6}$/'],
            'location'=> 'required|string',
        ], $messages);
        
            //geolocation API
        

        $response = GeoLocationController::getGeocodeFromAPI($request->input('location'));

        if($response==null){
            return redirect()->back()->with('warning', 'No internet access. Try again')->withInput();
        }
        if(isset($response->geocoding->errors)){
            return redirect()->back()->with('warning', 'Start-up location length must be greater than zero')->withInput();
        }
        if(isset($response->geocoding->warnings) || count($response->features)==0){
            return redirect()->back()->with('warning', 'Start-up location not found')->withInput();

        }
        
        $longitude = $response->features[0]->geometry->coordinates[0];
        $latitude = $response->features[0]->geometry->coordinates[1];

        $address_count = GeoLocationController::checkIfAddressWithin($latitude,$longitude);
        if($address_count>0){
            return redirect()->back()->with('warning', "Unfortunately, the start-up location is within 10 kilometers of another customer's location.")->withInput();
        }
        
        //Geolocatio API

        
        $input['name'] = $request->input('name');
        $input['email'] = $request->input('email');
        $customer['phone'] = $request->input('phone');
        $customer['alt_phone'] = $request->input('alt_phone');
        $customer['address'] = $request->input('address');
        $customer['state'] = $request->input('state');
        $customer['city'] = $request->input('city');
        $customer['pincode'] = $request->input('pincode');
        $customer['location'] = $request->input('location');
        $customer['latitude'] = $latitude;
        $customer['longitude'] = $longitude;
               
        $customer->update();
        $customer->users()->update($input);
        return redirect()->route('customers.index')
                        ->with('success','Customer updated successfully');
    }
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->users()->delete();
        $customer->delete();
        return redirect('/customers')->with('success', 'Customer successfully deleted');
    }
}