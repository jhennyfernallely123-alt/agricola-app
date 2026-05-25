@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-plus-lg"></i> Nuevo Plan de Cultivo</h1>
        <form action="{{ route('planes-cultivo.store') }}" method="POST" class="form-agricola">
            @csrf
            <div class="mb-3">
                <label for="cultivo_id" class="form-label">Cultivo</label>
                <select name="cultivo_id" id="cultivo_id" class="form-select" required>
                    <option value="">Seleccione un cultivo</option>
                    @foreach($cultivos as $cultivo)
                    <option value="{{ $cultivo->id }}" {{ old('cultivo_id') == $cultivo->id ? 'selected' : '' }}>
                        {{ $cultivo->nombre }} ({{ $cultivo->parcela->nombre ?? 'Sin parcela' }})
                    </option>
                    @endforeach
                </select>
                @error('cultivo_id') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="{{ old('fecha_inicio') }}" required>
                @error('fecha_inicio') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="fecha_fin_prevista" class="form-label">Fecha Fin Prevista</label>
                <input type="date" name="fecha_fin_prevista" id="fecha_fin_prevista" class="form-control" value="{{ old('fecha_fin_prevista') }}" required>
                @error('fecha_fin_prevista') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="objetivo_produccion" class="form-label">Objetivo de Producción (unidades)</label>
                <input type="number" step="0.01" name="objetivo_produccion" id="objetivo_produccion" class="form-control" value="{{ old('objetivo_produccion') }}">
                @error('objetivo_produccion') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Crear Plan de Cultivo</button>
                <a href="{{ route('planes-cultivo.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection