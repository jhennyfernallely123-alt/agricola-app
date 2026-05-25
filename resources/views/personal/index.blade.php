@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-people"></i> Gestión de Personal</h1>
        @if(session('success'))
            <div class="alert alert-success-agricola">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger-agricola">{{ session('error') }}</div>
        @endif
        <a href="{{ route('personal.create') }}" class="btn btn-natural mb-3">
            <i class="bi bi-person-plus"></i> Nuevo Personal
        </a>
        <table class="tabla-agricola">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Rol</th>
                    <th>Habilidades</th>
                    <th>Contrato</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($personal as $persona)
                <tr>
                    <td>{{ $persona->id }}</td>
                    <td><strong>{{ $persona->nombre }}</strong></td>
                    <td>{{ $persona->rol ? $persona->rol->nombre : 'Sin asignar' }}</td>
                    <td>{{ $persona->habilidades ?? 'N/A' }}</td>
                    <td>{{ $persona->contrato ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('personal.show', $persona) }}" class="btn-accion btn-ver">
                            <i class="bi bi-eye"></i> Ver
                        </a>
                        <a href="{{ route('personal.edit', $persona) }}" class="btn-accion btn-editar">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <form action="{{ route('personal.destroy', $persona) }}" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar este personal?')">
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