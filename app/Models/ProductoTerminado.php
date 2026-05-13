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
 * Entity: ProductoTerminado
 * 
 * Representa cada ítem agrícola en su estado final
 * listo para comercialización.
 */
class ProductoTerminado extends Model
{
    use HasFactory;

    protected $table = 'productos';
    
    protected $fillable = [
        'nombre',
        'variedad',
        'presentacion',
        'lote',
        'calidad',
        'fecha_cosecha',
        'parcela_origen_id'
    ];

    protected $casts = [
        'fecha_cosecha' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relación N:M con Pedido (pivot: pedido_producto)
     */
    public function pedidos(): BelongsToMany
    {
        return $this->belongsToMany(
            Pedido::class,
            'pedido_producto',
            'producto_id',
            'pedido_id'
        )->withTimestamps();
    }

    /**
     * Relación 1:1 con InventarioProductos
     */
    public function inventario(): HasOne
    {
        return $this->hasOne(InventarioProductos::class, 'producto_id');
    }

    /**
     * Relación N:1 con Parcela (origen)
     */
    public function parcelaOrigen(): BelongsTo
    {
        return $this->belongsTo(Parcela::class, 'parcela_origen_id');
    }

    /**
     * Relación 1:N con Devolucion
     */
    public function devoluciones(): HasMany
    {
        return $this->hasMany(Devolucion::class, 'producto_id');
    }
}
