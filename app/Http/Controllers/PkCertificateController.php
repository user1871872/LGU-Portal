<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PkCertificate;
use App\Models\ApplyPermit;
use Barryvdh\DomPDF\Facade\Pdf;

class PkCertificateController extends Controller
{
    // Display all generated certificates
    public function index()
    {
        $certificates = PkCertificate::with('permit')->orderBy('created_at', 'desc')->paginate(10);
        $permits = ApplyPermit::all(); // Fetch all permits
        return view('admin.certificate', compact('certificates', 'permits'));
    }

    // Show form to generate a new business permit
    public function create()
    {
        $permits = ApplyPermit::all(); // Fetch all permits
        return view('admin.generate-permit', compact('permits')); // Ensure this file exists
    }

    // Generate PDF and return to browser
    public function generatePDF($permitId)
    {
        $permit = ApplyPermit::findOrFail($permitId);

        $pdf = Pdf::loadView('pdf.business_permit', compact('permit'))
            ->setPaper('A4', 'portrait'); // Ensures proper layout

        return $pdf->stream('Business_Permit.pdf'); // Stream directly to browser
    }

    // Store certificate in the default public folder
    public function store(Request $request)
    {
        $request->validate([
            'permit_id' => 'required|exists:apply_permits,id',
        ]);
    
        $permit = ApplyPermit::findOrFail($request->permit_id);
    
        // Define directory and filename
        $directory = public_path('certificates');
        $fileName = 'business_permit_' . $permit->id . '_' . time() . '.pdf';
        $filePath = $directory . '/' . $fileName;
    
        // 🔥 Ensure the directory exists
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true); // Create directory with full permissions
        }
    
        // Generate PDF and save it in `public/certificates/`
        $pdf = Pdf::loadView('pdf.business_permit', compact('permit'));
        file_put_contents($filePath, $pdf->output()); // Save the file
    
        // Save to database (relative path)
        PkCertificate::create([
            'permit_id' => $request->permit_id,
            'issued_at' => now(),
            'file_path' => 'certificates/' . $fileName, // Store relative path
        ]);
    
        return redirect()->route('pk-certificates.index')->with('success', 'Business permit generated successfully.');
    }
    

    // Show a specific certificate
    public function show($id)
    {
        $certificate = PkCertificate::with('permit')->findOrFail($id);
        return view('admin.certificates.show', compact('certificate'));
    }

    // Delete a certificate and its file
    public function destroy($id)
    {
        $certificate = PkCertificate::findOrFail($id);
        $fullPath = public_path($certificate->file_path); // Get full path in `public/certificates/`

        // Delete the file from `public/certificates/`
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }

        // Delete the record
        $certificate->delete();

        return redirect()->route('pk-certificates.index')->with('success', 'Certificate deleted successfully.');
    }
}
