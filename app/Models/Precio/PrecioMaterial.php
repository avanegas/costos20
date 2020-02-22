<?php

namespace App\Models\Precio;

use Illuminate\Database\Eloquent\Model;
use \App\Presenters\DatePresenter;

class PrecioMaterial extends Model
{
    use DatePresenter;

	protected $fillable = [
		'material_id', 'name', 'unidad', 'precio', 'cantidad', 'total'
	];

	public $timestamps = false;

	public function precio()
	{
		return $this->belongsTo(Precio::class);
	}

	public function material()
	{
		return $this->belongsTo(Material::class);
	}

	public static function form()
	{
		return [
			'material_id' 	=> '',
			'name' 			=> '',
			'unidad' 		=> '',
			'precio' 		=> 0,
			'cantidad' 		=> 0,
			'total' 		=> 0
		];
	}
}
