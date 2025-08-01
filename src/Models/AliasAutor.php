<?php

namespace src\Models;

use Illuminate\Database\Eloquent\Model;

class AliasAutor extends Model
{
    protected $table = 'alias_autores';

    /**
     * Los atributos que deberían ser asignados en masa.
     *
     * @var array
     */
    protected $fillable = [
        'autor_id',
        'nombre_variacion'
    ];

    /**
     * Los nombres de las columnas de timestamp.
     *
     * @var string
     */
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';

    /**
     * Indica si el modelo debe ser timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Obtener el autor asociado.
     */
    public function autor()
    {
        return $this->belongsTo(Autor::class, 'autor_id');
    }

    /**
     * Crear un alias para un autor
     */
    public static function crearAlias($autorId, $nombreVariacion)
    {
        return self::create([
            'autor_id' => $autorId,
            'nombre_variacion' => trim($nombreVariacion)
        ]);
    }

    /**
     * Buscar autores por variación de nombre
     */
    public static function buscarPorVariacion($nombreVariacion)
    {
        return self::where('nombre_variacion', 'LIKE', '%' . $nombreVariacion . '%')
                   ->with('autor')
                   ->get();
    }

    /**
     * Obtener todas las variaciones de un autor
     */
    public static function obtenerVariacionesAutor($autorId)
    {
        return self::where('autor_id', $autorId)->get();
    }
} 