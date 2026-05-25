@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-plus"></i> Nuevo Transporte</h1>
        <form action="{{ route('transportes.store') }}" method="POST" class="form-agricola">
            @csrf
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo</label>
                <input type="text" name="tipo" id="tipo" class="form-control" value="{{ old('tipo') }}" required>
                @error('tipo') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="placa" class="form-label">Placa</label>
                <input type="text" name="placa" id="placa" class="form-control" value="{{ old('placa') }}" placeholder="Ej: ABC-123">
                @error('placa') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="capacidad" class="form-label">Capacidad (kg)</label>
                <input type="number" name="capacidad" id="capacidad" class="form-control" value="{{ old('capacidad') }}" min="1">
                @error('capacidad') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Crear Transporte</button>
                <a href="{{ route('transportes.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection