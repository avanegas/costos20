<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \App\Presenters\DatePresenter;

class Country extends Model
{
    use DatePresenter;

    protected $fillable = [
        'name', 'moneda', 'simbolo'
    ];

    public static function form()
    {
        return [
            'name'      => '',
            'moneda'    => '',
            'simbolo'   => ''
        ];
    }
}
