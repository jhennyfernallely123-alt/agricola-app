<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Bounded Context: Venta y Distribución
 * Entity: RutaEntrega
 * 
 * Representa la planificación optimizada de los trayectos
 * para la distribución de productos.
 */
class RutaEntrega extends Model
{
    protected $table = 'ruta_entregas';
    
    protected $fillable = [
        'pedido_id',
        'secuencia',
        'direccion',
        'estado'
    ];

    protected $casts = [
        'secuencia' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relación N:1 con Pedido
     */
    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class, 'pedido_id');
    }
}
