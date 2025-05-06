<?php

namespace src\Models;

class SitioWeb extends BaseModel
{
    /**
     * Los atributos que deberían ser asignados en masa.
     *
     * @var array
     */
    protected $fillable = [
        'bibliografia_id',
        'fecha_consulta'
    ];

    /**
     * Los atributos que deberían ser convertidos a tipos nativos.
     *
     * @var array
     */
    protected $casts = [
        'fecha_consulta' => 'date'
    ];

    /**
     * Obtener la bibliografía declarada asociada.
     */
    public function bibliografia()
    {
        return $this->belongsTo(BibliografiaDeclarada::class, 'bibliografia_id');
    }
} 