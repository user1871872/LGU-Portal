<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $primaryKey = 'province_id';
    protected $fillable = ['name'];

    public function towns()
    {
        return $this->hasMany(Town::class, 'province_id');
    }
}
