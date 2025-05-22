<?php

namespace src\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BibliografiaDisponible extends Model
{
    /**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'bibliografias_disponibles';
    
    /**
     * Los atributos que deberían ser asignados en masa.
     *
     * @var array
     */
    protected $fillable = [
        'bibliografia_declarada_id',
        'titulo',
        'editorial',
        'anio_edicion',
        'url_acceso',
        'url_catalogo',
        'disponibilidad',
        'id_mms',
        'ejemplares_digitales',
        'estado'
    ];

    /**
     * Los atributos que deberían ser convertidos a tipos nativos.
     *
     * @var array
     */
    protected $casts = [
        'estado' => 'boolean',
        'ejemplares_digitales' => 'integer',
        'anio_edicion' => 'integer'
    ];

    /**
     * Relación con la bibliografía declarada
     */
    public function bibliografiaDeclarada(): BelongsTo
    {
        return $this->belongsTo(BibliografiaDeclarada::class, 'bibliografia_declarada_id');
    }

    /**
     * Relación con las sedes y sus ejemplares
     */
    public function sedes(): BelongsToMany
    {
        return $this->belongsToMany(Sede::class, 'bibliografias_disponibles_sedes')
            ->withPivot('ejemplares')
            ->withTimestamps('fecha_creacion', 'fecha_actualizacion');
    }

    /**
     * Obtiene los autores de la bibliografía.
     */
    public function autores(): BelongsToMany
    {
        return $this->belongsToMany(Autor::class, 'bibliografias_disponibles_autores')
            ->withTimestamps('fecha_creacion', 'fecha_actualizacion');
    }

    /**
     * Validar que los campos requeridos estén presentes según el tipo de disponibilidad
     */
    public function validateDisponibilidad(): bool
    {
        switch ($this->disponibilidad) {
            case 'electronico':
                return !empty($this->titulo) && 
                       !empty($this->anio_edicion) && 
                       !empty($this->url_acceso);

            case 'impreso':
                return !empty($this->titulo) && 
                       !empty($this->anio_edicion) && 
                       !empty($this->url_catalogo) && 
                       !empty($this->id_mms) &&
                       $this->sedes()->count() > 0;

            case 'ambos':
                return !empty($this->titulo) && 
                       !empty($this->anio_edicion) && 
                       !empty($this->url_acceso) && 
                       !empty($this->url_catalogo) && 
                       !empty($this->id_mms) &&
                       $this->sedes()->count() > 0;

            default:
                return false;
        }
    }

    /**
     * Obtener el total de ejemplares impresos
     */
    public function getTotalEjemplaresImpresos(): int
    {
        return $this->sedes()->sum('ejemplares');
    }

    /**
     * Verificar si tiene ejemplares digitales ilimitados
     */
    public function tieneEjemplaresDigitalesIlimitados(): bool
    {
        return $this->ejemplares_digitales === 0;
    }
} 