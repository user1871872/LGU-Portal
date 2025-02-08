<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApplyPermit;

class ApplyPermitController extends Controller
{
    public function index()
    {
        $applications = ApplyPermit::all();
        return view('user.apply-permit', compact('applications'));
    }

    public function transactions()
    {
    $applications = ApplyPermit::orderBy('created_at', 'desc')->paginate(10);
    return view('user.transactions', compact('applications'));
    }

    public function edit($id)
    {
    $application = ApplyPermit::findOrFail($id); // Fetch the application by ID
    return view('user.edit-application', compact('application'));
    }
    public function update(Request $request, $id)
    {
        $application = ApplyPermit::findOrFail($id);
    
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
            'sanitary_permit' => 'nullable|file|mimes:pdf,jpg,png',
            'barangay_permit' => 'nullable|file|mimes:pdf,jpg,png',
        ]);
    
        // Handle file uploads
        if ($request->hasFile('sanitary_permit')) {
            $sanitaryPath = $request->file('sanitary_permit')->store('permits', 'public');
            $application->sanitary_permit = $sanitaryPath;
        }
    
        if ($request->hasFile('barangay_permit')) {
            $barangayPath = $request->file('barangay_permit')->store('permits', 'public');
            $application->barangay_permit = $barangayPath;
        }
    
        // Update the application details
        $application->update([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'business_name' => $request->business_name,
            'line_of_business' => $request->line_of_business,
            'business_address' => $request->business_address,
            'or_number' => $request->or_number,
            'amount_paid' => $request->amount_paid,
            'contact_number' => $request->contact_number,
        ]);
    
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
    
        $sanitaryPath = $request->file('sanitary_permit') 
            ? $request->file('sanitary_permit')->store('permits', 'public') 
            : null;
    
        $barangayPath = $request->file('barangay_permit') 
            ? $request->file('barangay_permit')->store('permits', 'public') 
            : null;
    
        ApplyPermit::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'business_name' => $request->business_name,
            'line_of_business' => $request->line_of_business,
            'business_address' => $request->business_address,
            'or_number' => $request->or_number,
            'amount_paid' => $request->amount_paid,
            'contact_number' => $request->contact_number,
            'sanitary_permit' => $sanitaryPath, // ✅ Store file path
            'barangay_permit' => $barangayPath, // ✅ Store file path
        ]);
    
        return redirect()->back()->with('success', 'Permit application submitted successfully!');
    }
    
}
