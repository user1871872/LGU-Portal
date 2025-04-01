<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $primaryKey = 'address_id';

   
    protected $fillable = ['street', 'barangay_id', 'town_id', 'province_id', 'country', 'postal_code', 'apply_permit_id'];

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id');
    }

    public function town()
    {
        return $this->belongsTo(Town::class, 'town_id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function permit()
    {
        return $this->belongsTo(ApplyPermit::class, 'apply_permit_id');
    }
}
