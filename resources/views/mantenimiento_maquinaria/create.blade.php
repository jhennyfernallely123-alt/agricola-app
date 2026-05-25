@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-plus-lg"></i> Nuevo Mantenimiento</h1>
        <form action="{{ route('mantenimiento.store') }}" method="POST" class="form-agricola">
            @csrf
            <div class="mb-3">
                <label for="maquinaria_id" class="form-label">Maquinaria</label>
                <select name="maquinaria_id" id="maquinaria_id" class="form-select" required>
                    <option value="">-- Seleccione una maquinaria --</option>
                    @foreach($maquinarias as $maquinaria)
                        <option value="{{ $maquinaria->id }}" {{ old('maquinaria_id') == $maquinaria->id ? 'selected' : '' }}>
                            {{ $maquinaria->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('maquinaria_id') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" name="fecha" id="fecha" class="form-control" value="{{ old('fecha') }}" required>
                @error('fecha') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo de Mantenimiento</label>
                <input type="text" name="tipo" id="tipo" class="form-control" value="{{ old('tipo') }}" required>
                @error('tipo') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="costo" class="form-label">Costo ($)</label>
                <input type="number" name="costo" id="costo" class="form-control" value="{{ old('costo') }}" step="0.01" min="0">
                @error('costo') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Registrar Mantenimiento</button>
                <a href="{{ route('mantenimiento.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection