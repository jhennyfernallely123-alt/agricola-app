@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-bag"></i> Gestión de Fertilizantes</h1>
        @if(session('success'))
            <div class="alert alert-success-agricola">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger-agricola">{{ session('error') }}</div>
        @endif
        <a href="{{ route('fertilizantes.create') }}" class="btn btn-natural mb-3">
            <i class="bi bi-plus-lg"></i> Nuevo Fertilizante
        </a>
        <table class="tabla-agricola">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Descripción</th>
                    <th>Cultivos Asociados</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($fertilizantes as $fertilizante)
                <tr>
                    <td>{{ $fertilizante->id }}</td>
                    <td><strong>{{ $fertilizante->nombre }}</strong></td>
                    <td>{{ $fertilizante->tipo ?? 'N/A' }}</td>
                    <td>{{ $fertilizante->descripcion ?? 'N/A' }}</td>
                    <td><span class="badge rounded-pill bg-secondary">{{ $fertilizante->cultivos_count }}</span></td>
                    <td>
                        <a href="{{ route('fertilizantes.show', $fertilizante) }}" class="btn-accion btn-ver">
                            <i class="bi bi-eye"></i> Ver
                        </a>
                        <a href="{{ route('fertilizantes.edit', $fertilizante) }}" class="btn-accion btn-editar">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <form action="{{ route('fertilizantes.destroy', $fertilizante) }}" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar este fertilizante?')">
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