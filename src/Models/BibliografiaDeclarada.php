<?php

namespace src\Models;

use Illuminate\Database\Eloquent\Model;

class BibliografiaDeclarada extends Model
{
    /**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'bibliografias_declaradas';

    /**
     * Los atributos que deberían ser asignados en masa.
     *
     * @var array
     */
    protected $fillable = [
        'titulo',
        'tipo',
        'anio_publicacion',
        'editorial',
        'edicion',
        'url',
        'nota',
        'formato',
        'estado'
    ];

    protected $casts = [
        'anio_publicacion' => 'integer',
        'estado' => 'boolean'
    ];

    /**
     * Obtener las asignaturas asociadas a la bibliografía.
     */
    public function asignaturas()
    {
        return $this->belongsToMany(Asignatura::class, 'asignaturas_bibliografias', 'bibliografia_id', 'asignatura_id')
            ->withPivot('tipo_bibliografia', 'estado')
            ->withTimestamps('fecha_creacion', 'fecha_actualizacion');
    }

    /**
     * Obtener los autores de la bibliografía.
     */
    public function autores()
    {
        return $this->belongsToMany(Autor::class, 'bibliografias_autores', 'bibliografia_id', 'autor_id')
            ->withTimestamps('fecha_creacion', 'fecha_actualizacion');
    }

    /**
     * Obtener los detalles específicos según el tipo.
     */
    public function detalles()
    {
        switch ($this->tipo) {
            case 'libro':
                return $this->hasOne(Libro::class, 'bibliografia_id');
            case 'articulo':
                return $this->hasOne(Articulo::class, 'bibliografia_id');
            case 'tesis':
                return $this->hasOne(Tesis::class, 'bibliografia_id');
            case 'software':
                return $this->hasOne(Software::class, 'bibliografia_id');
            case 'sitio_web':
                return $this->hasOne(SitioWeb::class, 'bibliografia_id');
            case 'generico':
                return $this->hasOne(Generico::class, 'bibliografia_id');
            default:
                return null;
        }
    }

    /**
     * Obtener las bibliografías disponibles asociadas.
     */
    public function disponibles()
    {
        return $this->hasMany(BibliografiaDisponible::class, 'bibliografia_declarada_id');
    }

    public function libro()
    {
        return $this->hasOne(Libro::class, 'bibliografia_id');
    }

    public function tesis()
    {
        return $this->hasOne(Tesis::class, 'bibliografia_id');
    }

    public function articulo()
    {
        return $this->hasOne(Articulo::class, 'bibliografia_id');
    }

    public function generico()
    {
        return $this->hasOne(Generico::class, 'bibliografia_id');
    }

    public function sitioWeb()
    {
        return $this->hasOne(SitioWeb::class, 'bibliografia_id');
    }

    public function software()
    {
        return $this->hasOne(Software::class, 'bibliografia_id');
    }
} 