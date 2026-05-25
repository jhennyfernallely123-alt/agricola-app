@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-wrench"></i> Gestión de Mantenimientos</h1>
        @if(session('success'))
            <div class="alert alert-success-agricola">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger-agricola">{{ session('error') }}</div>
        @endif
        <a href="{{ route('mantenimiento.create') }}" class="btn btn-natural mb-3">
            <i class="bi bi-plus-lg"></i> Nuevo Mantenimiento
        </a>
        <table class="tabla-agricola">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Maquinaria</th>
                    <th>Fecha</th>
                    <th>Tipo</th>
                    <th>Costo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mantenimientos as $mantenimiento)
                <tr>
                    <td>{{ $mantenimiento->id }}</td>
                    <td><strong>{{ $mantenimiento->maquinaria->nombre }}</strong></td>
                    <td>{{ $mantenimiento->fecha }}</td>
                    <td>{{ $mantenimiento->tipo }}</td>
                    <td>${{ number_format($mantenimiento->costo, 2) }}</td>
                    <td>
                        <a href="{{ route('mantenimiento.show', $mantenimiento) }}" class="btn-accion btn-ver">
                            <i class="bi bi-eye"></i> Ver
                        </a>
                        <a href="{{ route('mantenimiento.edit', $mantenimiento) }}" class="btn-accion btn-editar">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <form action="{{ route('mantenimiento.destroy', $mantenimiento) }}" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar este mantenimiento?')">
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