@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-person-badge"></i> Gestión de Roles</h1>
        @if(session('success'))
            <div class="alert alert-success-agricola">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger-agricola">{{ session('error') }}</div>
        @endif
        <a href="{{ route('roles.create') }}" class="btn btn-natural mb-3">
            <i class="bi bi-person-plus"></i> Nuevo Rol
        </a>
        <table class="tabla-agricola">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Personal Asociado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $rol)
                <tr>
                    <td>{{ $rol->id }}</td>
                    <td><strong>{{ $rol->nombre }}</strong></td>
                    <td>{{ $rol->descripcion ?? 'N/A' }}</td>
                    <td><span class="badge rounded-pill bg-secondary">{{ $rol->personales_count }}</span></td>
                    <td>
                        <a href="{{ route('roles.show', $rol) }}" class="btn-accion btn-ver">
                            <i class="bi bi-eye"></i> Ver
                        </a>
                        <a href="{{ route('roles.edit', $rol) }}" class="btn-accion btn-editar">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <form action="{{ route('roles.destroy', $rol) }}" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar este rol?')">
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