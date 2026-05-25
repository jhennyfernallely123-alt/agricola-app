@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-truck"></i> Detalle de Transporte</h1>
        @if(session('success'))
            <div class="alert alert-success-agricola">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger-agricola">{{ session('error') }}</div>
        @endif
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="tarjeta-info">
                    <h3>Información del Transporte</h3>
                    <p><strong>ID:</strong> {{ $transporte->id }}</p>
                    <p><strong>Tipo:</strong> {{ $transporte->tipo }}</p>
                    <p><strong>Placa:</strong> {{ $transporte->placa ?? 'No asignada' }}</p>
                    <p><strong>Capacidad:</strong> {{ $transporte->capacidad ?? 'No especificada' }} kg</p>
                    <p><strong>Fecha de Registro:</strong> {{ $transporte->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="tarjeta-info">
                    <h3>Pedidos Asociados</h3>
                    @if($transporte->pedidos->isEmpty())
                        <p>No hay pedidos asociados a este transporte.</p>
                    @else
                        <table class="tabla-agricola">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cliente</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transporte->pedidos as $pedido)
                                <tr>
                                    <td>{{ $pedido->id }}</td>
                                    <td>{{ $pedido->cliente->nombre }}</td>
                                    <td>{{ $pedido->fecha }}</td>
                                    <td>
                                        <span class="badge rounded-pill 
                                            {{ $pedido->estado === 'entregado' ? 'bg-success' : 
                                              ($pedido->estado === 'enviado' ? 'bg-info' : 
                                                ($pedido->estado === 'en_proceso' ? 'bg-primary' : 
                                                  ($pedido->estado === 'pendiente' ? 'bg-secondary' : 'bg-danger'))) }}">
                                            {{ ucfirst($pedido->estado) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="d-flex gap-2 mt-4">
            <a href="{{ route('transportes.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Volver al Listado</a>
            <a href="{{ route('transportes.edit', $transporte) }}" class="btn btn-outline-secondary"><i class="bi bi-pencil"></i> Editar</a>
            <form action="{{ route('transportes.destroy', $transporte) }}" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar este transporte?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-outline-danger"><i class="bi bi-trash"></i> Eliminar</button>
            </form>
        </div>
    </div>
</div>
@endsection