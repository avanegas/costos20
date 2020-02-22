<?php

namespace App\Models\Precio;

use Illuminate\Database\Eloquent\Model;
use \App\Presenters\DatePresenter;

class PrecioObrero extends Model
{
    use DatePresenter;

	protected $fillable = [
		'obrero_id', 'name', 'jornalhora', 'cantidad', 'rendimiento', 'total'
	];

	public $timestamps = false;

	public function precio()
	{
		return $this->belongsTo(Precio::class);
	}

	public function obrero()
	{
		return $this->belongsTo(Obrero::class);
	}

	public static function form()
	{
		return [
			'obrero_id' 	=> '',
			'name' 			=> '',
			'jornalhora' 	=> 0,
			'cantidad' 		=> 0,
			'rendimiento' 	=> 0,
			'total' 		=> 0
		];
	}
}
