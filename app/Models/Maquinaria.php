<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Bounded Context: Gestión de Recursos
 * Entity: Maquinaria
 * 
 * Administración de maquinaria y equipos agrícolas
 * (tractores, cosechadoras, implementos).
 */
class Maquinaria extends Model
{
    protected $table = 'maquinarias';
    
    protected $fillable = [
        'nombre',
        'tipo',
        'mantenimiento'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relación 1:N con MantenimientoMaquinaria
     */
    public function mantenimientos(): HasMany
    {
        return $this->hasMany(MantenimientoMaquinaria::class, 'maquinaria_id');
    }
}
