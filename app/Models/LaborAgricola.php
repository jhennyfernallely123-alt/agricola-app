<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Bounded Context: Gestión de Cultivo
 * Entity: LaborAgricola
 * 
 * Representa cada actividad operativa realizada en las parcelas
 * a lo largo del ciclo productivo.
 */
class LaborAgricola extends Model
{
    protected $table = 'labor_agricolas';
    
    protected $fillable = [
        'cultivo_id',
        'empleado_id',
        'tipo',
        'fecha',
        'costo'
    ];

    protected $casts = [
        'fecha' => 'date',
        'costo' => 'decimal:2',
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
     * Relación N:1 con Personal (Empleado)
     */
    public function empleado(): BelongsTo
    {
        return $this->belongsTo(Personal::class, 'empleado_id');
    }
}
