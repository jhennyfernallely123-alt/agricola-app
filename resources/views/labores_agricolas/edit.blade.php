@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-pencil"></i> Editar Labor Agrícola</h1>
        <form action="{{ route('labores-agricolas.update', $labor) }}" method="POST" class="form-agricola">
            @csrf @method('PUT')
            <div class="mb-3">
                <label for="cultivo_id" class="form-label">Cultivo</label>
                <select name="cultivo_id" id="cultivo_id" class="form-select" required>
                    <option value="">Seleccione un cultivo</option>
                    @foreach($cultivos as $cultivo)
                    <option value="{{ $cultivo->id }}" {{ old('cultivo_id', $labor->cultivo_id) == $cultivo->id ? 'selected' : '' }}>
                        {{ $cultivo->nombre }} ({{ $cultivo->parcela->nombre ?? 'Sin parcela' }})
                    </option>
                    @endforeach
                </select>
                @error('cultivo_id') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="empleado_id" class="form-label">Empleado</label>
                <select name="empleado_id" id="empleado_id" class="form-select" required>
                    <option value="">Seleccione un empleado</option>
                    @foreach($empleados as $empleado)
                    <option value="{{ $empleado->id }}" {{ old('empleado_id', $labor->empleado_id) == $empleado->id ? 'selected' : '' }}>
                        {{ $empleado->nombre }}
                    </option>
                    @endforeach
                </select>
                @error('empleado_id') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo de Labor</label>
                <input type="text" name="tipo" id="tipo" class="form-control" value="{{ old('tipo', $labor->tipo) }}" required>
                @error('tipo') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" name="fecha" id="fecha" class="form-control" value="{{ old('fecha', $labor->fecha) }}" required>
                @error('fecha') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="costo" class="form-label">Costo (opcional)</label>
                <input type="number" step="0.01" name="costo" id="costo" class="form-control" value="{{ old('costo', $labor->costo) }}">
                @error('costo') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Actualizar Labor Agrícola</button>
                <a href="{{ route('labores-agricolas.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection