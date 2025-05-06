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
        'isbn',
        'doi',
        'url',
        'estado',
        'asignatura_id'
    ];

    /**
     * Obtener la asignatura a la que pertenece la bibliografía.
     */
    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class);
    }

    /**
     * Obtener los autores de la bibliografía.
     */
    public function autores()
    {
        return $this->belongsToMany(Autor::class, 'bibliografias_autores')
            ->withTimestamps();
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
            default:
                return $this->hasOne(Generico::class, 'bibliografia_id');
        }
    }
} 