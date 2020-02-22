<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\Presenters\DatePresenter;

class Profile extends Model
{
    use DatePresenter;

    protected $fillable = [
        'user_id', 'bio', 'phone', 'twitter_username', 'github_username', 'avatar_status', 'status', 'activated',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function location()
    {
        return $this->hasOne(Location::class);
    }
}
