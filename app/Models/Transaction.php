<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'permit_id',
        'previous_status_id',
        'new_status_id',
        'comment',
        'created_at'
    ];
}
