<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFamliy extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'famliy_id',
        'role',
        'status',
        'joined_at',
        'left_at',
    ];

    // العلاقة مع المستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // العلاقة مع العائلة
    public function family()
    {
        return $this->belongsTo(Famliy::class, 'famliy_id');
    }
}
