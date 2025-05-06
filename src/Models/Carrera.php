<?php

namespace src\Models;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    /**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'carreras';

    /**
     * Los atributos que deberían ser asignados en masa.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'estado',
        'url_libro'
    ];

    /**
     * Obtener las carreras espejo de esta carrera.
     */
    public function carrerasEspejo()
    {
        return $this->hasMany(CarreraEspejo::class);
    }

    /**
     * Obtener las asignaturas de la carrera.
     */
    public function asignaturas()
    {
        return $this->belongsToMany(Asignatura::class, 'mallas')
            ->withPivot('semestre')
            ->withTimestamps();
    }

    /**
     * Obtener todas las carreras.
     */
    public static function getAll()
    {
        return static::orderBy('nombre')->get();
    }
} 