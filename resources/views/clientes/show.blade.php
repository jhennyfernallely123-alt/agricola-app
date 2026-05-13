@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Cliente: {{ $cliente->nombre }}</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>Contacto:</strong> {{ $cliente->contacto ?? 'N/A' }}</p>
            <p><strong>Canal de Distribución:</strong> {{ $cliente->canal_distribucion ?? 'N/A' }}</p>
            <h3>Pedidos del Cliente</h3>
            @if($cliente->pedidos->count() > 0)
            <table class="table">
                <thead>
                    <tr><th>ID</th><th>Fecha</th><th>Estado</th></tr>
                </thead>
                <tbody>
                    @foreach($cliente->pedidos as $pedido)
                    <tr>
                        <td>{{ $pedido->id }}</td>
                        <td>{{ $pedido->fecha }}</td>
                        <td>{{ $pedido->estado }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p>Este cliente no tiene pedidos.</p>
            @endif
            <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Volver</a>
            <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-warning">Editar</a>
        </div>
    </div>
</div>
@endsection