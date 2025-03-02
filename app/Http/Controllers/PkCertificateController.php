<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PkCertificate;
use App\Models\ApplyPermit;
use Illuminate\Support\Facades\Storage;

class PkCertificateController extends Controller
{
    // Display the business permits
    public function index()
    {
        $certificates = PkCertificate::with('permit')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.certificate', compact('certificates'));

    }

    // Show form to generate a new business permit
    public function create()
    {
        $permits = ApplyPermit::all(); // Fetch permits
        return view('admin.pk-certificates.create', compact('permits'));
    }

    // Store the generated business permit
    public function store(Request $request)
    {
        $request->validate([
            'permit_id' => 'required|exists:apply_permits,id',
            'issued_at' => 'required|date',
            'file' => 'required|file|mimes:pdf|max:2048',
        ]);

        // Store file
        $filePath = $request->file('file')->store('certificates', 'public');

        // Save to database
        PkCertificate::create([
            'permit_id' => $request->permit_id,
            'issued_at' => $request->issued_at,
            'file_path' => $filePath,
        ]);

        return redirect()->route('pk-certificates.index')->with('success', 'Business permit generated successfully.');
    }

    // Show the generated certificate
    public function show($id)
    {
        $certificate = PkCertificate::with('permit')->findOrFail($id);
        return view('admin.pk-certificates.show', compact('certificate'));
    }

    // Delete a certificate
    public function destroy($id)
    {
        $certificate = PkCertificate::findOrFail($id);

        // Delete file from storage
        Storage::disk('public')->delete($certificate->file_path);

        // Delete record
        $certificate->delete();

        return redirect()->route('pk-certificates.index')->with('success', 'Certificate deleted successfully.');
    }
}
