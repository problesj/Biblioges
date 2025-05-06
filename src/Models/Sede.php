<?php

namespace src\Models;

use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    /**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'sedes';

    /**
     * Los atributos que deberían ser asignados en masa.
     *
     * @var array
     */
    protected $fillable = [
        'codigo',
        'nombre',
        'estado'
    ];

    /**
     * Indica si el modelo debe tener timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Obtener las facultades de la sede.
     */
    public function facultades()
    {
        return $this->hasMany(Facultad::class);
    }

    /**
     * Obtener las carreras de la sede.
     */
    public function carreras()
    {
        return $this->hasMany(Carrera::class);
    }
} 