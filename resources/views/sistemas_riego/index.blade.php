@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-droplet"></i> Gestión de Sistemas de Riego</h1>
        @if(session('success'))
            <div class="alert alert-success-agricola">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger-agricola">{{ session('error') }}</div>
        @endif
        <a href="{{ route('sistemas-riego.create') }}" class="btn btn-natural mb-3">
            <i class="bi bi-plus-lg"></i> Nuevo Sistema de Riego
        </a>
        <table class="tabla-agricola">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo</th>
                    <th>Fuente</th>
                    <th>Cultivos Asociados</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sistemas as $sistema)
                <tr>
                    <td>{{ $sistema->id }}</td>
                    <td><strong>{{ $sistema->tipo }}</strong></td>
                    <td>{{ $sistema->fuente ?? 'N/A' }}</td>
                    <td><span class="badge rounded-pill bg-secondary">{{ $sistema->cultivos_count }}</span></td>
                    <td>
                        <a href="{{ route('sistemas-riego.show', $sistema) }}" class="btn-accion btn-ver">
                            <i class="bi bi-eye"></i> Ver
                        </a>
                        <a href="{{ route('sistemas-riego.edit', $sistema) }}" class="btn-accion btn-editar">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <form action="{{ route('sistemas-riego.destroy', $sistema) }}" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar este sistema de riego?')">
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