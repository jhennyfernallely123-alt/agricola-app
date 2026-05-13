<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Bounded Context: Gestión de Recursos
 * Entity: Personal (Empleado)
 * 
 * Representa a cada colaborador que forma parte
 * del equipo humano de la hacienda.
 */
class Personal extends Model
{
    protected $table = 'empleados';
    
    protected $fillable = [
        'nombre',
        'rol_id',
        'habilidades',
        'contrato'
    ];

    protected $casts = [
        'contrato' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relación N:1 con Rol
     */
    public function rol(): BelongsTo
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    /**
     * Relación 1:N con LaborAgricola
     */
    public function laboresAgricolas(): HasMany
    {
        return $this->hasMany(LaborAgricola::class, 'empleado_id');
    }
}
