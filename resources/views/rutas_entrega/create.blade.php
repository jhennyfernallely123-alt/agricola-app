@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-plus"></i> Nueva Ruta de Entrega</h1>
        <form action="{{ route('rutas-entrega.store') }}" method="POST" class="form-agricola">
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
                <label for="secuencia" class="form-label">Secuencia</label>
                <input type="number" name="secuencia" id="secuencia" class="form-control" value="{{ old('secuencia') }}" required min="1">
                @error('secuencia') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección</label>
                <textarea name="direccion" id="direccion" class="form-control" rows="3" value="{{ old('direccion') }}" required></textarea>
                @error('direccion') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select name="estado" id="estado" class="form-select" required>
                    <option value="pendiente">Pendiente</option>
                    <option value="en_proceso">En Proceso</option>
                    <option value="completado">Completado</option>
                    <option value="cancelado">Cancelado</option>
                </select>
                @error('estado') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Crear Ruta de Entrega</button>
                <a href="{{ route('rutas-entrega.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection