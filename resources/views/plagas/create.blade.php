@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-plus-lg"></i> Nuevo Control de Plagas</h1>
        <form action="{{ route('plagas.store') }}" method="POST" class="form-agricola">
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
                <label for="tipo" class="form-label">Tipo (Plaga/Enfermedad)</label>
                <select name="tipo" id="tipo" class="form-select" required>
                    <option value="">Seleccione un tipo</option>
                    <option value="plaga" {{ old('tipo') == 'plaga' ? 'selected' : '' }}>Plaga</option>
                    <option value="enfermedad" {{ old('tipo') == 'enfermedad' ? 'selected' : '' }}>Enfermedad</option>
                </select>
                @error('tipo') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre de la Plaga/Enfermedad</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" required>
                @error('nombre') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="fecha_deteccion" class="form-label">Fecha de Detección</label>
                <input type="date" name="fecha_deteccion" id="fecha_deteccion" class="form-control" value="{{ old('fecha_deteccion') }}" required>
                @error('fecha_deteccion') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="tratamiento_aplicado" class="form-label">Tratamiento Aplicado</label>
                <textarea name="tratamiento_aplicado" id="tratamiento_aplicado" class="form-control" rows="3">{{ old('tratamiento_aplicado') }}</textarea>
                @error('tratamiento_aplicado') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Crear Control de Plagas</button>
                <a href="{{ route('plagas.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection