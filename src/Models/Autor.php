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
} 