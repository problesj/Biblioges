<?php

namespace src\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    /**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'departamentos';

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'codigo',
        'nombre',
        'facultad_id',
        'estado'
    ];

    /**
     * Indica si el modelo debe tener timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Obtiene la facultad a la que pertenece el departamento.
     */
    public function facultad()
    {
        return $this->belongsTo(Facultad::class);
    }

    /**
     * Obtiene las asignaturas del departamento.
     */
    public function asignaturas()
    {
        return $this->belongsToMany(Asignatura::class, 'asignaturas_departamentos')
            ->withTimestamps();
    }

    /**
     * Obtiene las carreras del departamento a través de las asignaturas.
     */
    public function carreras()
    {
        return $this->belongsToMany(Carrera::class, 'mallas', 'asignatura_id', 'carrera_id')
            ->whereIn('asignatura_id', function($query) {
                $query->select('asignatura_id')
                    ->from('asignaturas_departamentos')
                    ->where('departamento_id', $this->id);
            })
            ->distinct();
    }
} 