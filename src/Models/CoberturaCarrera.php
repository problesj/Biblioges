<?php

namespace src\Models;

use Illuminate\Database\Eloquent\Model;

class CoberturaCarrera extends Model
{
    protected $table = 'coberturas_carreras';
    
    protected $fillable = [
        'carrera_id',
        'codigo_carrera',
        'nombre_carrera',
        'sede',
        'cobertura_basica',
        'cobertura_complementaria',
        'fecha_calculo',
        'total_bibliografias_declaradas',
        'total_bibliografias_disponibles_declaradas',
        'total_bibliografias_disponibles'
    ];

    protected $casts = [
        'fecha_calculo' => 'datetime',
        'cobertura_basica' => 'decimal:2',
        'cobertura_complementaria' => 'decimal:2'
    ];

    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }
} 