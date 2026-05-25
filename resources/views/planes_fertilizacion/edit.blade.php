@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-pencil"></i> Editar Plan de Fertilización</h1>
        <form action="{{ route('planes-fertilizacion.update', $plan) }}" method="POST" class="form-agricola">
            @csrf @method('PUT')
            <div class="mb-3">
                <label for="cultivo_id" class="form-label">Cultivo</label>
                <select name="cultivo_id" id="cultivo_id" class="form-select" required>
                    <option value="">Seleccione un cultivo</option>
                    @foreach($cultivos as $cultivo)
                    <option value="{{ $cultivo->id }}" {{ old('cultivo_id', $plan->cultivo_id) == $cultivo->id ? 'selected' : '' }}>
                        {{ $cultivo->nombre }} ({{ $cultivo->parcela->nombre ?? 'Sin parcela' }})
                    </option>
                    @endforeach
                </select>
                @error('cultivo_id') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="insumo_agricola_id" class="form-label">Fertilizante</label>
                <select name="insumo_agricola_id" id="insumo_agricola_id" class="form-select" required>
                    <option value="">Seleccione un fertilizante</option>
                    @foreach($fertilizantes as $fertilizante)
                    <option value="{{ $fertilizante->id }}" {{ old('insumo_agricola_id', $plan->insumo_agricola_id) == $fertilizante->id ? 'selected' : '' }}>
                        {{ $fertilizante->nombre }} ({{ $fertilizante->tipo ?? 'Sin tipo' }})
                    </option>
                    @endforeach
                </select>
                @error('insumo_agricola_id') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="etapa_fenologica_id" class="form-label">Etapa Fenológica (opcional)</label>
                <select name="etapa_fenologica_id" id="etapa_fenologica_id" class="form-select">
                    <option value="">Seleccione una etapa fenológica</option>
                    @foreach($etapas as $etapa)
                    <option value="{{ $etapa->id }}" {{ old('etapa_fenologica_id', $plan->etapa_fenologica_id) == $etapa->id ? 'selected' : '' }}>
                        {{ $etapa->nombre }} ({{ $etapa->cultivo->nombre }})
                    </option>
                    @endforeach
                </select>
                @error('etapa_fenologica_id') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="dosis" class="form-label">Dosis</label>
                <input type="number" step="0.01" name="dosis" id="dosis" class="form-control" value="{{ old('dosis', $plan->dosis) }}" required>
                @error('dosis') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="metodo" class="form-label">Método de Aplicación</label>
                <input type="text" name="metodo" id="metodo" class="form-control" value="{{ old('metodo', $plan->metodo) }}">
                @error('metodo') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Actualizar Plan de Fertilización</button>
                <a href="{{ route('planes-fertilizacion.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection