<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class FeatureSection extends Model
{
    protected $fillable = [
        'slug',
        'title_before_highlight',
        'highlighted_title',
        'title_after_highlight',
        'description',
        'button_text',
        'button_url',
        'image_path',
        'image_alt',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(FeatureItem::class);
    }
}
