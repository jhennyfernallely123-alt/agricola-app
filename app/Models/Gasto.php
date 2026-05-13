<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Bounded Context: Gestión de Recursos
 * Entity: Gasto
 * 
 * Registro de todos los costos operativos
 * (mano de obra, insumos, mantenimiento, transporte).
 */
class Gasto extends Model
{
    protected $table = 'gastos';
    
    protected $fillable = [
        'concepto',
        'monto',
        'fecha',
        'proveedor_id'
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'fecha' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relación N:1 con Proveedor
     */
    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }
}
