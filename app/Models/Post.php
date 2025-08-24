<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Post extends Model
{
    use HasFactory;

    protected $appends = ['comment_count', 'like_count', 'is_liked', 'given_coins'];
    protected $casts = [
        'images' => 'array',
    ];

    protected $fillable = [
        'user_id',
        'message_id',
        'content',
        'images',
        'video',
        'type',
        'pinned',
        'status',
    ];


    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'name', 'avatar', 'is_verified');
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
        return $this->morphMany(Report::class, 'related');
    }

    public function hashtags()
    {
        return $this->belongsToMany(Hashtag::class, 'hashtag_posts', 'post_id', 'hashtag_id');
    }

    public function userSentCoins()
    {
        return $this->belongsToMany(User::class, 'user_post_coins', 'post_id', 'user_id')
            ->withPivot('amount')
            ->withTimestamps();
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

    public function getGivenCoinsAttribute()
    {
        return $this->userSentCoins()->sum('amount');
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




    public function getThumbnailUrlAttribute(): string
    {
        // 1. Check for a YouTube link in the content
        if ($this->content && preg_match('/(youtube\.com|youtu\.be)\/(watch\?v=|embed\/|v\/|)([\w-]{11})/', $this->content, $matches)) {
            return "https://img.youtube.com/vi/{$matches[3]}/hqdefault.jpg";
        }

        // 2. Check for attached images (now safely)
        $images = $this->images; // Access the casted attribute

        // Check if $images is a valid, non-empty array and its first element is a string
        if (is_array($images) && !empty($images) && is_string($images[0])) {
            return asset('storage/' . $images[0]);
        }

        // 3. Fallback to the website's default avatar
        $websiteData = Cache::remember('website_data', now()->addMinutes(60), function () {
            // Make sure you have a WebsiteData model or similar
            return \App\Models\User::where('role', 'website')->first();
        });

        if ($websiteData && $websiteData->avatar) {
            return asset('storage/' . $websiteData->avatar);
        }

        // Final fallback image if nothing else is found
        return asset('images/default-post-placeholder.png');
    }
}
