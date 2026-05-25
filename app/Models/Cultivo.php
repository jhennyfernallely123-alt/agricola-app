<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Bounded Context: Gestión de Cultivo
 * Entity: Cultivo
 * 
 * Representa la especie vegetal seleccionada para producción,
 * con toda su complejidad taxonómica y agronómica.
 */
class Cultivo extends Model
{
    use HasFactory;
    protected $table = 'cultivos';
    
    protected $fillable = [
        'nombre',
        'variedad',
        'requerimientos',
        'parcela_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relación N:1 con Parcela
     * Un cultivo pertenece a una parcela específica
     */
    public function parcela(): BelongsTo
    {
        return $this->belongsTo(Parcela::class, 'parcela_id');
    }

    /**
     * Relación 1:N con EtapaFenologica
     */
    public function etapasFenologicas(): HasMany
    {
        return $this->hasMany(EtapaFenologica::class, 'cultivo_id');
    }

    /**
     * Relación 1:N con LaborAgricola
     */
    public function laboresAgricolas(): HasMany
    {
        return $this->hasMany(LaborAgricola::class, 'cultivo_id');
    }

    /**
     * Relación 1:N con PlanFertilizacion
     */
    public function planesFertilizacion(): HasMany
    {
        return $this->hasMany(PlanFertilizacion::class, 'cultivo_id');
    }

    /**
     * Relación 1:N con ControlPlagasEnfermedades
     */
    public function controlesPlagas(): HasMany
    {
        return $this->hasMany(ControlPlagasEnfermedades::class, 'cultivo_id');
    }

    /**
     * Relación 1:N con PlanCultivo
     */
    public function planesCultivo(): HasMany
    {
        return $this->hasMany(PlanCultivo::class, 'cultivo_id');
    }

    /**
     * Relación N:M con SistemaRiego (pivot: cultivo_sistema_riego)
     */
    public function sistemasRiego(): BelongsToMany
    {
        return $this->belongsToMany(
            SistemaRiego::class,
            'cultivo_sistema_riego',
            'cultivo_id',
            'sistema_riego_id'
        )->withTimestamps();
    }

    /**
     * Relación N:M con InsumoAgricola/Fertilizante (pivot: cultivo_fertilizante)
     */
    public function insumosAgricolas(): BelongsToMany
    {
        return $this->belongsToMany(
            InsumoAgricola::class,
            'cultivo_fertilizante',
            'cultivo_id',
            'fertilizante_id'
        )->withTimestamps();
    }
}
