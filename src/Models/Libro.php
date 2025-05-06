<?php

namespace src\Models;

class Libro extends BaseModel
{
    /**
     * Los atributos que deberían ser asignados en masa.
     *
     * @var array
     */
    protected $fillable = [
        'bibliografia_id',
        'isbn'
    ];

    /**
     * Obtener la bibliografía declarada asociada.
     */
    public function bibliografia()
    {
        return $this->belongsTo(BibliografiaDeclarada::class, 'bibliografia_id');
    }
} 