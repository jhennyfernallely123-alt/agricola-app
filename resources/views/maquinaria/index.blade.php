@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-truck"></i> Gestión de Maquinaria</h1>
        @if(session('success'))
            <div class="alert alert-success-agricola">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger-agricola">{{ session('error') }}</div>
        @endif
        <a href="{{ route('maquinaria.create') }}" class="btn btn-natural mb-3">
            <i class="bi bi-truck-plus"></i> Nueva Maquinaria
        </a>
        <table class="tabla-agricola">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Mantenimiento</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($maquinarias as $maquina)
                <tr>
                    <td>{{ $maquina->id }}</td>
                    <td><strong>{{ $maquina->nombre }}</strong></td>
                    <td>{{ $maquina->tipo ?? 'N/A' }}</td>
                    <td>{{ $maquina->mantenimiento ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('maquinaria.show', $maquina) }}" class="btn-accion btn-ver">
                            <i class="bi bi-eye"></i> Ver
                        </a>
                        <a href="{{ route('maquinaria.edit', $maquina) }}" class="btn-accion btn-editar">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <form action="{{ route('maquinaria.destroy', $maquina) }}" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar esta maquinaria?')">
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