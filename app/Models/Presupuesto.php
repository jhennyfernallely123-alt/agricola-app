<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Bounded Context: Gestión de Recursos
 * Entity: Presupuesto
 * 
 * Planificación financiera y elaboración de presupuestos
 * para los diferentes cultivos y operaciones.
 */
class Presupuesto extends Model
{
    protected $table = 'presupuestos';
    
    protected $fillable = [
        'nombre',
        'fecha_inicio',
        'fecha_fin',
        'monto_total'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'monto_total' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
