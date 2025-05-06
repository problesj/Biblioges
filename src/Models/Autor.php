<?php

namespace src\Models;

class Autor extends BaseModel
{
    /**
     * Los atributos que deberían ser asignados en masa.
     *
     * @var array
     */
    protected $fillable = [
        'apellidos',
        'nombres',
        'genero'
    ];

    /**
     * Obtener las bibliografías del autor.
     */
    public function bibliografias()
    {
        return $this->belongsToMany(BibliografiaDeclarada::class, 'bibliografias_autores')
            ->withTimestamps();
    }
} 