<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Bounded Context: Gestión de Recursos
 * Entity: Rol
 * 
 * Define cada función específica que puede ser
 * desempeñada dentro de la estructura organizativa.
 */
class Rol extends Model
{
    protected $table = 'rols';
    
    protected $fillable = [
        'nombre',
        'descripcion'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relación 1:N con Personal (Empleado)
     */
    public function empleados(): HasMany
    {
        return $this->hasMany(Personal::class, 'rol_id');
    }
}
