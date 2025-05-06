<?php

namespace src\Models;

class Tesis extends BaseModel
{
    /**
     * Los atributos que deberían ser asignados en masa.
     *
     * @var array
     */
    protected $fillable = [
        'bibliografia_id',
        'carrera_id'
    ];

    /**
     * Obtener la bibliografía declarada asociada.
     */
    public function bibliografia()
    {
        return $this->belongsTo(BibliografiaDeclarada::class, 'bibliografia_id');
    }

    /**
     * Obtener la carrera asociada.
     */
    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }
} 