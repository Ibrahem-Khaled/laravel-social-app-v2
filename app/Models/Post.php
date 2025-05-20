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
        return $this->belongsTo(Message::class, 'message_id', 'id');
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
        return $this->hasMany(Report::class);
    }

    public function hashtags()
    {
        return $this->belongsToMany(Hashtag::class, 'hashtag_posts', 'post_id', 'hashtag_id');
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


    //this booted methods 
    // استخراج الهاشتاجات وربطها تلقائياً بعد إنشاء أو تحديث المنشور
    protected static function booted()
    {
        static::created(function ($post) {
            $post->syncHashtags();
        });

        static::updated(function ($post) {
            $post->syncHashtags();
        });
    }

    // هذه الدالة تقوم باستخراج وربط الهاشتاجات وتجنب التكرار
    public function syncHashtags()
    {
        preg_match_all('/#(\w+)/u', $this->content, $matches);
        $hashtagNames = array_map('strtolower', $matches[1]);

        $hashtagIds = collect($hashtagNames)->map(function ($tag) {
            $hashtag = Hashtag::firstOrCreate(['name' => $tag]);
            $hashtag->increment('usage_count');
            return $hashtag->id;
        })->unique(); // ضمان عدم التكرار

        $this->hashtags()->sync($hashtagIds);
    }
}
