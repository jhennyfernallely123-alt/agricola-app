<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Bounded Context: Gestión de Cultivo
 * Entity: EtapaFenologica
 * 
 * Documenta las fases de desarrollo biológico de cada cultivo
 * implementado, desde la germinación hasta la maduración.
 */
class EtapaFenologica extends Model
{
    protected $table = 'etapa_fenologicas';
    
    protected $fillable = [
        'cultivo_id',
        'nombre',
        'fecha_inicio',
        'requerimientos_especificos'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
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

    /**
     * Relación 1:N con PlanFertilizacion
     */
    public function planesFertilizacion(): HasMany
    {
        return $this->hasMany(PlanFertilizacion::class, 'etapa_fenologica_id');
    }
}
