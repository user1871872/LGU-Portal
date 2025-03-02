<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PkCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'permit_id',
        'issued_at',
        'file_path',
    ];

    public function businessPermit()
    {
        return $this->belongsTo(ApplyPermit::class, 'permit_id');
    }
}
