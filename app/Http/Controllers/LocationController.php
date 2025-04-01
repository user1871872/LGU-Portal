<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\Town;
use App\Models\Barangay;
use App\Models\Address;

class LocationController extends Controller
{
    public function storeAddress(Request $request)
    {
        $request->validate([
            'street' => 'required|string',
            'province' => 'required|string',
            'municipality' => 'required|string',
            'barangay' => 'required|string',
            'country' => 'required|string',
            'postal_code' => 'required|string',
        ]);

        
        $province = Province::firstOrCreate(['name' => $request->province]);

        
        $town = Town::firstOrCreate([
            'name' => $request->municipality,
            'province_id' => $province->province_id
        ]);

       
        $barangay = Barangay::firstOrCreate([
            'name' => $request->barangay,
            'town_id' => $town->town_id
        ]);

        
        $address = Address::create([
            'street' => $request->street,
            'barangay_id' => $barangay->barangay_id,
            'town_id' => $town->town_id,
            'province_id' => $province->province_id,
            'country' => $request->country,
            'postal_code' => $request->postal_code,
        ]);

        return response()->json(['success' => 'Address saved successfully', 'address' => $address]);
    }
}
