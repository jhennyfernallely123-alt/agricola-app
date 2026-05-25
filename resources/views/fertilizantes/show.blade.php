@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-bag"></i> Detalle de Fertilizante</h1>
        <a href="{{ route('fertilizantes.index') }}" class="btn btn-secondary mb-3"><i class="bi bi-arrow-left"></i> Volver</a>
        
        <div class="row">
            <div class="col-md-6">
                <dl class="row">
                    <dt class="col-sm-3">ID</dt>
                    <dd class="col-sm-9">{{ $fertilizante->id }}</dd>
                    
                    <dt class="col-sm-3">Nombre</dt>
                    <dd class="col-sm-9"><strong>{{ $fertilizante->nombre }}</strong></dd>
                    
                    <dt class="col-sm-3">Tipo</dt>
                    <dd class="col-sm-9">{{ $fertilizante->tipo ?? 'No especificado' }}</dd>
                    
                    <dt class="col-sm-3">Descripción</dt>
                    <dd class="col-sm-9">{{ $fertilizante->descripcion ?? 'No especificada' }}</dd>
                </dl>
            </div>
            
            <div class="col-md-6">
                <h5>Cultivos Asociados</h5>
                @if($fertilizante->cultivos->isEmpty())
                    <p class="text-muted">No hay cultivos asociados a este fertilizante.</p>
                @else
                    <table class="table table-sm tabla-agricola">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Parcela</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($fertilizante->cultivos as $cultivo)
                            <tr>
                                <td>{{ $cultivo->id }}</td>
                                <td>{{ $cultivo->nombre }}</td>
                                <td>{{ $cultivo->parcela->nombre ?? 'Sin asignar' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection