@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-bag-plus"></i> Detalle de Plan de Fertilización</h1>
        <a href="{{ route('planes-fertilizacion.index') }}" class="btn btn-secondary mb-3"><i class="bi bi-arrow-left"></i> Volver</a>
        
        <div class="row">
            <div class="col-md-6">
                <dl class="row">
                    <dt class="col-sm-3">ID</dt>
                    <dd class="col-sm-9">{{ $plan->id }}</dd>
                    
                    <dt class="col-sm-3">Cultivo</dt>
                    <dd class="col-sm-9"><strong>{{ $plan->cultivo->nombre }}</strong></dd>
                    
                    <dt class="col-sm-3">Fertilizante</dt>
                    <dd class="col-sm-9"><strong>{{ $plan->insumoAgricola->nombre }}</strong></dd>
                    
                    <dt class="col-sm-3">Etapa Fenológica</dt>
                    <dd class="col-sm-9">{{ $plan->etapaFenologica->nombre ?? 'No especificada' }}</dd>
                    
                    <dt class="col-sm-3">Dosis</dt>
                    <dd class="col-sm-9">{{ $plan->dosis }}</dd>
                    
                    <dt class="col-sm-3">Método de Aplicación</dt>
                    <dd class="col-sm-9">{{ $plan->metodo ?? 'No especificado' }}</dd>
                </dl>
            </div>
            
            <div class="col-md-6">
                <h5>Información Adicional</h5>
                <dl class="row">
                    <dt class="col-sm-3">Variedad del Cultivo</dt>
                    <dd class="col-sm-9">{{ $plan->cultivo->variedad ?? 'No especificada' }}</dd>
                    
                    <dt class="col-sm-3">Parcela del Cultivo</dt>
                    <dd class="col-sm-9">{{ $plan->cultivo->parcela->nombre ?? 'Sin asignar' }}</dd>
                    
                    <dt class="col-sm-3">Área de la Parcela</dt>
                    <dd class="col-sm-9">{{ number_format($plan->cultivo->parcela->area, 2) }} ha</dd>
                    
                    <dt class="col-sm-3">Tipo de Fertilizante</dt>
                    <dd class="col-sm-9">{{ $plan->insumoAgricola->tipo ?? 'No especificado' }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection