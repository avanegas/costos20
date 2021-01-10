<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Indirecto extends Model
{
    protected $fillable = [
        'arriendo', 'seguros', 'financiamiento', 'total_indirectos', 'utilidades', 'otros', 'proyecto_id',
    ];
}
