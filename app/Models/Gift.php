<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_gifts', 'gift_id', 'user_id')
            ->withPivot('sender_id', 'quantity');
    }
}
