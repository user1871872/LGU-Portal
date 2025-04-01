<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApplyPermit;
use App\Models\BusinessType;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\Province;
use App\Models\Town;
use App\Models\Barangay;
use Illuminate\Support\Facades\DB;
use App\Models\Address;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;




class ApplyPermitController extends Controller
{
    
    public function index()
    {
        $applications = ApplyPermit::where('user_id', Auth::id())->get();
        
        // Fetch business types from the database
        $businessTypes = BusinessType::all();
    
        // Fetch provinces from external API
        $regionCode = "0700000000";
        $response = Http::get("https://psgc.cloud/api/regions/{$regionCode}/provinces");
    
        if ($response->failed()) {
            return view('user.apply-permit', compact('applications', 'businessTypes'))
                ->with('error', 'Failed to fetch provinces');
        }
    
        $provinces = $response->json();
    
        // Pass businessTypes and provinces to the view
        return view('user.apply-permit', compact('applications', 'businessTypes', 'provinces'));
    }
    
    public function dashboardStats()
    {
        $userId = Auth::id();
    
        Log::info("User ID: " . $userId);
    
        $totalApplications = ApplyPermit::where('user_id', $userId)->count();
        $approvedApplications = ApplyPermit::where('user_id', $userId)->where('status', 'approved')->count();
        $pendingApplications = ApplyPermit::where('user_id', $userId)->where('status', 'pending')->count();
    
        // Debugging logs
        Log::info("Total Applications: " . $totalApplications);
        Log::info("Approved Applications: " . $approvedApplications);
        Log::info("Pending Applications: " . $pendingApplications);
    
        return view('user.dashboard', compact('totalApplications', 'approvedApplications', 'pendingApplications'));
    }
    
    public function adminDashboard()
    {
        $totalApplications = ApplyPermit::count();
        $pending = ApplyPermit::where('status', 'pending')->count();
        $approved = ApplyPermit::where('status', 'approved')->count();
        $rejected = ApplyPermit::where('status', 'rejected')->count();
        $revenue = ApplyPermit::where('status', 'approved')->sum('amount_paid');

        $recentApplications = ApplyPermit::latest()->limit(5)->get();

        return view('admin.dashboard', compact('totalApplications', 'pending', 'approved', 'revenue', 'recentApplications'));
    }
    public function adminIndex()
    {
    $applications = ApplyPermit::orderBy('created_at', 'desc')->paginate(10);
    return view('admin.applications', compact('applications'));
    }
    
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
            'comments' => 'nullable|string',
        ]);
    
        $application = ApplyPermit::findOrFail($id);
    
        $previousStatus = $application->status; 
    
        $application->status = $request->status;
        $application->comments = $request->comments;
        $application->save();
    
        
        Transaction::create([
            'user_id' => $application->user_id,
            'permit_id' => $application->id,
            'previous_status_id' => $previousStatus,
            'new_status_id' => $request->status,
            'comment' => $request->comments,
            'created_at' => now(),
        ]);
    
        return response()->json([
            'success' => true,
            'status' => $application->status,
            'comments' => $application->comments
        ]);
    }

    public function transactions()
    {
        $applications = ApplyPermit::where('user_id', Auth::id())
                                   ->orderBy('created_at', 'desc')
                                   ->paginate(10);
        return view('user.transactions', compact('applications'));
    }

    public function edit($id)
    {
        $application = ApplyPermit::where('id', $id)
                                  ->where('user_id', Auth::id())
                                  ->with('documents', 'address')
                                  ->firstOrFail();
    
        
        if ($application->status === 'approved') {
            return redirect()->route('user.transactions')->with('error', 'Approved applications can no longer be edited.');
        }
    
        $provinces = Province::all();
    
        
        $towns = Town::where('province_id', $application->address->province_id ?? null)->get();
        $barangays = Barangay::where('town_id', $application->address->town_id ?? null)->get();
        $documents = $application->documents()->firstOrCreate(['apply_permit_id' => $application->id]);
        
        return view('user.edit-application', compact('application', 'provinces', 'towns', 'barangays','documents'));
    }
    
    
    
    
    public function update(Request $request, $id)
    {
        
        $validatedData = $request->validate([
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'required|string',
            'business_name' => 'required|string',
            'contact_number' => 'required|string',
            'province' => 'required|string',
            'town' => 'required|string',
            'barangay' => 'required|string',
            'street' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'country' => 'nullable|string',
        ]);
    
        
        $application = ApplyPermit::where('id', $id)
                                  ->where('user_id', Auth::id())
                                  ->with('address', 'documents')
                                  ->firstOrFail();
    
       
        $application->update([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'business_name' => $request->business_name,
            'contact_number' => $request->contact_number,
            'province' => $request->province,
            'town' => $request->town,
            'barangay' => $request->barangay,
        ]);
    
        
        if ($application->address) {
            $application->address->update([
                'street' => $request->street,
                'postal_code' => $request->postal_code,
                'country' => $request->country ?? 'Philippines',
            ]);
        } else {
           
            $application->address()->create([
                'apply_permit_id' => $application->id,
                'street' => $request->street,
                'postal_code' => $request->postal_code,
                'country' => $request->country ?? 'Philippines',
            ]);
        }
    
       
        $documentFields = ['sanitary_permit', 'barangay_permit', 'dti_certificate', 'official_receipt', 'police_clearance', 'tourism_compliance_certificate'];
    
       
        $documents = $application->documents()->firstOrCreate(['apply_permit_id' => $application->id]);
    
        foreach ($documentFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $path = $file->storeAs('documents', time() . '_' . $file->getClientOriginalName(), 'public');
    
               
                if ($documents->$field && Storage::disk('public')->exists($documents->$field)) {
                    Storage::disk('public')->delete($documents->$field);
                }
    
               
                $documents->update([$field => $path]);
            }
        }
    
        return redirect()->route('user.transactions')->with('success', 'Application updated successfully!');
    }    
    
