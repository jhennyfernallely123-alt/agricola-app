@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-truck"></i> Gestión de Rutas de Entrega</h1>
        @if(session('success'))
            <div class="alert alert-success-agricola">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger-agricola">{{ session('error') }}</div>
        @endif
        <a href="{{ route('rutas-entrega.create') }}" class="btn btn-natural mb-3">
            <i class="bi bi-plus"></i> Nueva Ruta de Entrega
        </a>
        <table class="tabla-agricola">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pedido</th>
                    <th>Secuencia</th>
                    <th>Dirección</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rutasEntrega as $ruta)
                <tr>
                    <td>{{ $ruta->id }}</td>
                    <td>#{{ $ruta->pedido->id }} - {{ $ruta->pedido->cliente->nombre }}</td>
                    <td>{{ $ruta->secuencia }}</td>
                    <td>{{ strlen($ruta->direccion) > 50 ? substr($ruta->direccion, 0, 50) . '...' : $ruta->direccion }}</td>
                    <td>
                        <span class="badge rounded-pill 
                            {{ $ruta->estado === 'completado' ? 'bg-success' : 
                              ($ruta->estado === 'en_proceso' ? 'bg-primary' : 
                                ($ruta->estado === 'pendiente' ? 'bg-secondary' : 'bg-danger')) }}">
                            {{ ucfirst($ruta->estado) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('rutas-entrega.show', $ruta) }}" class="btn-accion btn-ver">
                            <i class="bi bi-eye"></i> Ver
                        </a>
                        <a href="{{ route('rutas-entrega.edit', $ruta) }}" class="btn-accion btn-editar">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <form action="{{ route('rutas-entrega.destroy', $ruta) }}" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar esta ruta de entrega?')">
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