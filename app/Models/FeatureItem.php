<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeatureItem extends Model
{
    protected $fillable = [
        'feature_section_id',
        'text',
    ];

    public function featureSection(): BelongsTo
    {
        return $this->belongsTo(FeatureSection::class, 'feature_section_id');
    }
}
