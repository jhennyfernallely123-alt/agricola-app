@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Nuevo Pedido</h1>
    <form action="{{ route('pedidos.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="cliente_id" class="form-label">Cliente</label>
            <select name="cliente_id" id="cliente_id" class="form-select" required>
                <option value="">Seleccione un cliente</option>
                @foreach($clientes as $cliente)
                <option value="{{ $cliente->id }}" @selected(old('cliente_id')==$cliente->id)>{{ $cliente->nombre }}</option>
                @endforeach
            </select>
            @error('cliente_id') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" name="fecha" id="fecha" class="form-control" value="{{ old('fecha', date('Y-m-d')) }}" required>
            @error('fecha') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select name="estado" id="estado" class="form-select" required>
                <option value="pendiente" @selected(old('estado')=='pendiente')>Pendiente</option>
                <option value="en_proceso" @selected(old('estado')=='en_proceso')>En Proceso</option>
                <option value="enviado" @selected(old('estado')=='enviado')>Enviado</option>
                <option value="entregado" @selected(old('estado')=='entregado')>Entregado</option>
                <option value="cancelado" @selected(old('estado')=='cancelado')>Cancelado</option>
            </select>
            @error('estado') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label for="transporte_id" class="form-label">Transporte (opcional)</label>
            <select name="transporte_id" id="transporte_id" class="form-select">
                <option value="">Sin transporte</option>
                @foreach($transportes as $transporte)
                <option value="{{ $transporte->id }}" @selected(old('transporte_id')==$transporte->id)>{{ $transporte->placa }} - {{ $transporte->tipo }}</option>
                @endforeach
            </select>
            @error('transporte_id') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Productos</label>
            @foreach($productos as $producto)
            <div class="form-check">
                <input type="checkbox" name="productos[]" value="{{ $producto->id }}" class="form-check-input" id="prod{{ $producto->id }}"
                    @checked(is_array(old('productos')) && in_array($producto->id, old('productos')))>
                <label class="form-check-label" for="prod{{ $producto->id }}">{{ $producto->nombre }} ({{ $producto->lote }})</label>
            </div>
            @endforeach
            @error('productos') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <button type="submit" class="btn btn-primary">Crear Pedido</button>
        <a href="{{ route('pedidos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection