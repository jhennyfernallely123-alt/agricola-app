<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Bounded Context: Venta y Distribución
 * Entity: Devolucion
 * 
 * Gestiona los casos en que productos entregados
 * son rechazados o retornados por el cliente.
 */
class Devolucion extends Model
{
    protected $table = 'devoluciones';
    
    protected $fillable = [
        'pedido_id',
        'producto_id',
        'cantidad',
        'motivo',
        'estado'
    ];

    protected $casts = [
        'cantidad' => 'decimal:2',
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

    /**
     * Relación N:1 con ProductoTerminado
     */
    public function producto(): BelongsTo
    {
        return $this->belongsTo(ProductoTerminado::class, 'producto_id');
    }
}
