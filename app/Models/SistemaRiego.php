<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Bounded Context: Gestión de Cultivo
 * Entity: SistemaRiego
 * 
 * Engloba la infraestructura, equipamiento y planificación
 * relacionados con la provisión de agua a los cultivos.
 */
class SistemaRiego extends Model
{
    use HasFactory;
    protected $table = 'sistema_riegos';
    
    protected $fillable = [
        'tipo',
        'fuente'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relación N:M con Cultivo (pivot: cultivo_sistema_riego)
     */
    public function cultivos(): BelongsToMany
    {
        return $this->belongsToMany(
            Cultivo::class,
            'cultivo_sistema_riego',
            'sistema_riego_id',
            'cultivo_id'
        )->withTimestamps();
    }
}
