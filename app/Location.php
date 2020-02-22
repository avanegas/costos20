<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\Presenters\DatePresenter;

class Location extends Model
{
    use DatePresenter;

    protected $fillable = [
        'profile_id', 'country',
    ];

    public function location()
    {
        return $this->belongsTo(Profile::class);
    }
}
