@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Pedido #{{ $pedido->id }}</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>Cliente:</strong> {{ $pedido->cliente->nombre ?? 'N/A' }}</p>
            <p><strong>Fecha:</strong> {{ $pedido->fecha }}</p>
            <p><strong>Estado:</strong> {{ $pedido->estado }}</p>
            <p><strong>Transporte:</strong> {{ $pedido->transporte->placa ?? 'Sin asignar' }}</p>
            <h3>Productos</h3>
            <ul>
                @foreach($pedido->productos as $producto)
                <li>{{ $producto->nombre }} - Lote: {{ $producto->lote }}</li>
                @endforeach
            </ul>
            @if($pedido->factura)
            <h3>Factura #{{ $pedido->factura->numero_factura }}</h3>
            <p>Total: ${{ number_format($pedido->factura->total, 2) }}</p>
            @endif
            <a href="{{ route('pedidos.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>
</div>
@endsection