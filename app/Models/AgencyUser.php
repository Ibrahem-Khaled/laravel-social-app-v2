<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencyUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'agency_id',
        'user_id',
        'role',
        'status',
    ];
}
