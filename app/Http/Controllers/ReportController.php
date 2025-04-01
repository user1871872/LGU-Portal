<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PkCertificate;
use App\Models\ApplyPermit;

class ReportController extends Controller
{
    
    public function index()
    {
        return view('admin.reports', ['certificates' => []]);
    }

    
    public function generate(Request $request)
    {
       
        $request->validate([
            'report_type' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        
        $certificates = PkCertificate::whereBetween('issued_at', [$request->start_date, $request->end_date])
            ->with('permit') 
            ->get();

        if ($certificates->isEmpty()) {
            return redirect()->back()->with('error', 'No records found for the selected date range.');
        }

        return view('admin.reports', compact('certificates'));
    }
}
