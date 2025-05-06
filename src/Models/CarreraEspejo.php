<?php

namespace src\Models;

use Illuminate\Database\Eloquent\Model;

class CarreraEspejo extends Model
{
    /**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'carreras_espejos';

    /**
     * Los atributos que deberían ser asignados en masa.
     *
     * @var array
     */
    protected $fillable = [
        'carrera_id',
        'sede_id'
    ];

    /**
     * Indica si el modelo debe tener timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Obtener la carrera principal.
     */
    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }

    /**
     * Obtener la facultad.
     */
    public function facultad()
    {
        return $this->belongsTo(Facultad::class);
    }

    /**
     * Obtener la sede.
     */
    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }
} 