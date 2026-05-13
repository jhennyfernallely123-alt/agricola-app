<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Bounded Context: Gestión de Recursos
 * Entity: Proveedor
 * 
 * Representa a los suministradores de insumos y servicios
 * para la operación de la hacienda.
 */
class Proveedor extends Model
{
    protected $table = 'proveedores';
    
    protected $fillable = [
        'nombre',
        'contacto',
        'contrato'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relación 1:N con Gasto
     */
    public function gastos(): HasMany
    {
        return $this->hasMany(Gasto::class, 'proveedor_id');
    }
}
