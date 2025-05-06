<?php

namespace src\Models;

use Illuminate\Database\Eloquent\Model;

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
        'tipo_disponibilidad',
        'sede_id',
        'ejemplares',
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
        'ejemplares' => 'integer',
        'ejemplares_digitales' => 'integer'
    ];

    /**
     * Obtener la bibliografía declarada asociada.
     */
    public function bibliografiaDeclarada()
    {
        return $this->belongsTo(BibliografiaDeclarada::class);
    }

    /**
     * Obtener la sede donde está disponible.
     */
    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    /**
     * Valida si la sede es requerida según el tipo de disponibilidad
     */
    public static function validarSedeRequerida($data)
    {
        if (in_array($data['tipo_disponibilidad'], ['impreso', 'ambos'])) {
            return !empty($data['sede_id']);
        }
        return true;
    }

    /**
     * Valida si la sede debe ser nula para bibliografías electrónicas
     */
    public static function validarSedeNula($data)
    {
        if ($data['tipo_disponibilidad'] === 'electronico') {
            return empty($data['sede_id']);
        }
        return true;
    }

    /**
     * Valida si los ejemplares físicos son requeridos
     */
    public static function validarEjemplaresRequeridos($data)
    {
        if (in_array($data['tipo_disponibilidad'], ['impreso', 'ambos'])) {
            return isset($data['ejemplares']) && $data['ejemplares'] >= 0;
        }
        return true;
    }

    /**
     * Valida si los ejemplares digitales son requeridos
     */
    public static function validarEjemplaresDigitalesRequeridos($data)
    {
        if (in_array($data['tipo_disponibilidad'], ['electronico', 'ambos'])) {
            return isset($data['ejemplares_digitales']) && $data['ejemplares_digitales'] >= 0;
        }
        return true;
    }
} 