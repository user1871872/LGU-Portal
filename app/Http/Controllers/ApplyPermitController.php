<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApplyPermit;
use Illuminate\Support\Facades\Auth;
use thiagoalessio\TesseractOCR\TesseractOCR; // Import TesseractOCR
use Illuminate\Support\Facades\Log;

class ApplyPermitController extends Controller
{
    public function index()
    {
        $applications = ApplyPermit::where('user_id', Auth::id())->get();
        return view('user.apply-permit', compact('applications'));
    }

    public function dashboardStats()
    {
        $userId = Auth::id(); // Get logged-in user ID
    
        Log::info("User ID: " . $userId); // Debug
    
        $totalApplications = ApplyPermit::where('user_id', $userId)->count();
        $approvedApplications = ApplyPermit::where('user_id', $userId)->where('status', 'approved')->count();
        $pendingApplications = ApplyPermit::where('user_id', $userId)->where('status', 'pending')->count();
    
        // Debugging logs
        Log::info("Total Applications: " . $totalApplications);
        Log::info("Approved Applications: " . $approvedApplications);
        Log::info("Pending Applications: " . $pendingApplications);
    
        return view('user.dashboard', compact('totalApplications', 'approvedApplications', 'pendingApplications'));
    }
    

    public function adminIndex()
    {
    $applications = ApplyPermit::orderBy('created_at', 'desc')->paginate(10);
    return view('admin.applications', compact('applications'));
    }
    
    public function updateStatus(Request $request, $id)
    {
        // Validate request
        $request->validate([
            'status' => 'required|string',
            'comments' => 'nullable|string',
        ]);
    
        // Find application 
        $application = ApplyPermit::findOrFail($id);
    
        // Update fields
        $application->status = $request->status;
        $application->comments = $request->comments;
        $application->save();
    
        // Return JSON response
        return response()->json(['success' => true, 'status' => $application->status, 'comments' => $application->comments]);
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
                                  ->firstOrFail();

        return view('user.edit-application', compact('application'));
    }

    public function update(Request $request, $id)
    {
        $application = ApplyPermit::where('id', $id)
                                  ->where('user_id', Auth::id())
                                  ->firstOrFail();
    
        $request->validate([
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'required|string',
            'business_name' => 'required|string',
            'line_of_business' => 'required|string',
            'business_address' => 'required|string',
            'or_number' => 'required|string',
            'amount_paid' => 'required|numeric',
            'contact_number' => 'required|string',
            'sanitary_permit' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'barangay_permit' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);
    
        // Handle sanitary permit file upload and replace old file
        if ($request->hasFile('sanitary_permit')) {
            // Delete old file if exists
            if ($application->sanitary_permit && file_exists(public_path($application->sanitary_permit))) {
                unlink(public_path($application->sanitary_permit));
            }
    
            $sanitaryFile = $request->file('sanitary_permit');
            $sanitaryPath = 'permits/' . time() . '_' . $sanitaryFile->getClientOriginalName();
            $sanitaryFile->move(public_path('permits'), $sanitaryPath);
    
            $application->sanitary_permit = $sanitaryPath;
        }
    
        // Handle barangay permit file upload and replace old file
        if ($request->hasFile('barangay_permit')) {
            // Delete old file if exists
            if ($application->barangay_permit && file_exists(public_path($application->barangay_permit))) {
                unlink(public_path($application->barangay_permit));
            }
    
            $barangayFile = $request->file('barangay_permit');
            $barangayPath = 'permits/' . time() . '_' . $barangayFile->getClientOriginalName();
            $barangayFile->move(public_path('permits'), $barangayPath);
    
            $application->barangay_permit = $barangayPath;
        }
    
        // Update other application details
        $application->update($request->only([
            'first_name', 'middle_name', 'last_name', 'business_name',
            'line_of_business', 'business_address', 'or_number', 'amount_paid', 'contact_number'
        ]));
    
        return redirect()->route('user.transactions')->with('success', 'Application updated successfully!');
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'required|string',
            'business_name' => 'required|string',
            'line_of_business' => 'required|string',
            'business_address' => 'required|string',
            'or_number' => 'required|string',
            'amount_paid' => 'required|numeric',
            'contact_number' => 'required|string',
            'sanitary_permit' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'barangay_permit' => 'nullable|file|mimes:pdf,jpg,png|max:2048'
        ]);

        $sanitaryPath = null;
        $barangayPath = null;
        
        if ($request->hasFile('sanitary_permit')) {
            $sanitaryFile = $request->file('sanitary_permit');
            $sanitaryPath = 'permits/' . time() . '_' . $sanitaryFile->getClientOriginalName();
            $sanitaryFile->move(public_path('permits'), $sanitaryPath);
            
            // Perform text extraction and validation
            if (!$this->validateDocument($sanitaryPath, $request->first_name, $request->middle_name, $request->last_name)) {
                return redirect()->back()->with('error', 'Sanitary permit does not match the provided names.');
            }
        }
        
        if ($request->hasFile('barangay_permit')) {
            $barangayFile = $request->file('barangay_permit');
            $barangayPath = 'permits/' . time() . '_' . $barangayFile->getClientOriginalName();
            $barangayFile->move(public_path('permits'), $barangayPath);
            
            // Perform text extraction and validation
            if (!$this->validateDocument($barangayPath, $request->first_name, $request->middle_name, $request->last_name)) {
                return redirect()->back()->with('error', 'Barangay permit does not match the provided names.');
            }
        }
        
        ApplyPermit::create([
            'user_id' => Auth::id(),
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'business_name' => $request->business_name,
            'line_of_business' => $request->line_of_business,
            'business_address' => $request->business_address,
            'or_number' => $request->or_number,
            'amount_paid' => $request->amount_paid,
            'contact_number' => $request->contact_number,
            'sanitary_permit' => $sanitaryPath,
            'barangay_permit' => $barangayPath,
            'status' => 'pending', // Default status
            'comments' => null
        ]);

        return redirect()->back()->with('success', 'Permit application submitted successfully!');
    }

    private function validateDocument($filePath, $firstName, $middleName, $lastName)
    {
        $extractedText = (new TesseractOCR(public_path($filePath)))
            ->run(); // Extract text from image

        $extractedText = strtolower($extractedText);
        $firstName = strtolower($firstName);
        $middleName = strtolower($middleName);
        $lastName = strtolower($lastName);

        return str_contains($extractedText, $firstName) &&
               str_contains($extractedText, $middleName) &&
               str_contains($extractedText, $lastName);
    }
    
}