public function store(Request $request)
{ 
    Log::info('Request Data:', $request->all()); // Log incoming request data

    $request->validate([
        'first_name' => 'required|string',
        'middle_name' => 'nullable|string',
        'last_name' => 'required|string',
        'business_name' => 'required|string',
        'business_type' => 'required|exists:business_types,name',
        'province' => 'required|string',
        'town' => 'required|string',
        'barangay' => 'required|string',
        'street' => 'nullable|string',
        'country' => 'nullable|string',
        'postal_code' => 'nullable|string',
        'or_number' => 'required|string',
        'amount_paid' => 'required|numeric',
        'contact_number' => 'required|string',
        'sanitary_permit' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        'barangay_permit' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        'dti_certificate' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        'official_receipt' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        'police_clearance' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        'tourism_compliance_certificate' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
    ]);

    try {
        DB::beginTransaction();
        Log::info('Validation Passed'); // Check if validation passes Log::info('Validation Passed'); // Check if validation passes
       
        $province = Province::firstOrCreate(['name' => $request->province]);
        $town = Town::firstOrCreate(['name' => $request->town, 'province_id' => $province->province_id]);
        $barangay = Barangay::firstOrCreate(['name' => $request->barangay, 'town_id' => $town->town_id]);

       
        $application = ApplyPermit::create([
            'user_id' => Auth::id(),
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'business_name' => $request->business_name,
            'business_type_id' => BusinessType::where('name', $request->business_type)->value('id'),
            'barangay' => $request->barangay,
            'town' => $request->town,
            'province' => $request->province,
            'address_id' => null, 
            'or_number' => $request->or_number,
            'amount_paid' => $request->amount_paid,
            'contact_number' => $request->contact_number,
            'status' => 'pending',
            'comments' => null,
        ]);

        Log::info('Application Created', ['id' => $application->id]);

        $address = Address::create([
            'street' => $request->street ?? null,
            'barangay_id' => $barangay->barangay_id,
            'town_id' => $town->town_id,
            'province_id' => $province->province_id,
            'country' => $request->country ?? 'Philippines',
            'postal_code' => $request->postal_code ?? null,
            'apply_permit_id' => $application->id, 
        ]);

       
        $application->update(['address_id' => $address->id]);

    
        $documents = [
            'sanitary_permit' => null,
            'barangay_permit' => null,
            'dti_certificate' => null,
            'official_receipt' => null,
            'police_clearance' => null,
            'tourism_compliance_certificate' => null,
        ];

        foreach ($documents as $key => &$path) {
            if ($request->hasFile($key)) {
                $file = $request->file($key);
                $path = 'permits/' . time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('permits'), $path);
        
               
                $validationData = [];
        
                if (in_array($key, ['sanitary_permit'])) {
                    $validationData = [
                        'first_name'   => $request->first_name,
                        'last_name'    => $request->last_name,
                        'province'     => $request->province,
                        'municipality' => $request->municipality,
                        
                    ];
                } elseif ($key === 'official_receipt') {
                    $validationData = [
                        'or_number'  => $request->or_number,
                        // 'amount_paid' => (string) $request->amount_paid 
                    ];
                }
        
               
                if (!empty($validationData)) {
                    if (!$this->validateDocument($path, $validationData)) {
                        DB::rollBack();
                        return redirect()->back()->with('error', ucfirst(str_replace('_', ' ', $key)) . ' does not match the provided data.');
                    }
                }
            }
        }
        
        Document::create([
            'apply_permit_id' => $application->id,
            'sanitary_permit' => $documents['sanitary_permit'],
            'barangay_permit' => $documents['barangay_permit'],
            'dti_certificate' => $documents['dti_certificate'],
            'official_receipt' => $documents['official_receipt'],
            'police_clearance' => $documents['police_clearance'],
            'tourism_compliance_certificate' => $documents['tourism_compliance_certificate'],
            'file_format' => 'pdf, jpg, png',
            'max_file_size' => 2048,
        ]);

        // Store Transaction
        Transaction::create([
            'user_id' => Auth::id(),
            'permit_id' => $application->id,
            'previous_status_id' => null,
            'new_status_id' => 'pending',
            'comment' => null,
            'created_at' => now(),
        ]);

        DB::commit();
        return redirect()->back()->with('success', 'Permit application submitted successfully!');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage())->withInput();
    }
}
public function create()
{
    $businessTypes = BusinessType::all(); // Fetch all business types from the DB
    return view('user.apply-permits', compact('businessTypes'));
}

private function validateDocument($filePath, array $expectedValues)
{
    $filePath = public_path($filePath);

  
    if (!file_exists($filePath)) {
        return false;
    }

   
    $extractedText = strtolower((new TesseractOCR($filePath))->run());

    
    foreach ($expectedValues as $key => $value) {
        if (!empty($value) && !str_contains($extractedText, strtolower($value))) {
            return false; 
        }
    }

    return true; 
}

    
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