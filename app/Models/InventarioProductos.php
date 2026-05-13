<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Bounded Context: Venta y Distribución
 * Entity: InventarioProductos
 * 
 * Gestiona el control actualizado de las existencias
 * disponibles para la venta.
 */
class InventarioProductos extends Model
{
    use HasFactory;

    protected $table = 'inventario_productos';
    
    protected $fillable = [
        'producto_id',
        'cantidad_disponible',
        'ubicacion',
        'fecha_vencimiento'
    ];

    protected $casts = [
        'cantidad_disponible' => 'decimal:2',
        'fecha_vencimiento' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relación N:1 con ProductoTerminado (1:1 real)
     */
    public function producto(): BelongsTo
    {
        return $this->belongsTo(ProductoTerminado::class, 'producto_id');
    }
}
