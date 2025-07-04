<?php

namespace src\Models;

use Illuminate\Database\Eloquent\Model;

class Bibliografia extends Model
{
    protected $table = 'bibliografias';

    protected $fillable = [
        'asignatura_id',
        'tipo',
        'estado'
    ];

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class);
    }

    public function bibliografiasDisponibles()
    {
        return $this->hasMany(BibliografiaDisponible::class);
    }
} 