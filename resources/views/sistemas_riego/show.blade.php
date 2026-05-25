@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-droplet"></i> Detalle de Sistema de Riego</h1>
        <a href="{{ route('sistemas-riego.index') }}" class="btn btn-secondary mb-3"><i class="bi bi-arrow-left"></i> Volver</a>
        
        <div class="row">
            <div class="col-md-6">
                <dl class="row">
                    <dt class="col-sm-3">ID</dt>
                    <dd class="col-sm-9">{{ $sistema->id }}</dd>
                    
                    <dt class="col-sm-3">Tipo</dt>
                    <dd class="col-sm-9"><strong>{{ $sistema->tipo }}</strong></dd>
                    
                    <dt class="col-sm-3">Fuente de Agua</dt>
                    <dd class="col-sm-9">{{ $sistema->fuente ?? 'No especificada' }}</dd>
                </dl>
            </div>
            
            <div class="col-md-6">
                <h5>Cultivos Asociados</h5>
                @if($sistema->cultivos->isEmpty())
                    <p class="text-muted">No hay cultivos asociados a este sistema de riego.</p>
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
                            @foreach($sistema->cultivos as $cultivo)
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