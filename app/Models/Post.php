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
        // 1. البحث عن رابط يوتيوب في المحتوى
        if ($this->content && preg_match('/(youtube\.com|youtu\.be)\/(watch\?v=|embed\/|v\/|)([\w-]{11})/', $this->content, $matches)) {
            $youtubeId = $matches[3];
            // إرجاع رابط الصورة المصغرة عالية الجودة من يوتيوب
            return "https://img.youtube.com/vi/{$youtubeId}/hqdefault.jpg";
        }

        // 2. إذا لم يكن هناك يوتيوب، تحقق من وجود صور مرفقة بالمنشور
        if (!empty($this->images) && isset($this->images[0])) {
            return asset('storage/' . $this->images[0]);
        }

        // 3. إذا لم يوجد أي مما سبق، استخدم الصورة الافتراضية للموقع
        // يتم جلب بيانات الموقع مرة واحدة وتخزينها مؤقتاً (caching) لتحسين الأداء
        $websiteData = Cache::remember('website_data', 60, function () {
            return \App\Models\User::where('role', 'website')->first(); // تأكد من أن هذا هو اسم النموذج الصحيح لبيانات موقعك
        });

        return $websiteData ? asset('storage/' . $websiteData->avatar) : asset('images/default-post.png'); // fallback إضافي
    }
}
