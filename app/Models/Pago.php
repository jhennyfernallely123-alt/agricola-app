<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Bounded Context: Venta y Distribución
 * Entity: Pago
 * 
 * Documenta las transacciones monetarias realizadas
 * por los clientes para saldar sus obligaciones.
 */
class Pago extends Model
{
    use HasFactory;

    protected $table = 'pagos';
    
    protected $fillable = [
        'factura_id',
        'monto',
        'fecha',
        'metodo_pago'
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'fecha' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relación N:1 con Factura
     */
    public function factura(): BelongsTo
    {
        return $this->belongsTo(Factura::class, 'factura_id');
    }
}
