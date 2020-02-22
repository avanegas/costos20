<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\Presenters\DatePresenter;
use App\Models\Data\GrupoEquipo;
use App\Models\Data\GrupoMaterial;
use App\Models\Data\GrupoObrero;
use App\Models\Data\GrupoPrecio;
use App\Models\Data\Transporte;

class Zona extends Model
{
  use DatePresenter;

  protected $fillable = [
    'name', 'description', 'user_id'
  ];

  public function user()
  {
      return $this->belongsTo(User::class);
  }

    public function general()
    {
        return $this->belongsTo(General::class);
    }

  public function grupo_equipos()
  {
      return $this->hasMany(GrupoEquipo::class);
  }

  public function grupo_materials()
  {
      return $this->hasMany(GrupoMaterial::class);
  }

  public function grupo_obreros()
  {
      return $this->hasMany(GrupoObrero::class);
  }

  public function transportes()
  {
      return $this->hasMany(Transporte::class);
  }

  public function grupo_precios()
  {
      return $this->hasMany(GrupoPrecio::class);
  }

  public static function form()
  {
  	  return [
        'name'         => '',
    	  'description'  => '',
    	  'user_id'      => ''
   	  ];
  }
}
