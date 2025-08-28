<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
class Attachment extends Model
{
    use HasUlids, SoftDeletes;

    protected $fillable = [
        'disk',
        'path',
        'original_name',
        'mime',
        'size',
        'meta',
        'uploaded_by'
    ];

    protected $casts = [
        'size' => 'integer',
        'meta' => 'array',
    ];

    public function attachable(): MorphTo
    {
        return $this->morphTo();
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
