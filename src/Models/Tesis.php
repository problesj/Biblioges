<?php

namespace src\Models;

use Illuminate\Database\Eloquent\Model;

class Tesis extends Model
{
    protected $table = 'tesis';

    /**
     * Los atributos que deberían ser asignados en masa.
     *
     * @var array
     */
    protected $fillable = [
        'bibliografia_id',
        'nombre_carrera'
    ];

    /**
     * Obtener la bibliografía declarada asociada.
     */
    public function bibliografia()
    {
        return $this->belongsTo(BibliografiaDeclarada::class, 'bibliografia_id');
    }
} 