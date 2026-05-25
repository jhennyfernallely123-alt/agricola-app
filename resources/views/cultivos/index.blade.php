@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-leaf"></i> Gestión de Cultivos</h1>
        @if(session('success'))
            <div class="alert alert-success-agricola">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger-agricola">{{ session('error') }}</div>
        @endif
        <a href="{{ route('cultivos.create') }}" class="btn btn-natural mb-3">
            <i class="bi bi-plus-lg"></i> Nuevo Cultivo
        </a>
        <table class="tabla-agricola">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Variedad</th>
                    <th>Requerimientos</th>
                    <th>Parcela</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cultivos as $cultivo)
                <tr>
                    <td>{{ $cultivo->id }}</td>
                    <td><strong>{{ $cultivo->nombre }}</strong></td>
                    <td>{{ $cultivo->variedad ?? 'N/A' }}</td>
                    <td>{{ $cultivo->requerimientos ?? 'N/A' }}</td>
                    <td>{{ $cultivo->parcela->nombre ?? 'Sin asignar' }}</td>
                    <td>
                        <a href="{{ route('cultivos.show', $cultivo) }}" class="btn-accion btn-ver">
                            <i class="bi bi-eye"></i> Ver
                        </a>
                        <a href="{{ route('cultivos.edit', $cultivo) }}" class="btn-accion btn-editar">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <form action="{{ route('cultivos.destroy', $cultivo) }}" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar este cultivo?')">
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