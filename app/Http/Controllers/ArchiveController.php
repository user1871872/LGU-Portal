<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApplyPermit;
use App\Models\PkCertificate;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ArchiveController extends Controller
{
    public function index(Request $request)
    {
        $businessName = $request->input('business_name');
    
        
        $applyPermits = ApplyPermit::query();
    
        
        $issuedPermits = PkCertificate::query()
            ->join('apply_permits', 'pk_certificates.permit_id', '=', 'apply_permits.id')
            ->select('pk_certificates.*', 'apply_permits.business_name'); // Include business_name
    
       
        if ($businessName) {
            $applyPermits->where('business_name', 'LIKE', "%$businessName%");
            $issuedPermits->where('apply_permits.business_name', 'LIKE', "%$businessName%");
        }
    
       
        $applyPermits = $applyPermits->get();
        $issuedPermits = $issuedPermits->get();
    
       
        $allPermits = $applyPermits->merge($issuedPermits);
    
        
        $allPermits = $allPermits->sortByDesc('created_at');
    
       
        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $allPermits->slice(($currentPage - 1) * $perPage, $perPage)->values();
    
        $paginatedPermits = new LengthAwarePaginator(
            $currentItems,
            $allPermits->count(),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );
    
        return view('admin.archive', compact('paginatedPermits'));
    }
    
    
    
}
