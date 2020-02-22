<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Model;
use App\Presenters\DatePresenter;
use App\Image;
use App\User;

class Post extends Model
{
    use DatePresenter;

    protected $fillable = [
        'user_id', 'category_id', 'name', 'slug', 'excerpt', 'body', 'status'
        ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
      return $this->hasMany(Comment::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public static function form()
    {
        return [
            'user_id'       => '',
            'category_id'   => '',
            'name'          => '',
            'slug'          => '',
            'excerpt'       => '',
            'body'          => '',
            'status'        => 'DRAFT',
            'tags'          => []
        ];
    }
}
