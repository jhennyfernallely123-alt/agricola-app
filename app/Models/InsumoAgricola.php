<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Bounded Context: Gestión de Cultivo
 * Entity: InsumoAgricola (mapeado a tabla fertilizantes)
 * 
 * Representa cada material o producto utilizado en el proceso productivo,
 * incluyendo semillas, fertilizantes, productos fitosanitarios, etc.
 */
class InsumoAgricola extends Model
{
    protected $table = 'fertilizantes';
    
    protected $fillable = [
        'nombre',
        'tipo',
        'descripcion'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relación N:M con Cultivo (pivot: cultivo_fertilizante)
     */
    public function cultivos(): BelongsToMany
    {
        return $this->belongsToMany(
            Cultivo::class,
            'cultivo_fertilizante',
            'fertilizante_id',
            'cultivo_id'
        )->withTimestamps();
    }

    /**
     * Relación 1:N con PlanFertilizacion
     */
    public function planesFertilizacion(): HasMany
    {
        return $this->hasMany(PlanFertilizacion::class, 'insumo_agricola_id');
    }
}
