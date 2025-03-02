<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Town extends Model
{
    use HasFactory;

    protected $primaryKey = 'town_id';
    protected $fillable = ['name', 'province_id'];

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function barangays()
    {
        return $this->hasMany(Barangay::class, 'town_id');
    }
}
