@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-truck"></i> Detalle de Ruta de Entrega</h1>
        @if(session('success'))
            <div class="alert alert-success-agricola">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger-agricola">{{ session('error') }}</div>
        @endif
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="tarjeta-info">
                    <h3>Información de la Ruta</h3>
                    <p><strong>ID:</strong> {{ $rutaEntrega->id }}</p>
                    <p><strong>Secuencia:</strong> {{ $rutaEntrega->secuencia }}</p>
                    <p><strong>Fecha de Creación:</strong> {{ $rutaEntrega->created_at->format('d/m/Y') }}</p>
                    <p><strong>Estado:</strong>
                        <span class="badge rounded-pill 
                            {{ $rutaEntrega->estado === 'completado' ? 'bg-success' : 
                              ($rutaEntrega->estado === 'en_proceso' ? 'bg-primary' : 
                                ($rutaEntrega->estado === 'pendiente' ? 'bg-secondary' : 'bg-danger')) }}">
                            {{ ucfirst($rutaEntrega->estado) }}
                        </span>
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="tarjeta-info">
                    <h3>Información del Pedido</h3>
                    <p><strong>Pedido #:</strong> {{ $rutaEntrega->pedido->id }}</p>
                    <p><strong>Cliente:</strong> {{ $rutaEntrega->pedido->cliente->nombre }}</p>
                    <p><strong>Fecha del Pedido:</strong> {{ $rutaEntrega->pedido->fecha }}</p>
                    <p><strong>Estado del Pedido:</strong>
                        <span class="badge rounded-pill 
                            {{ $rutaEntrega->pedido->estado === 'entregado' ? 'bg-success' : 
                              ($rutaEntrega->pedido->estado === 'enviado' ? 'bg-info' : 
                                ($rutaEntrega->pedido->estado === 'en_proceso' ? 'bg-primary' : 
                                  ($rutaEntrega->pedido->estado === 'pendiente' ? 'bg-secondary' : 'bg-danger'))) }}">
                            {{ ucfirst($rutaEntrega->pedido->estado) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
        
        <div class="tarjeta-info">
            <h3>Dirección de Entrega</h3>
            <p>{{ nl2br(e($rutaEntrega->direccion)) }}</p>
        </div>
        
        <div class="d-flex gap-2 mt-4">
            <a href="{{ route('rutas-entrega.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Volver al Listado</a>
            <a href="{{ route('rutas-entrega.edit', $rutaEntrega) }}" class="btn btn-outline-secondary"><i class="bi bi-pencil"></i> Editar</a>
            <form action="{{ route('rutas-entrega.destroy', $rutaEntrega) }}" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar esta ruta de entrega?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-outline-danger"><i class="bi bi-trash"></i> Eliminar</button>
            </form>
        </div>
    </div>
</div>
@endsection