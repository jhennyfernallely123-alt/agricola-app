@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-person-circle"></i> Cliente: {{ $cliente->nombre }}</h1>
        <div class="row mt-4">
            <div class="col-md-6">
                <p><strong><i class="bi bi-telephone"></i> Contacto:</strong> {{ $cliente->contacto ?? 'No registrado' }}</p>
                <p><strong><i class="bi bi-diagram-3"></i> Canal de Distribución:</strong> {{ $cliente->canal_distribucion ?? 'No registrado' }}</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="{{ route('clientes.edit', $cliente) }}" class="btn-accion btn-editar"><i class="bi bi-pencil"></i> Editar Cliente</a>
            </div>
        </div>

        <h3 class="mt-4"><i class="bi bi-cart3"></i> Pedidos del Cliente</h3>
        @if($cliente->pedidos->count() > 0)
            <table class="tabla-agricola mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cliente->pedidos as $pedido)
                    <tr>
                        <td>#{{ $pedido->id }}</td>
                        <td>{{ $pedido->fecha }}</td>
                        <td><span class="estado-badge estado-{{ $pedido->estado }}">{{ $pedido->estado }}</span></td>
                        <td>
                            <a href="{{ route('pedidos.show', $pedido) }}" class="btn-accion btn-ver"><i class="bi bi-eye"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-info mt-3">
                <i class="bi bi-info-circle"></i> Este cliente no tiene pedidos registrados.
            </div>
        @endif

        <div class="mt-4">
            <a href="{{ route('clientes.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Volver</a>
        </div>
    </div>
</div>
@endsection
