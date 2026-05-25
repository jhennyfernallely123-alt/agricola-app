<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Bounded Context: Venta y Distribución
 * Entity: Pedido
 * 
 * Documenta cada transacción comercial desde su origen
 * como solicitud hasta su culminación con entrega y facturación.
 */
class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';
    
    protected $fillable = [
        'cliente_id',
        'transporte_id',
        'fecha',
        'estado'
    ];

    protected $casts = [
        'fecha' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relación N:1 con Cliente
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    /**
     * Relación N:1 con Transporte
     */
    public function transporte(): BelongsTo
    {
        return $this->belongsTo(Transporte::class, 'transporte_id');
    }

    /**
     * Relación N:M con ProductoTerminado (pivot: pedido_producto)
     */
    public function productos(): BelongsToMany
    {
        return $this->belongsToMany(
            ProductoTerminado::class,
            'pedido_producto',
            'pedido_id',
            'producto_id'
        )->withPivot('cantidad')->withTimestamps();
    }

    /**
     * Relación 1:1 con Factura
     */
    public function factura(): HasOne
    {
        return $this->hasOne(Factura::class, 'pedido_id');
    }

    /**
     * Relación 1:N con Devolucion
     */
    public function devoluciones(): HasMany
    {
        return $this->hasMany(Devolucion::class, 'pedido_id');
    }

    /**
     * Relación 1:N con RutaEntrega
     */
    public function rutasEntrega(): HasMany
    {
        return $this->hasMany(RutaEntrega::class, 'pedido_id');
    }

    /**
     * Relación 1:N con Ingreso
     */
    public function ingresos(): HasMany
    {
        return $this->hasMany(Ingreso::class, 'pedido_id');
    }
}
