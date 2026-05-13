<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Bounded Context: Venta y Distribución
 * Entity: Factura
 * 
 * Documento comercial y fiscal que formaliza la venta
 * y establece las obligaciones de pago.
 */
class Factura extends Model
{
    use HasFactory;

    protected $table = 'facturas';
    
    protected $fillable = [
        'pedido_id',
        'numero_factura',
        'subtotal',
        'total',
        'estado_pago'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'total' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relación N:1 con Pedido (1:1 real)
     */
    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class, 'pedido_id');
    }

    /**
     * Relación 1:N con Pago
     */
    public function pagos(): HasMany
    {
        return $this->hasMany(Pago::class, 'factura_id');
    }
}
