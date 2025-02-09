<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApplyPermit;
use Illuminate\Support\Facades\Auth;

class ApplyPermitController extends Controller
{
    public function index()
    {
        $applications = ApplyPermit::where('user_id', Auth::id())->get();
        return view('user.apply-permit', compact('applications'));
    }

    public function adminIndex()
    {
    $applications = ApplyPermit::orderBy('created_at', 'desc')->paginate(10);
    return view('admin.applications', compact('applications'));
    }
    
    public function updateStatus(Request $request, $id)
    {
    $application = ApplyPermit::findOrFail($id);
    $application->status = $request->status;
    $application->save();

    return response()->json(['success' => true]);
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

        // Update application details
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

        $sanitaryPath = $request->file('sanitary_permit') 
            ? $request->file('sanitary_permit')->store('permits', 'public') 
            : null;

        $barangayPath = $request->file('barangay_permit') 
            ? $request->file('barangay_permit')->store('permits', 'public') 
            : null;

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
        ]);

        return redirect()->back()->with('success', 'Permit application submitted successfully!');
    }
}
