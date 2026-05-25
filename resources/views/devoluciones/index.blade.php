@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-arrow-repeat"></i> Gestión de Devoluciones</h1>
        @if(session('success'))
            <div class="alert alert-success-agricola">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger-agricola">{{ session('error') }}</div>
        @endif
        <a href="{{ route('devoluciones.create') }}" class="btn btn-natural mb-3">
            <i class="bi bi-plus"></i> Nueva Devolución
        </a>
        <table class="tabla-agricola">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pedido</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Motivo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($devoluciones as $devolucion)
                <tr>
                    <td>{{ $devolucion->id }}</td>
                    <td>#{{ $devolucion->pedido->id }} - {{ $devolucion->pedido->cliente->nombre }}</td>
                    <td>{{ $devolucion->producto->nombre }}</td>
                    <td>{{ number_format($devolucion->cantidad, 2) }} kg</td>
                    <td>{{ strlen($devolucion->motivo) > 50 ? substr($devolucion->motivo, 0, 50) . '...' : $devolucion->motivo }}</td>
                    <td>
                        <span class="badge rounded-pill 
                            {{ $devolucion->estado === 'aprobado' ? 'bg-success' : 
                              ($devolucion->estado === 'procesado' ? 'bg-info' : 
                                ($devolucion->estado === 'rechazado' ? 'bg-danger' : 'bg-secondary')) }}">
                            {{ ucfirst($devolucion->estado) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('devoluciones.show', $devolucion) }}" class="btn-accion btn-ver">
                            <i class="bi bi-eye"></i> Ver
                        </a>
                        <a href="{{ route('devoluciones.edit', $devolucion) }}" class="btn-accion btn-editar">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <form action="{{ route('devoluciones.destroy', $devolucion) }}" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar esta devolución?')">
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