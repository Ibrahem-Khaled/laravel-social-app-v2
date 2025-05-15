<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hashtag extends Model
{
    protected $fillable = ['name', 'usage_count'];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'hashtag_posts', 'hashtag_id', 'post_id');
    }
}
