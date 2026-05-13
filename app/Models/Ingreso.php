<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Bounded Context: Gestión de Recursos
 * Entity: Ingreso
 * 
 * Registro de los ingresos generados por las ventas
 * y otras fuentes de ingresos de la hacienda.
 */
class Ingreso extends Model
{
    protected $table = 'ingresos';
    
    protected $fillable = [
        'fuente',
        'monto',
        'fecha',
        'pedido_id'
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'fecha' => 'date',
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
