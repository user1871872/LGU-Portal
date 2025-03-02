<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    use HasFactory;

    protected $primaryKey = 'barangay_id';
    protected $fillable = ['name', 'town_id'];

    public function town()
    {
        return $this->belongsTo(Town::class, 'town_id');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'barangay_id');
    }
}
