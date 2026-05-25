@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-tools"></i> Detalle de Labor Agrícola</h1>
        <a href="{{ route('labores-agricolas.index') }}" class="btn btn-secondary mb-3"><i class="bi bi-arrow-left"></i> Volver</a>
        
        <div class="row">
            <div class="col-md-6">
                <dl class="row">
                    <dt class="col-sm-3">ID</dt>
                    <dd class="col-sm-9">{{ $labor->id }}</dd>
                    
                    <dt class="col-sm-3">Cultivo</dt>
                    <dd class="col-sm-9"><strong>{{ $labor->cultivo->nombre }}</strong></dd>
                    
                    <dt class="col-sm-3">Empleado</dt>
                    <dd class="col-sm-9"><strong>{{ $labor->empleado->nombre }}</strong></dd>
                    
                    <dt class="col-sm-3">Tipo</dt>
                    <dd class="col-sm-9"><strong>{{ $labor->tipo }}</strong></dd>
                    
                    <dt class="col-sm-3">Fecha</dt>
                    <dd class="col-sm-9">{{ $labor->fecha }}</dd>
                    
                    <dt class="col-sm-3">Costo</dt>
                    <dd class="col-sm-9">{{ $labor->costo ?? '0.00' }}</dd>
                </dl>
            </div>
            
            <div class="col-md-6">
                <h5>Información Adicional</h5>
                <dl class="row">
                    <dt class="col-sm-3">Variedad del Cultivo</dt>
                    <dd class="col-sm-9">{{ $labor->cultivo->variedad ?? 'No especificada' }}</dd>
                    
                    <dt class="col-sm-3">Parcela del Cultivo</dt>
                    <dd class="col-sm-9">{{ $labor->cultivo->parcela->nombre ?? 'Sin asignar' }}</dd>
                    
                    <dt class="col-sm-3">Rol del Empleado</dt>
                    <dd class="col-sm-9">{{ $labor->empleado->rol->nombre ?? 'Sin asignar' }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection