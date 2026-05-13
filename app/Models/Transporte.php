<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Bounded Context: Venta y Distribución
 * Entity: Transporte
 * 
 * Engloba los recursos físicos destinados a la movilización
 * de los productos desde la hacienda hasta los clientes.
 */
class Transporte extends Model
{
    use HasFactory;

    protected $table = 'transportes';
    
    protected $fillable = [
        'tipo',
        'placa',
        'capacidad'
    ];

    protected $casts = [
        'capacidad' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relación 1:N con Pedido
     */
    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class, 'transporte_id');
    }
}
