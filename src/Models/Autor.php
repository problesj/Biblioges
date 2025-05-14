<?php

namespace src\Models;

class Autor extends BaseModel
{
    /**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'autores';

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
        return $this->belongsToMany(BibliografiaDeclarada::class, 'bibliografias_autores', 'autor_id', 'bibliografia_id')
            ->withTimestamps('fecha_creacion', 'fecha_actualizacion');
    }
} 