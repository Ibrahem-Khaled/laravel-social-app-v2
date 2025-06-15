<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{

    protected $fillable = [
        'level_number',
        'name',
        'color',
        'icon',
        'points_required',
        'is_active',
        'description'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'points_required' => 'integer',
        'level_number' => 'integer'
    ];
}
