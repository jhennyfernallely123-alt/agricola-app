@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-calendar-check"></i> Detalle de Plan de Cultivo</h1>
        <a href="{{ route('planes-cultivo.index') }}" class="btn btn-secondary mb-3"><i class="bi bi-arrow-left"></i> Volver</a>
        
        <div class="row">
            <div class="col-md-6">
                <dl class="row">
                    <dt class="col-sm-3">ID</dt>
                    <dd class="col-sm-9">{{ $plan->id }}</dd>
                    
                    <dt class="col-sm-3">Cultivo</dt>
                    <dd class="col-sm-9"><strong>{{ $plan->cultivo->nombre }}</strong></dd>
                    
                    <dt class="col-sm-3">Fecha de Inicio</dt>
                    <dd class="col-sm-9">{{ $plan->fecha_inicio }}</dd>
                    
                    <dt class="col-sm-3">Fecha Fin Prevista</dt>
                    <dd class="col-sm-9">{{ $plan->fecha_fin_prevista }}</dd>
                    
                    <dt class="col-sm-3">Objetivo de Producción</dt>
                    <dd class="col-sm-9">{{ $plan->objetivo_produccion ?? '0.00' }} unidades</dd>
                </dl>
            </div>
            
            <div class="col-md-6">
                <h5>Información del Cultivo</h5>
                <dl class="row">
                    <dt class="col-sm-3">Variedad</dt>
                    <dd class="col-sm-9">{{ $plan->cultivo->variedad ?? 'No especificada' }}</dd>
                    
                    <dt class="col-sm-3">Requerimientos</dt>
                    <dd class="col-sm-9">{{ $plan->cultivo->requerimientos ?? 'No especificados' }}</dd>
                    
                    <dt class="col-sm-3">Parcela</dt>
                    <dd class="col-sm-9">{{ $plan->cultivo->parcela->nombre ?? 'Sin asignar' }}</dd>
                    
                    <dt class="col-sm-3">Área de la Parcela</dt>
                    <dd class="col-sm-9">{{ number_format($plan->cultivo->parcela->area, 2) }} ha</dd>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection