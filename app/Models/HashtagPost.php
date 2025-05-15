<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HashtagPost extends Model
{
    protected $fillable = [
        'hashtag_id',
        'post_id',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function hashtag()
    {
        return $this->belongsTo(Hashtag::class);
    }
}
