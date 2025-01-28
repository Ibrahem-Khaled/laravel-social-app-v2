<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Famliy extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'image',
    ];

    // العلاقة مع المستخدم الذي أنشأ العائلة
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // العلاقة مع المستخدمين المرتبطين بالعائلة
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_famliys', 'famliy_id', 'user_id')
            ->withPivot('id', 'role', 'status', 'joined_at', 'left_at');
    }
}
