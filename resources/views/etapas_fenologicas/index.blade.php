@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-graph-up-arrow"></i> Gestión de Etapas Fenológicas</h1>
        @if(session('success'))
            <div class="alert alert-success-agricola">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger-agricola">{{ session('error') }}</div>
        @endif
        <a href="{{ route('etapas-fenologicas.create') }}" class="btn btn-natural mb-3">
            <i class="bi bi-plus-lg"></i> Nueva Etapa Fenológica
        </a>
        <table class="tabla-agricola">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cultivo</th>
                    <th>Nombre</th>
                    <th>Fecha Inicio</th>
                    <th>Requerimientos Específicos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($etapas as $etapa)
                <tr>
                    <td>{{ $etapa->id }}</td>
                    <td>{{ $etapa->cultivo->nombre }}</td>
                    <td><strong>{{ $etapa->nombre }}</strong></td>
                    <td>{{ $etapa->fecha_inicio }}</td>
                    <td>{{ $etapa->requerimientos_especificos ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('etapas-fenologicas.show', $etapa) }}" class="btn-accion btn-ver">
                            <i class="bi bi-eye"></i> Ver
                        </a>
                        <a href="{{ route('etapas-fenologicas.edit', $etapa) }}" class="btn-accion btn-editar">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <form action="{{ route('etapas-fenologicas.destroy', $etapa) }}" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar esta etapa fenológica?')">
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