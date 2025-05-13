<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $appends = ['comment_count', 'like_count', 'is_liked'];
    protected $casts = [
        'images' => 'array',
    ];

    protected $fillable = [
        'user_id',
        'message_id',
        'content',
        'images',
        'pinned',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'name', 'avatar');
    }

    public function message()
    {
        return $this->belongsTo(Message::class, 'message_id');
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class);
    }

    public function likes()
    {
        return $this->hasMany(PostLike::class);
    }

    public function reports()
    {
        return $this->hasMany(ReportPost::class);
    }


    //this accessor functions
    public function getCommentCountAttribute()
    {
        return $this->comments()->count();
    }

    public function getLikeCountAttribute()
    {
        return $this->likes()->count();
    }

    public function getIsLikedAttribute()
    {
        $user = auth()->guard('api')->user();
        if ($user) {
            return $this->likes()->where('user_id', $user->id)->exists();
        }
        return false;
    }
}
