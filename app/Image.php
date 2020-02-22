<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\Presenters\DatePresenter;

class Image extends Model
{
    use DatePresenter;

    protected $fillable = [
        'url',
    ];
    public function imageable()
    {
        return $this->morphTo();
    }
}
