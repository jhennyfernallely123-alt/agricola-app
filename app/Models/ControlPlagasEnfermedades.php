<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Bounded Context: Gestión de Cultivo
 * Entity: ControlPlagasEnfermedades
 * 
 * Engloba las estrategias preventivas y correctivas implementadas
 * para proteger los cultivos de agentes bióticos perjudiciales.
 */
class ControlPlagasEnfermedades extends Model
{
    protected $table = 'control_plagas_enfermedades';
    
    protected $fillable = [
        'cultivo_id',
        'tipo',
        'nombre',
        'fecha_deteccion',
        'tratamiento_aplicado'
    ];

    protected $casts = [
        'fecha_deteccion' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relación N:1 con Cultivo
     */
    public function cultivo(): BelongsTo
    {
        return $this->belongsTo(Cultivo::class, 'cultivo_id');
    }
}
