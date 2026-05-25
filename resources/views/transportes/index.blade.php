@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-truck"></i> Gestión de Transportes</h1>
        @if(session('success'))
            <div class="alert alert-success-agricola">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger-agricola">{{ session('error') }}</div>
        @endif
        <a href="{{ route('transportes.create') }}" class="btn btn-natural mb-3">
            <i class="bi bi-plus"></i> Nuevo Transporte
        </a>
        <table class="tabla-agricola">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo</th>
                    <th>Placa</th>
                    <th>Capacidad</th>
                    <th>Pedidos Asociados</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transportes as $transporte)
                <tr>
                    <td>{{ $transporte->id }}</td>
                    <td>{{ $transporte->tipo }}</td>
                    <td>{{ $transporte->placa ?? 'No asignada' }}</td>
                    <td>{{ $transporte->capacidad ?? 'No especificada' }} kg</td>
                    <td><span class="badge rounded-pill bg-secondary">{{ $transporte->pedidos_count }}</span></td>
                    <td>
                        <a href="{{ route('transportes.show', $transporte) }}" class="btn-accion btn-ver">
                            <i class="bi bi-eye"></i> Ver
                        </a>
                        <a href="{{ route('transportes.edit', $transporte) }}" class="btn-accion btn-editar">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <form action="{{ route('transportes.destroy', $transporte) }}" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar este transporte?')">
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