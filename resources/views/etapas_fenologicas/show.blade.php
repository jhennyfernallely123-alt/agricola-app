@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-graph-up-arrow"></i> Detalle de Etapa Fenológica</h1>
        <a href="{{ route('etapas-fenologicas.index') }}" class="btn btn-secondary mb-3"><i class="bi bi-arrow-left"></i> Volver</a>
        
        <div class="row">
            <div class="col-md-6">
                <dl class="row">
                    <dt class="col-sm-3">ID</dt>
                    <dd class="col-sm-9">{{ $etapa->id }}</dd>
                    
                    <dt class="col-sm-3">Cultivo</dt>
                    <dd class="col-sm-9"><strong>{{ $etapa->cultivo->nombre }}</strong></dd>
                    
                    <dt class="col-sm-3">Nombre de la Etapa</dt>
                    <dd class="col-sm-9"><strong>{{ $etapa->nombre }}</strong></dd>
                    
                    <dt class="col-sm-3">Fecha de Inicio</dt>
                    <dd class="col-sm-9">{{ $etapa->fecha_inicio }}</dd>
                    
                    <dt class="col-sm-3">Requerimientos Específicos</dt>
                    <dd class="col-sm-9">{{ $etapa->requerimientos_especificos ?? 'No especificados' }}</dd>
                </dl>
            </div>
            
            <div class="col-md-6">
                <h5>Planes de Fertilización Asociados</h5>
                @if($etapa->planesFertilizacion->isEmpty())
                    <p class="text-muted">No hay planes de fertilización asociados a esta etapa fenológica.</p>
                @else
                    <table class="table table-sm tabla-agricola">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Cultivo</th>
                                <th>Fertilizante</th>
                                <th>Dosis</th>
                                <th>Método</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($etapa->planesFertilizacion as $plan)
                            <tr>
                                <td>{{ $plan->id }}</td>
                                <td>{{ $plan->cultivo->nombre }}</td>
                                <td>{{ $plan->insumoAgricola->nombre ?? 'Sin asignar' }}</td>
                                <td>{{ $plan->dosis }}</td>
                                <td>{{ $plan->metodo ?? 'No especificado' }}</td>
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