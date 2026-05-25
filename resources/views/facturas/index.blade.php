@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-file-earmark-text"></i> Gestión de Facturas</h1>
        @if(session('success'))
            <div class="alert alert-success-agricola">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger-agricola">{{ session('error') }}</div>
        @endif
        <a href="{{ route('facturas.create') }}" class="btn btn-natural mb-3">
            <i class="bi bi-file-earmark-plus"></i> Nueva Factura
        </a>
        <table class="tabla-agricola">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pedido</th>
                    <th>Número Factura</th>
                    <th>Subtotal</th>
                    <th>Total</th>
                    <th>Estado Pago</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($facturas as $factura)
                <tr>
                    <td>{{ $factura->id }}</td>
                    <td>#{{ $factura->pedido->id }} - {{ $factura->pedido->cliente->nombre }}</td>
                    <td>{{ $factura->numero_factura }}</td>
                    <td>${{ number_format($factura->subtotal, 2) }}</td>
                    <td>${{ number_format($factura->total, 2) }}</td>
                    <td>
                        <span class="badge rounded-pill 
                            {{ $factura->estado_pago === 'pagado' ? 'bg-success' : 
                              ($factura->estado_pago === 'parcial' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                            {{ ucfirst($factura->estado_pago) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('facturas.show', $factura) }}" class="btn-accion btn-ver">
                            <i class="bi bi-eye"></i> Ver
                        </a>
                        <a href="{{ route('facturas.edit', $factura) }}" class="btn-accion btn-editar">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <form action="{{ route('facturas.destroy', $factura) }}" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar esta factura?')">
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