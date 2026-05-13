<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Bounded Context: Gestión de Cultivo
 * Entity: PlanCultivo
 * 
 * Materialización de la decisión estratégica de implementar un cultivo
 * específico en una parcela durante un periodo definido.
 */
class PlanCultivo extends Model
{
    protected $table = 'plan_cultivos';
    
    protected $fillable = [
        'cultivo_id',
        'fecha_inicio',
        'fecha_fin_prevista',
        'objetivo_produccion'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin_prevista' => 'date',
        'objetivo_produccion' => 'decimal:2',
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
