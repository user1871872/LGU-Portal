<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_name',
        'description',
        'is_mandatory',
        'file_format',
        'max_file_size',
    ];

    public function applyPermits()
    {
        return $this->belongsToMany(ApplyPermit::class, 'apply_permit_documents', 'document_id', 'apply_permit_id')
            ->withTimestamps();
    }
}
