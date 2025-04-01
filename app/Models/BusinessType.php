<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessType extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function applyPermits()
    {
        return $this->hasMany(ApplyPermit::class, 'business_type_id');
    }
}
