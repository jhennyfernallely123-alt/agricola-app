@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-bug"></i> Gestión de Control de Plagas</h1>
        @if(session('success'))
            <div class="alert alert-success-agricola">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger-agricola">{{ session('error') }}</div>
        @endif
        <a href="{{ route('plagas.create') }}" class="btn btn-natural mb-3">
            <i class="bi bi-plus-lg"></i> Nuevo Control de Plagas
        </a>
        <table class="tabla-agricola">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cultivo</th>
                    <th>Tipo</th>
                    <th>Nombre</th>
                    <th>Fecha Detección</th>
                    <th>Tratamiento Aplicado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($controles as $control)
                <tr>
                    <td>{{ $control->id }}</td>
                    <td>{{ $control->cultivo->nombre }}</td>
                    <td><strong>{{ $control->tipo }}</strong></td>
                    <td>{{ $control->nombre }}</td>
                    <td>{{ $control->fecha_deteccion }}</td>
                    <td>{{ $control->tratamiento_aplicado ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('plagas.show', $control) }}" class="btn-accion btn-ver">
                            <i class="bi bi-eye"></i> Ver
                        </a>
                        <a href="{{ route('plagas.edit', $control) }}" class="btn-accion btn-editar">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <form action="{{ route('plagas.destroy', $control) }}" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar este control de plagas?')">
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