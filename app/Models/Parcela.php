<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Bounded Context: Gestión de Cultivo
 * Entity: Parcela
 * 
 * Unidad territorial básica para el cultivo, con características
 * físicas, químicas y biológicas homogéneas y límites definidos.
 */
class Parcela extends Model
{
    use HasFactory;

    protected $table = 'parcelas';
    
    protected $fillable = [
        'nombre',
        'area',
        'historial_uso',
        'analisis_suelo',
        'potencial_productivo'
    ];

    protected $casts = [
        'area' => 'double',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relación 1:N con Cultivo
     * Una parcela puede tener múltiples cultivos
     */
    public function cultivos(): HasMany
    {
        return $this->hasMany(Cultivo::class, 'parcela_id');
    }

    /**
     * Relación 1:1 con ProductoTerminado (origen)
     * Los productos pueden rastrear su parcela de origen
     */
    public function productos(): HasMany
    {
        return $this->hasMany(ProductoTerminado::class, 'parcela_origen_id');
    }
}
