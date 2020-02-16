<?php

namespace App\Models\Data;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
	protected $fillable = [
		'grupo_material_id', 'name', 'unidad', 'precio'
	];

	public function grupo_material()
	{
		return $this->belongsTo(GrupoMaterial::class);
	}

	public function data_material()
	{
		return $this->hasOne(DataMaterial::class);
	}

	public static function form()
	{
		return [
			'grupo_material_id'	=> '',
			'name'				=> '',
			'unidad'			=> '',
			'precio'			=> ''
		];
	}
}
