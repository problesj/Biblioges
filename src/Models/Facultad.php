<?php

namespace src\Models;

use Illuminate\Database\Eloquent\Model;

class Facultad extends Model
{
    /**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'facultades';

    /**
     * Los atributos que deberían ser asignados en masa.
     *
     * @var array
     */
    protected $fillable = [
        'codigo',
        'nombre',
        'sede_id',
        'estado'
    ];

    public $timestamps = false;

    /**
     * Obtener la sede a la que pertenece la facultad.
     */
    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    /**
     * Obtener los departamentos de la facultad.
     */
    public function departamentos()
    {
        return $this->hasMany(Departamento::class);
    }

    /**
     * Obtener las carreras de la facultad.
     */
    public function carreras()
    {
        return $this->hasMany(Carrera::class, 'id_facultad');
    }
} 