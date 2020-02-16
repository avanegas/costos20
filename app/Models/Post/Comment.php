<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Model;
use App\Image;
use App\User;

class Comment extends Model
{
    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
