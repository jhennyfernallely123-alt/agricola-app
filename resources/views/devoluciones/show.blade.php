@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-arrow-repeat"></i> Detalle de Devolución</h1>
        @if(session('success'))
            <div class="alert alert-success-agricola">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger-agricola">{{ session('error') }}</div>
        @endif
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="tarjeta-info">
                    <h3>Información de la Devolución</h3>
                    <p><strong>ID:</strong> {{ $devolucion->id }}</p>
                    <p><strong>Cantidad:</strong> {{ number_format($devolucion->cantidad, 2) }} kg</p>
                    <p><strong>Fecha:</strong> {{ $devolucion->created_at->format('d/m/Y') }}</p>
                    <p><strong>Estado:</strong>
                        <span class="badge rounded-pill 
                            {{ $devolucion->estado === 'aprobado' ? 'bg-success' : 
                              ($devolucion->estado === 'procesado' ? 'bg-info' : 
                                ($devolucion->estado === 'rechazado' ? 'bg-danger' : 'bg-secondary')) }}">
                            {{ ucfirst($devolucion->estado) }}
                        </span>
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="tarjeta-info">
                    <h3>Información del Pedido</h3>
                    <p><strong>Pedido #:</strong> {{ $devolucion->pedido->id }}</p>
                    <p><strong>Cliente:</strong> {{ $devolucion->pedido->cliente->nombre }}</p>
                    <p><strong>Fecha del Pedido:</strong> {{ $devolucion->pedido->fecha }}</p>
                    <p><strong>Estado del Pedido:</strong>
                        <span class="badge rounded-pill 
                            {{ $devolucion->pedido->estado === 'entregado' ? 'bg-success' : 
                              ($devolucion->pedido->estado === 'enviado' ? 'bg-info' : 
                                ($devolucion->pedido->estado === 'en_proceso' ? 'bg-primary' : 
                                  ($devolucion->pedido->estado === 'pendiente' ? 'bg-secondary' : 'bg-danger'))) }}">
                            {{ ucfirst($devolucion->pedido->estado) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
        
        <div class="tarjeta-info">
            <h3>Información del Producto</h3>
            <p><strong>Producto:</strong> {{ $devolucion->producto->nombre }}</p>
            <p><strong>Descripción:</strong> {{ $devolucion->producto->descripcion ?? 'No disponible' }}</p>
            <p><strong>Precio Unitario:</strong> ${{ number_format($devolucion->producto->precio, 2) }} por kg</p>
            <p><strong>Valor de la Devolución:</strong> ${{ number_format($devolucion->cantidad * $devolucion->producto->precio, 2) }}</p>
        </div>
        
        <div class="tarjeta-info">
            <h3>Motivo de la Devolución</h3>
            <p>{{ nl2br(e($devolucion->motivo)) }}</p>
        </div>
        
        <div class="d-flex gap-2 mt-4">
            <a href="{{ route('devoluciones.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Volver al Listado</a>
            <a href="{{ route('devoluciones.edit', $devolucion) }}" class="btn btn-outline-secondary"><i class="bi bi-pencil"></i> Editar</a>
            <form action="{{ route('devoluciones.destroy', $devolucion) }}" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar esta devolución?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-outline-danger"><i class="bi bi-trash"></i> Eliminar</button>
            </form>
        </div>
    </div>
</div>
@endsection