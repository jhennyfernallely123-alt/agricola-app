<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Bounded Context: Gestión de Cultivo
 * Entity: PlanFertilizacion
 * 
 * Estructura la estrategia nutricional para cada cultivo
 * basándose en análisis de suelo y requerimientos específicos.
 */
class PlanFertilizacion extends Model
{
    protected $table = 'plan_fertilizacions';
    
    protected $fillable = [
        'cultivo_id',
        'insumo_agricola_id',
        'etapa_fenologica_id',
        'dosis',
        'metodo'
    ];

    protected $casts = [
        'dosis' => 'decimal:2',
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
     * Relación N:1 con InsumoAgricola (Fertilizante)
     */
    public function insumoAgricola(): BelongsTo
    {
        return $this->belongsTo(InsumoAgricola::class, 'insumo_agricola_id');
    }

    /**
     * Relación N:1 con EtapaFenologica
     */
    public function etapaFenologica(): BelongsTo
    {
        return $this->belongsTo(EtapaFenologica::class, 'etapa_fenologica_id');
    }
}
