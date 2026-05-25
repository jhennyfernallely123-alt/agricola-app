@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-calendar-check"></i> Gestión de Planes de Cultivo</h1>
        @if(session('success'))
            <div class="alert alert-success-agricola">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger-agricola">{{ session('error') }}</div>
        @endif
        <a href="{{ route('planes-cultivo.create') }}" class="btn btn-natural mb-3">
            <i class="bi bi-plus-lg"></i> Nuevo Plan de Cultivo
        </a>
        <table class="tabla-agricola">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cultivo</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin Prevista</th>
                    <th>Objetivo Producción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($planes as $plan)
                <tr>
                    <td>{{ $plan->id }}</td>
                    <td>{{ $plan->cultivo->nombre }}</td>
                    <td>{{ $plan->fecha_inicio }}</td>
                    <td>{{ $plan->fecha_fin_prevista }}</td>
                    <td>{{ $plan->objetivo_produccion ?? '0.00' }}</td>
                    <td>
                        <a href="{{ route('planes-cultivo.show', $plan) }}" class="btn-accion btn-ver">
                            <i class="bi bi-eye"></i> Ver
                        </a>
                        <a href="{{ route('planes-cultivo.edit', $plan) }}" class="btn-accion btn-editar">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <form action="{{ route('planes-cultivo.destroy', $plan) }}" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar este plan de cultivo?')">
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