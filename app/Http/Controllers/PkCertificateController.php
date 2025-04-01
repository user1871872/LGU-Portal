<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PkCertificate;
use App\Models\ApplyPermit;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Notifications\PermitGeneratedNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\User;

class PkCertificateController extends Controller
{
    public function index()
    {
        $certificates = PkCertificate::with('permit')
            ->orderBy('created_at', 'desc')
            ->paginate(10); 
    
        $permits = ApplyPermit::with('businessType') // Load the business type relation
            ->where('status', 'approved')
            ->whereDoesntHave('certificate')
            ->get();
    
        return view('admin.certificate', compact('certificates', 'permits'));
    }
    
    
    public function create()
    {
        $permits = ApplyPermit::all();
        return view('admin.generate-permit', compact('permits'));
    }

    public function generatePDF()
    {
        
        set_time_limit(300);
        ini_set('memory_limit', '512M');

        
        $permit = ApplyPermit::find(1); 

        
        $pdf = PDF::loadView('pdf.business_permit', compact('permit'))
                  ->setPaper('A4', 'portrait'); 

        
        return $pdf->download('business_permit.pdf');
    }

    public function store(Request $request)
    {
        $request->validate([
            'permit_id' => 'required|exists:apply_permits,id',
        ]);
    
        $permit = ApplyPermit::findOrFail($request->permit_id);
    
        $directory = public_path('certificates');
        $fileName = 'business_permit_' . $permit->id . '_' . time() . '.pdf';
        $filePath = $directory . '/' . $fileName;
    
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
    
        // Generate PDF
        $pdf = Pdf::loadView('pdf.business_permit', compact('permit'));
        file_put_contents($filePath, $pdf->output());
    
        // Store in database
        $certificate = PkCertificate::create([
            'permit_id' => $request->permit_id,
            'issued_at' => now(),
            'file_path' => 'certificates/' . $fileName,
        ]);
    
        
        $user = $permit->user; 
        if ($user) {
            $user->notify(new PermitGeneratedNotification($certificate));
        }
    
        return redirect()->route('pk-certificates.index')->with('success', 'Business permit generated successfully.');
    }
    
    public function show($id)
    {
        $certificate = PkCertificate::with('permit')->findOrFail($id);
        return view('admin.certificates.show', compact('certificate'));
    }

    // public function destroy($id)
    // {
    //     $certificate = PkCertificate::findOrFail($id);
    //     $fullPath = public_path($certificate->file_path); 

 
    //     if (file_exists($fullPath)) {
    //         unlink($fullPath);
    //     }

    //     $certificate->delete();

    //     return redirect()->route('pk-certificates.index')->with('success', 'Certificate deleted successfully.');
    // }
}
