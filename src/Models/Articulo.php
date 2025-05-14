<?php

namespace src\Models;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    protected $table = 'articulos';

    /**
     * Los atributos que deberían ser asignados en masa.
     *
     * @var array
     */
    protected $fillable = [
        'bibliografia_id',
        'issn',
        'titulo_revista',
        'cronologia'
    ];

    /**
     * Obtener la bibliografía declarada asociada.
     */
    public function bibliografia()
    {
        return $this->belongsTo(BibliografiaDeclarada::class, 'bibliografia_id');
    }
} 