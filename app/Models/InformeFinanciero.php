<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Bounded Context: Gestión de Recursos
 * Entity: InformeFinanciero
 * 
 * Generación de informes financieros y análisis
 * de la rentabilidad de los diferentes cultivos.
 */
class InformeFinanciero extends Model
{
    protected $table = 'informe_financieros';
    
    protected $fillable = [
        'tipo',
        'fecha_inicio',
        'fecha_fin',
        'ingresos_totales',
        'gastos_totales',
        'rentabilidad'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'ingresos_totales' => 'decimal:2',
        'gastos_totales' => 'decimal:2',
        'rentabilidad' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
