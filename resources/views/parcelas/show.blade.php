@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-geo-alt"></i> Detalle de Parcela</h1>
        <a href="{{ route('parcelas.index') }}" class="btn btn-secondary mb-3"><i class="bi bi-arrow-left"></i> Volver</a>
        
        <div class="row">
            <div class="col-md-6">
                <dl class="row">
                    <dt class="col-sm-3">ID</dt>
                    <dd class="col-sm-9">{{ $parcela->id }}</dd>
                    
                    <dt class="col-sm-3">Nombre</dt>
                    <dd class="col-sm-9"><strong>{{ $parcela->nombre }}</strong></dd>
                    
                    <dt class="col-sm-3">Área</dt>
                    <dd class="col-sm-9">{{ number_format($parcela->area, 2) }} ha</dd>
                    
                    <dt class="col-sm-3">Historial de Uso</dt>
                    <dd class="col-sm-9">{{ $parcela->historial_uso ?? 'No especificado' }}</dd>
                    
                    <dt class="col-sm-3">Análisis de Suelo</dt>
                    <dd class="col-sm-9">{{ $parcela->analisis_suelo ?? 'No especificado' }}</dd>
                    
                    <dt class="col-sm-3">Potencial Productivo</dt>
                    <dd class="col-sm-9">{{ $parcela->potencial_productivo ?? 'No especificado' }}</dd>
                </dl>
            </div>
            
            <div class="col-md-6">
                <h5>Cultivos Asociados</h5>
                @if($parcela->cultivos->isEmpty())
                    <p class="text-muted">No hay cultivos asociados a esta parcela.</p>
                @else
                    <table class="table table-sm tabla-agricola">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Variedad</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($parcela->cultivos as $cultivo)
                            <tr>
                                <td>{{ $cultivo->id }}</td>
                                <td>{{ $cultivo->nombre }}</td>
                                <td>{{ $cultivo->variedad ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('cultivos.show', $cultivo) }}" class="btn-accion btn-ver btn-sm">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
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