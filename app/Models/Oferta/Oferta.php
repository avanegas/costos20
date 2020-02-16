<?php

namespace App\Models\Oferta;

use Illuminate\Database\Eloquent\Model;

use App\User;

class Oferta extends Model
{
    protected $fillable = [
        'user_id', 'name', 'unidad', 'descripcion', 'stock', 'precio', 'file', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function form()
    {
      return [
      	'user_id'		=> '',
        'name'      	=> '',
        'unidad'     	=> '',
        'descripcion'  	=> '',
        'stock'     	=> '',
        'precio'		=> '',
        'file'			=> '',
        'status'		=> 'DRAFT'
      ];
    }
}
