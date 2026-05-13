<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Bounded Context: Gestión de Recursos
 * Entity: MantenimientoMaquinaria
 * 
 * Registro de mantenimientos preventivos y correctivos
 * de la maquinaria agrícola.
 */
class MantenimientoMaquinaria extends Model
{
    protected $table = 'mantenimiento_maquinarias';
    
    protected $fillable = [
        'maquinaria_id',
        'fecha',
        'tipo',
        'costo'
    ];

    protected $casts = [
        'fecha' => 'date',
        'costo' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relación N:1 con Maquinaria
     */
    public function maquinaria(): BelongsTo
    {
        return $this->belongsTo(Maquinaria::class, 'maquinaria_id');
    }
}
