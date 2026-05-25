@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-pencil"></i> Editar Ruta de Entrega</h1>
        <form action="{{ route('rutas-entrega.update', $rutaEntrega) }}" method="POST" class="form-agricola">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="pedido_id" class="form-label">Pedido</label>
                <select name="pedido_id" id="pedido_id" class="form-select" required>
                    <option value="">Seleccione un pedido</option>
                    @foreach($pedidos as $pedido)
                    <option value="{{ $pedido->id }}" {{ $rutaEntrega->pedido_id == $pedido->id ? 'selected' : '' }}>
                        #{{ $pedido->id }} - {{ $pedido->cliente->nombre }} ({{ $pedido->fecha }})
                    </option>
                    @endforeach
                </select>
                @error('pedido_id') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="secuencia" class="form-label">Secuencia</label>
                <input type="number" name="secuencia" id="secuencia" class="form-control" value="{{ old('secuencia', $rutaEntrega->secuencia) }}" required min="1">
                @error('secuencia') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección</label>
                <textarea name="direccion" id="direccion" class="form-control" rows="3">{{ old('direccion', $rutaEntrega->direccion) }}</textarea>
                @error('direccion') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select name="estado" id="estado" class="form-select" required>
                    <option value="pendiente" {{ old('estado', $rutaEntrega->estado) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="en_proceso" {{ old('estado', $rutaEntrega->estado) == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                    <option value="completado" {{ old('estado', $rutaEntrega->estado) == 'completado' ? 'selected' : '' }}>Completado</option>
                    <option value="cancelado" {{ old('estado', $rutaEntrega->estado) == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                </select>
                @error('estado') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Actualizar Ruta de Entrega</button>
                <a href="{{ route('rutas-entrega.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection