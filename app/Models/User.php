<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\UserAccessors;
use App\Traits\UserRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, UserRelationships, UserAccessors;
    protected static function booted()
    {
        static::creating(function ($user) {
            $user->uuid = random_int(1000000000, 9999999999);
        });
    }
    protected $appends = [
        'avatar_url',
        'user_followers_count',
        'user_following_count',
        'user_posts_count',
        'user_gifts_count',
        'questions_count',
        'is_current_user',
        'is_authanticated_user_following_this_user',
        'is_authanticated_user_blocked_this_user',
        'verification_request',
        'current_level',
    ];
    protected $guarded = ['id'];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'birth_date' => 'date',
        'social_links' => 'array',
        'settings' => 'array',
        'is_verified' => 'boolean',
    ];

    public function getUserAvatarAttribute()
    {
        // إذا كانت قيمة avatar موجودة تُبنى باستخدام asset() مع مجلد storage
        return $this->avatar ? asset(env('APP_URL') . '/storage/' . $this->avatar)
            : ($this->gender == 'male' ? asset(env('APP_URL') . '/assets/img/avatar-male2.png')
                : asset(env('APP_URL') . '/assets/img/avatar-female2.png'));
    }

    public function addCoins($amount)
    {
        $this->increment('coins', $amount);
    }

    public function subtractCoins($amount)
    {
        $this->decrement('coins', $amount);
    }

    public function scopeGender($query, $gender)
    {
        return $query->where('gender', $gender);
    }

    public function scopeCountry($query, $country)
    {
        return $query->where('country', $country);
    }

    public function getRoleNameAttribute()
    {
        $roles = [
            'admin' => 'مدير',
            'moderator' => 'مشرف',
            'user' => 'مستخدم عادي',
            'vip' => 'مستخدم مميز',
            'website-data' => 'بيانات الموقع'
        ];

        return $roles[$this->role] ?? $this->role;
    }

    public function getStatusNameAttribute()
    {
        $statuses = [
            'active' => 'نشط',
            'inactive' => 'غير نشط',
            'banned' => 'محظور'
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    public function getGenderNameAttribute()
    {
        $genders = [
            'male' => 'ذكر',
            'female' => 'أنثى'
        ];

        return $genders[$this->gender] ?? 'غير محدد';
    }


    //this method is used to get the identifier that will be stored in the subject claim of the JWT
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
