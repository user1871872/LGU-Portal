<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplyPermit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','first_name', 'middle_name', 'last_name',
        'business_name', 'line_of_business', 'business_address',
        'or_number', 'amount_paid', 'contact_number',
        'sanitary_permit', 'barangay_permit'
    ];
}
