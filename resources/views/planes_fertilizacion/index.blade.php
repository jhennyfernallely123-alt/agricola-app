@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-bag-plus"></i> Gestión de Planes de Fertilización</h1>
        @if(session('success'))
            <div class="alert alert-success-agricola">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger-agricola">{{ session('error') }}</div>
        @endif
        <a href="{{ route('planes-fertilizacion.create') }}" class="btn btn-natural mb-3">
            <i class="bi bi-plus-lg"></i> Nuevo Plan de Fertilización
        </a>
        <table class="tabla-agricola">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cultivo</th>
                    <th>Fertilizante</th>
                    <th>Etapa Fenológica</th>
                    <th>Dosis</th>
                    <th>Método</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($planes as $plan)
                <tr>
                    <td>{{ $plan->id }}</td>
                    <td>{{ $plan->cultivo->nombre }}</td>
                    <td>{{ $plan->insumoAgricola->nombre }}</td>
                    <td>{{ $plan->etapaFenologica->nombre ?? 'No especificada' }}</td>
                    <td>{{ $plan->dosis }}</td>
                    <td>{{ $plan->metodo ?? 'No especificado' }}</td>
                    <td>
                        <a href="{{ route('planes-fertilizacion.show', $plan) }}" class="btn-accion btn-ver">
                            <i class="bi bi-eye"></i> Ver
                        </a>
                        <a href="{{ route('planes-fertilizacion.edit', $plan) }}" class="btn-accion btn-editar">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <form action="{{ route('planes-fertilizacion.destroy', $plan) }}" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar este plan de fertilización?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-accion btn-eliminar"><i class="bi bi-trash"></i> Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection