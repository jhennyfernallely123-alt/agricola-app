@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-pencil-square"></i> Editar Ingreso: {{ $ingreso->fuente }}</h1>
        <form action="{{ route('ingresos.update', $ingreso) }}" method="POST" class="form-agricola">
            @csrf @method('PUT')
            <div class="mb-3">
                <label for="fuente" class="form-label">Fuente</label>
                <input type="text" name="fuente" id="fuente" class="form-control" value="{{ old('fuente', $ingreso->fuente) }}" required>
                @error('fuente') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="monto" class="form-label">Monto ($)</label>
                <input type="number" name="monto" id="monto" class="form-control" value="{{ old('monto', $ingreso->monto) }}" step="0.01" min="0" required>
                @error('monto') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" name="fecha" id="fecha" class="form-control" value="{{ old('fecha', $ingreso->fecha) }}" required>
                @error('fecha') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="pedido_id" class="form-label">Pedido</label>
                <select name="pedido_id" id="pedido_id" class="form-select">
                    <option value="">-- Seleccione un pedido (opcional) --</option>
                    @foreach($pedidos as $pedido)
                        <option value="{{ $pedido->id }}" {{ old('pedido_id', $ingreso->pedido_id) == $pedido->id ? 'selected' : '' }}>
                            {{ $pedido->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('pedido_id') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Actualizar Ingreso</button>
                <a href="{{ route('ingresos.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection