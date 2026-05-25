@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-bug"></i> Detalle de Control de Plagas</h1>
        <a href="{{ route('plagas.index') }}" class="btn btn-secondary mb-3"><i class="bi bi-arrow-left"></i> Volver</a>
        
        <div class="row">
            <div class="col-md-6">
                <dl class="row">
                    <dt class="col-sm-3">ID</dt>
                    <dd class="col-sm-9">{{ $control->id }}</dd>
                    
                    <dt class="col-sm-3">Cultivo</dt>
                    <dd class="col-sm-9"><strong>{{ $control->cultivo->nombre }}</strong></dd>
                    
                    <dt class="col-sm-3">Tipo</dt>
                    <dd class="col-sm-9"><strong>{{ $control->tipo == 'plaga' ? 'Plaga' : 'Enfermedad' }}</strong></dd>
                    
                    <dt class="col-sm-3">Nombre</dt>
                    <dd class="col-sm-9"><strong>{{ $control->nombre }}</strong></dd>
                    
                    <dt class="col-sm-3">Fecha de Detección</dt>
                    <dd class="col-sm-9">{{ $control->fecha_deteccion }}</dd>
                    
                    <dt class="col-sm-3">Tratamiento Aplicado</dt>
                    <dd class="col-sm-9">{{ $control->tratamiento_aplicado ?? 'No especificado' }}</dd>
                </dl>
            </div>
            
            <div class="col-md-6">
                <h5>Información del Cultivo</h5>
                <dl class="row">
                    <dt class="col-sm-3">Variedad</dt>
                    <dd class="col-sm-9">{{ $control->cultivo->variedad ?? 'No especificada' }}</dd>
                    
                    <dt class="col-sm-3">Parcela</dt>
                    <dd class="col-sm-9">{{ $control->cultivo->parcela->nombre ?? 'Sin asignar' }}</dd>
                    
                    <dt class="col-sm-3">Área de la Parcela</dt>
                    <dd class="col-sm-9">{{ number_format($control->cultivo->parcela->area, 2) }} ha</dd>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection