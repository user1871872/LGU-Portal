<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplyPermit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','first_name', 'middle_name', 'last_name',
        'business_name', 'line_of_business','business_type_id', 'province',
        'town','barangay','or_number', 'amount_paid', 'contact_number',
        'status','comments'
    ];
    
    public function documents()
    {
        return $this->hasMany(Document::class, 'apply_permit_id','id');
    }
    public function user()
    {
    return $this->belongsTo(User::class, 'user_id');
    }
    public function address()
    {
        return $this->hasOne(Address::class, 'apply_permit_id');
    }
    public function certificate()
    {
        return $this->hasOne(PkCertificate::class, 'permit_id');
    }
    public function businessType()
    {
        return $this->belongsTo(BusinessType::class, 'business_type_id');
    }

}
