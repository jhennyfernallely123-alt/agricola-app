@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-pencil"></i> Editar Parcela</h1>
        <form action="{{ route('parcelas.update', $parcela) }}" method="POST" class="form-agricola">
            @csrf @method('PUT')
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $parcela->nombre) }}" required>
                @error('nombre') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="area" class="form-label">Área (hectáreas)</label>
                <input type="number" step="0.01" name="area" id="area" class="form-control" value="{{ old('area', $parcela->area) }}" required>
                @error('area') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="historial_uso" class="form-label">Historial de Uso</label>
                <textarea name="historial_uso" id="historial_uso" class="form-control" rows="3">{{ old('historial_uso', $parcela->historial_uso) }}</textarea>
                @error('historial_uso') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="analisis_suelo" class="form-label">Análisis de Suelo</label>
                <textarea name="analisis_suelo" id="analisis_suelo" class="form-control" rows="3">{{ old('analisis_suelo', $parcela->analisis_suelo) }}</textarea>
                @error('analisis_suelo') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="potencial_productivo" class="form-label">Potencial Productivo</label>
                <input type="text" name="potencial_productivo" id="potencial_productivo" class="form-control" value="{{ old('potencial_productivo', $parcela->potencial_productivo) }}">
                @error('potencial_productivo') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Actualizar Parcela</button>
                <a href="{{ route('parcelas.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection