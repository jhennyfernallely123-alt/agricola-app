@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-leaf"></i> Detalle de Cultivo</h1>
        <a href="{{ route('cultivos.index') }}" class="btn btn-secondary mb-3"><i class="bi bi-arrow-left"></i> Volver</a>
        
        <div class="row">
            <div class="col-md-6">
                <dl class="row">
                    <dt class="col-sm-3">ID</dt>
                    <dd class="col-sm-9">{{ $cultivo->id }}</dd>
                    
                    <dt class="col-sm-3">Nombre</dt>
                    <dd class="col-sm-9"><strong>{{ $cultivo->nombre }}</strong></dd>
                    
                    <dt class="col-sm-3">Variedad</dt>
                    <dd class="col-sm-9">{{ $cultivo->variedad ?? 'No especificada' }}</dd>
                    
                    <dt class="col-sm-3">Requerimientos</dt>
                    <dd class="col-sm-9">{{ $cultivo->requerimientos ?? 'No especificados' }}</dd>
                    
                    <dt class="col-sm-3">Parcela</dt>
                    <dd class="col-sm-9">{{ $cultivo->parcela->nombre ?? 'Sin asignar' }}</dd>
                </dl>
            </div>
            
            <div class="col-md-6">
                <h5>Relaciones</h5>
                <div class="accordion" id="cultivoRelations">
                    <!-- Etapas Fenológicas -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingEtapas">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEtapas" aria-expanded="false" aria-controls="collapseEtapas">
                                Etapas Fenológicas ({{ $cultivo->etapasFenologicas->count() }})
                            </button>
                        </h2>
                        <div id="collapseEtapas" class="accordion-collapse collapse" aria-labelledby="headingEtapas" data-bs-parent="#cultivoRelations">
                            <div class="accordion-body">
                                @if($cultivo->etapasFenologicas->isEmpty())
                                    <p class="text-muted">No hay etapas fenológicas registradas.</p>
                                @else
                                    <table class="table table-sm tabla-agricola">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nombre</th>
                                                <th>Fecha Inicio</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cultivo->etapasFenologicas as $etapa)
                                            <tr>
                                                <td>{{ $etapa->id }}</td>
                                                <td>{{ $etapa->nombre }}</td>
                                                <td>{{ $etapa->fecha_inicio }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Labores Agrícolas -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingLabores">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLabores" aria-expanded="false" aria-controls="collapseLabores">
                                Labores Agrícolas ({{ $cultivo->laboresAgricolas->count() }})
                            </button>
                        </h2>
                        <div id="collapseLabores" class="accordion-collapse collapse" aria-labelledby="headingLabores" data-bs-parent="#cultivoRelations">
                            <div class="accordion-body">
                                @if($cultivo->laboresAgricolas->isEmpty())
                                    <p class="text-muted">No hay labores agrícolas registradas.</p>
                                @else
                                    <table class="table table-sm tabla-agricola">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Tipo</th>
                                                <th>Fecha</th>
                                                <th>Costo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cultivo->laboresAgricolas as $labor)
                                            <tr>
                                                <td>{{ $labor->id }}</td>
                                                <td>{{ $labor->tipo }}</td>
                                                <td>{{ $labor->fecha }}</td>
                                                <td>{{ $labor->costo ?? '0.00' }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Planes de Fertilización -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFertilizacion">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFertilizacion" aria-expanded="false" aria-controls="collapseFertilizacion">
                                Planes de Fertilización ({{ $cultivo->planesFertilizacion->count() }})
                            </button>
                        </h2>
                        <div id="collapseFertilizacion" class="accordion-collapse collapse" aria-labelledby="headingFertilizacion" data-bs-parent="#cultivoRelations">
                            <div class="accordion-body">
                                @if($cultivo->planesFertilizacion->isEmpty())
                                    <p class="text-muted">No hay planes de fertilización registrados.</p>
                                @else
                                    <table class="table table-sm tabla-agricola">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Fertilizante</th>
                                                <th>Dosis</th>
                                                <th>Método</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cultivo->planesFertilizacion as $plan)
                                            <tr>
                                                <td>{{ $plan->id }}</td>
                                                <td>{{ $plan->fertilizante->nombre ?? 'Sin asignar' }}</td>
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
                    
                    <!-- Control de Plagas -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingPlagas">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePlagas" aria-expanded="false" aria-controls="collapsePlagas">
                                Control de Plagas ({{ $cultivo->controlesPlagas->count() }})
                            </button>
                        </h2>
                        <div id="collapsePlagas" class="accordion-collapse collapse" aria-labelledby="headingPlagas" data-bs-parent="#cultivoRelations">
                            <div class="accordion-body">
                                @if($cultivo->controlesPlagas->isEmpty())
                                    <p class="text-muted">No hay registros de control de plagas.</p>
                                @else
                                    <table class="table table-sm tabla-agricola">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Tipo</th>
                                                <th>Nombre</th>
                                                <th>Fecha Detección</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cultivo->controlesPlagas as $control)
                                            <tr>
                                                <td>{{ $control->id }}</td>
                                                <td>{{ $control->tipo }}</td>
                                                <td>{{ $control->nombre }}</td>
                                                <td>{{ $control->fecha_deteccion }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Planes de Cultivo -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingPlanesCultivo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePlanesCultivo" aria-expanded="false" aria-controls="collapsePlanesCultivo">
                                Planes de Cultivo ({{ $cultivo->planesCultivo->count() }})
                            </button>
                        </h2>
                        <div id="collapsePlanesCultivo" class="accordion-collapse collapse" aria-labelledby="headingPlanesCultivo" data-bs-parent="#cultivoRelations">
                            <div class="accordion-body">
                                @if($cultivo->planesCultivo->isEmpty())
                                    <p class="text-muted">No hay planes de cultivo registrados.</p>
                                @else
                                    <table class="table table-sm tabla-agricola">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Fecha Inicio</th>
                                                <th>Fecha Fin Prevista</th>
                                                <th>Objetivo Producción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cultivo->planesCultivo as $plan)
                                            <tr>
                                                <td>{{ $plan->id }}</td>
                                                <td>{{ $plan->fecha_inicio }}</td>
                                                <td>{{ $plan->fecha_fin_prevista }}</td>
                                                <td>{{ $plan->objetivo_produccion ?? '0.00' }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Sistemas de Riego -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingRiego">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRiego" aria-expanded="false" aria-controls="collapseRiego">
                                Sistemas de Riego ({{ $cultivo->sistemasRiego->count() }})
                            </button>
                        </h2>
                        <div id="collapseRiego" class="accordion-collapse collapse" aria-labelledby="headingRiego" data-bs-parent="#cultivoRelations">
                            <div class="accordion-body">
                                @if($cultivo->sistemasRiego->isEmpty())
                                    <p class="text-muted">No hay sistemas de riego asociados.</p>
                                @else
                                    <table class="table table-sm tabla-agricola">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Tipo</th>
                                                <th>Fuente</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cultivo->sistemasRiego as $sistema)
                                            <tr>
                                                <td>{{ $sistema->id }}</td>
                                                <td>{{ $sistema->tipo }}</td>
                                                <td>{{ $sistema->fuente ?? 'No especificada' }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Insumos Agrícolas -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingInsumos">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInsumos" aria-expanded="false" aria-controls="collapseInsumos">
                                Insumos Agrícolas ({{ $cultivo->insumosAgricolas->count() }})
                            </button>
                        </h2>
                        <div id="collapseInsumos" class="accordion-collapse collapse" aria-labelledby="headingInsumos" data-bs-parent="#cultivoRelations">
                            <div class="accordion-body">
                                @if($cultivo->insumosAgricolas->isEmpty())
                                    <p class="text-muted">No hay insumos agrícolas asociados.</p>
                                @else
                                    <table class="table table-sm tabla-agricola">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nombre</th>
                                                <th>Tipo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cultivo->insumosAgricolas as $insumo)
                                            <tr>
                                                <td>{{ $insumo->id }}</td>
                                                <td>{{ $insumo->nombre }}</td>
                                                <td>{{ $insumo->tipo ?? 'No especificado' }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection