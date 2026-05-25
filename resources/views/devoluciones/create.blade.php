@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-plus"></i> Nueva Devolución</h1>
        <form action="{{ route('devoluciones.store') }}" method="POST" class="form-agricola">
            @csrf
            <div class="mb-3">
                <label for="pedido_id" class="form-label">Pedido</label>
                <select name="pedido_id" id="pedido_id" class="form-select" required>
                    <option value="">Seleccione un pedido</option>
                    @foreach($pedidos as $pedido)
                    <option value="{{ $pedido->id }}">
                        #{{ $pedido->id }} - {{ $pedido->cliente->nombre }} ({{ $pedido->fecha }})
                    </option>
                    @endforeach
                </select>
                @error('pedido_id') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="producto_id" class="form-label">Producto</label>
                <select name="producto_id" id="producto_id" class="form-select" required>
                    <option value="">Seleccione un producto</option>
                    @foreach($productos as $producto)
                    <option value="{{ $producto->id }}">
                        {{ $producto->nombre }} (Stock: {{ $producto->inventario->cantidad_disponible ?? 0 }} kg)
                    </option>
                    @endforeach
                </select>
                @error('producto_id') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad (kg)</label>
                <input type="number" step="0.01" name="cantidad" id="cantidad" class="form-control" value="{{ old('cantidad') }}" required>
                @error('cantidad') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="motivo" class="form-label">Motivo</label>
                <textarea name="motivo" id="motivo" class="form-control" rows="3" value="{{ old('motivo') }}" required></textarea>
                @error('motivo') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select name="estado" id="estado" class="form-select" required>
                    <option value="pendiente">Pendiente</option>
                    <option value="aprobado">Aprobado</option>
                    <option value="rechazado">Rechazado</option>
                    <option value="procesado">Procesado</option>
                </select>
                @error('estado') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Crear Devolución</button>
                <a href="{{ route('devoluciones.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection