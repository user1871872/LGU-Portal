<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $primaryKey = 'document_id';
    protected $fillable = [
        'apply_permit_id', 'sanitary_permit', 'barangay_permit',
        'dti_certificate', 'official_receipt', 'police_clearance', 'tourism_compliance_certificate'
    ];

    public function applyPermit()
    {
        return $this->belongsTo(ApplyPermit::class, 'apply_permit_id');
    }
}
