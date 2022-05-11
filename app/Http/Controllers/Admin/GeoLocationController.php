<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeoLocationController extends Controller
{
    const EARTHS_RADIUS_KM = 6371.01;//earth radius
	const DISTANCE_KM = 10;
	// public function index(){
	// 	return view('admin.location.getcoordinate');
	// }
	public static function checkIfAddressWithin($latitude,$longitude,$edit_id){
		$radius = self::EARTHS_RADIUS_KM;
		$distance_km = self::DISTANCE_KM;
		$customer          =       DB::table("customers");
		
			$customer          =       $customer->select("*", DB::raw($radius." * acos(cos(radians(" . $latitude . "))
		* cos(radians(latitude)) * cos(radians(longitude) - radians(" . $longitude . "))
		+ sin(radians(" .$latitude. ")) * sin(radians(latitude))) AS distance"));
		if($edit_id!==0){
			$customer          =       $customer->where('id', '<>', $edit_id);
		}
		
		$customer          =       $customer->having('distance', '<=', $distance_km);
		$customer          =       $customer->orderBy('distance', 'asc');
		
		$customer          =       $customer->count();
		return $customer;
	}
	public static function getGeocodeFromAPI($location) {
		$key = config('services.geocodeapi.key');
		//dd($key);
		$srch = [
			"text" => $location,
			"size" => 1,
		 ];
		$url = 'https://app.geocodeapi.io/api/v1/search?'.http_build_query($srch);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
	    curl_setopt($ch, CURLOPT_URL,$url);
	    
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			"Content-Type: application/json",
			"apikey: ".$key,
		));
		$response = curl_exec($ch);
		curl_close($ch);

		$json = json_decode($response);
		
		return $json;
		
	    
	}
	
	
}
