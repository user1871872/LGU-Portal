<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PSGCController extends Controller
{
    public function fetchLocations()
    {
       
        $regionCode = "0700000000";
        $response = Http::get("https://psgc.cloud/api/regions/{$regionCode}/provinces");
    
        if ($response->failed()) {
            return response()->json(['error' => 'Failed to fetch provinces'], 500);
        }
    
        $provinces = $response->json();
    
        return view('user.locations', compact('provinces'));
    }
    
    public function getMunicipalities(Request $request)
    {
        if (!$request->has('province_code')) {
            return response()->json(['error' => 'Province code is required'], 400);
        }
    
        $provinceCode = $request->province_code;
    
        try {
            $response = Http::get("https://psgc.cloud/api/provinces/{$provinceCode}/municipalities");
    
            if ($response->failed()) {
                return response()->json(['error' => 'Failed to fetch municipalities'], 500);
            }
    
            return response()->json($response->json()); 
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    public function getBarangays(Request $request)
    {
        if (!$request->has('municipality_code')) {
            return response()->json(['error' => 'Municipality code is required'], 400);
        }
    
        $municipalityCode = $request->municipality_code;
    
        try {
            $response = Http::get("https://psgc.cloud/api/municipalities/{$municipalityCode}/barangays");
    
            if ($response->failed()) {
                return response()->json(['error' => 'Failed to fetch barangays'], 500);
            }
    
            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }
    
}

