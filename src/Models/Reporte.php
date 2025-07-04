<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    protected $table = 'reportes';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'descripcion',
        'fecha_creacion',
        'fecha_actualizacion',
    ];
} 