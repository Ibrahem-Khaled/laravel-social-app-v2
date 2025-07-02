<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WithdrawalRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'wallet_id',
        'amount',
        'currency',
        'status',
        'rejection_reason',
        'processed_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2', // للتعامل الدقيق مع الأرقام العشرية
        'processed_at' => 'datetime', // للتعامل مع التاريخ كوحدة Carbon
    ];

    /**
     * علاقة "ينتمي إلى" لربط طلب السحب بالمستخدم الذي قام به.
     * A withdrawal request belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * علاقة "ينتمي إلى" لربط طلب السحب بالمحفظة التي سيتم السحب إليها.
     * A withdrawal request belongs to a wallet.
     */
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
