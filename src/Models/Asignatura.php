<?php

namespace src\Models;

use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
    /**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'asignaturas';

    /**
     * Indica si el modelo debe ser timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Los nombres de las columnas de timestamps.
     *
     * @var string
     */
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';

    /**
     * Los atributos que deberían ser asignados en masa.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'tipo',
        'vigencia_desde',
        'vigencia_hasta',
        'estado',
        'periodicidad',
        'url_programa'
    ];

    /**
     * Los atributos que deberían ser convertidos a tipos nativos.
     *
     * @var array
     */
    protected $casts = [
        'estado' => 'boolean',
        'fecha_creacion' => 'datetime',
        'fecha_actualizacion' => 'datetime'
    ];

    /**
     * Obtener el departamento principal de la asignatura.
     */
    public function departamento()
    {
        return $this->belongsToMany(Departamento::class, 'asignaturas_departamentos')
            ->withPivot('codigo_asignatura', 'cantidad_alumnos')
            ->withTimestamps('fecha_creacion', 'fecha_actualizacion')
            ->first();
    }

    /**
     * Obtener los departamentos donde se dicta la asignatura.
     */
    public function departamentos()
    {
        return $this->belongsToMany(Departamento::class, 'asignaturas_departamentos')
            ->withPivot('codigo_asignatura', 'cantidad_alumnos')
            ->withTimestamps('fecha_creacion', 'fecha_actualizacion');
    }

    /**
     * Obtener las bibliografías declaradas de la asignatura.
     */
    public function bibliografiasDeclaradas()
    {
        return $this->hasMany(BibliografiaDeclarada::class);
    }

    /**
     * Obtener las carreras de la asignatura.
     */
    public function carreras()
    {
        return $this->belongsToMany(Carrera::class, 'mallas')
            ->withPivot('semestre')
            ->withTimestamps();
    }

    /**
     * Obtener las asignaturas de formación relacionadas.
     */
    public function asignaturasFormacion()
    {
        return $this->belongsToMany(Asignatura::class, 'asignaturas_formacion', 
            'asignatura_regular_id', 'asignatura_formacion_id')
            ->withTimestamps();
    }

    /**
     * Obtener las asignaturas regulares relacionadas.
     */
    public function asignaturasRegulares()
    {
        return $this->belongsToMany(Asignatura::class, 'asignaturas_formacion', 
            'asignatura_formacion_id', 'asignatura_regular_id')
            ->withTimestamps();
    }

    /**
     * Obtener las bibliografías de la asignatura.
     */
    public function bibliografias()
    {
        return $this->hasMany(Bibliografia::class);
    }

    /**
     * Obtener todas las asignaturas con sus departamentos.
     */
    public static function getAllWithDepartamentos()
    {
        return static::with('departamentos')
            ->orderBy('nombre')
            ->get();
    }

    /**
     * Obtener las asignaturas filtradas por tipo.
     */
    public static function getByType($type)
    {
        return static::where('tipo', $type)
            ->with('departamentos')
            ->orderBy('nombre')
            ->get();
    }

    /**
     * Obtener las asignaturas activas.
     */
    public static function getActive()
    {
        return static::where('estado', true)
            ->with('departamentos')
            ->orderBy('nombre')
            ->get();
    }

    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }
} 