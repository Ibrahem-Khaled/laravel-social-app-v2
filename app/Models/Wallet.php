<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wallet extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'wallet_name',
        'wallet_type',
        'wallet_details',
        'password',
        'is_default',
    ];

    /**
     * The attributes that should be hidden for serialization.
     * نخفي كلمة المرور وتفاصيل المحفظة من أي تحويل إلى JSON/array.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'wallet_details', // من الأفضل إخفاؤها أيضاً por default
    ];

    /**
     * The attributes that should be cast to native types.
     * هنا يكمن سحر التشفير!
     *
     * @var array<string, string>
     */
    protected $casts = [
        'wallet_details' => 'encrypted:json', // يقوم بتشفير/فك تشفير الحقل تلقائياً وتحويله من/إلى JSON
        'is_default' => 'boolean',
    ];

    /**
     * علاقة "ينتمي إلى" لربط المحفظة بصاحبها (المستخدم).
     * A wallet belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * علاقة "لديه الكثير" لجلب طلبات السحب التي تمت على هذه المحفظة.
     * A wallet can have many withdrawal requests.
     */
    public function withdrawalRequests()
    {
        return $this->hasMany(WithdrawalRequest::class);
    }

    /**
     * Accessor & Mutator لكلمة المرور.
     * هذا يضمن أن أي كلمة مرور يتم تعيينها للمودل سيتم تجزئتها (hashing) تلقائياً قبل حفظها.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function password(): Attribute
    {
        return Attribute::make(
            // لا نحتاج إلى getter لكلمة المرور المجزأة
            set: fn(?string $value) => $value ? Hash::make($value) : null,
        );
    }
}
