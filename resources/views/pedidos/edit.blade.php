@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Pedido #{{ $pedido->id }}</h1>
    <form action="{{ route('pedidos.update', $pedido) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label for="cliente_id" class="form-label">Cliente</label>
            <select name="cliente_id" id="cliente_id" class="form-select" required>
                @foreach($clientes as $cliente)
                <option value="{{ $cliente->id }}" @selected(old('cliente_id', $pedido->cliente_id)==$cliente->id)>{{ $cliente->nombre }}</option>
                @endforeach
            </select>
            @error('cliente_id') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" name="fecha" id="fecha" class="form-control" value="{{ old('fecha', $pedido->fecha) }}" required>
            @error('fecha') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select name="estado" id="estado" class="form-select" required>
                @foreach(['pendiente','en_proceso','enviado','entregado','cancelado'] as $est)
                <option value="{{ $est }}" @selected(old('estado', $pedido->estado)==$est)>{{ ucfirst($est) }}</option>
                @endforeach
            </select>
            @error('estado') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label for="transporte_id" class="form-label">Transporte</label>
            <select name="transporte_id" id="transporte_id" class="form-select">
                <option value="">Sin transporte</option>
                @foreach($transportes as $transporte)
                <option value="{{ $transporte->id }}" @selected(old('transporte_id', $pedido->transporte_id)==$transporte->id)>{{ $transporte->placa }} - {{ $transporte->tipo }}</option>
                @endforeach
            </select>
            @error('transporte_id') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Pedido</button>
        <a href="{{ route('pedidos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection