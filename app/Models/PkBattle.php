<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PkBattle extends Model
{
    use HasFactory;

    /**
     * الحقول التي يمكن تعبئتها بشكل جماعي (Mass Assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'live_streaming_id',
        'host_one_id',
        'host_two_id',
        'host_one_score',
        'host_two_score',
        'winner_id',
        'status',
        'started_at',
        'ends_at',
    ];

    /**
     * تحويل أنواع البيانات للحقول المحددة.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'started_at' => 'datetime',
        'ends_at' => 'datetime',
        'host_one_score' => 'integer',
        'host_two_score' => 'integer',
    ];

    /**
     * علاقة: الجولة تنتمي إلى بث مباشر واحد.
     *
     * @return BelongsTo
     */
    public function liveStreaming(): BelongsTo
    {
        return $this->belongsTo(LiveStreaming::class, 'live_streaming_id');
    }

    /**
     * علاقة: المذيع الأول (المتحدي).
     *
     * @return BelongsTo
     */
    public function hostOne(): BelongsTo
    {
        return $this->belongsTo(User::class, 'host_one_id');
    }

    /**
     * علاقة: المذيع الثاني (الخصم).
     *
     * @return BelongsTo
     */
    public function hostTwo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'host_two_id');
    }

    /**
     * علاقة: الفائز في الجولة.
     *
     * @return BelongsTo
     */
    public function winner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'winner_id');
    }
}
