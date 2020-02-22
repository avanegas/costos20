<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\Presenters\DatePresenter;

class Group extends Model
{
    use DatePresenter;

    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
