<?php

namespace src\Models;

use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    /**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'autores';

    /**
     * La clave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'apellidos',
        'nombres',
        'genero'
    ];

    /**
     * Indica si el modelo debe tener timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Obtiene las bibliografías declaradas del autor.
     */
    public function bibliografiasDeclaradas()
    {
        return $this->belongsToMany(
            BibliografiaDeclarada::class,
            'bibliografias_autores',
            'autor_id',
            'bibliografia_id'
        );
    }

    /**
     * Obtiene las bibliografías disponibles del autor.
     */
    public function bibliografiasDisponibles()
    {
        return $this->belongsToMany(
            BibliografiaDisponible::class,
            'bibliografias_disponibles_autores',
            'autor_id',
            'bibliografia_disponible_id'
        );
    }

    /**
     * Obtiene los alias del autor.
     */
    public function alias()
    {
        return $this->hasMany(AliasAutor::class, 'autor_id');
    }

    /**
     * Obtiene el nombre completo del autor.
     */
    public function getNombreCompletoAttribute()
    {
        return trim($this->apellidos . ', ' . $this->nombres);
    }

    /**
     * Crear un alias para este autor
     */
    public function crearAlias($nombreVariacion)
    {
        return AliasAutor::crearAlias($this->id, $nombreVariacion);
    }

    /**
     * Obtener todas las variaciones de nombre de este autor
     */
    public function obtenerVariaciones()
    {
        return $this->alias()->get();
    }
} 