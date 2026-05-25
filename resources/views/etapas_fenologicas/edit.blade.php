@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-pencil"></i> Editar Etapa Fenológica</h1>
        <form action="{{ route('etapas-fenologicas.update', $etapa) }}" method="POST" class="form-agricola">
            @csrf @method('PUT')
            <div class="mb-3">
                <label for="cultivo_id" class="form-label">Cultivo</label>
                <select name="cultivo_id" id="cultivo_id" class="form-select" required>
                    <option value="">Seleccione un cultivo</option>
                    @foreach($cultivos as $cultivo)
                    <option value="{{ $cultivo->id }}" {{ old('cultivo_id', $etapa->cultivo_id) == $cultivo->id ? 'selected' : '' }}>
                        {{ $cultivo->nombre }} ({{ $cultivo->parcela->nombre ?? 'Sin parcela' }})
                    </option>
                    @endforeach
                </select>
                @error('cultivo_id') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre de la Etapa</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $etapa->nombre) }}" required>
                @error('nombre') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div
            <div class="mb-3">
                <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="{{ old('fecha_inicio', $etapa->fecha_inicio) }}" required>
                @error('fecha_inicio') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="requerimientos_especificos" class="form-label">Requerimientos Específicos</label>
                <textarea name="requerimientos_especificos" id="requerimientos_especificos" class="form-control" rows="3">{{ old('requerimientos_especificos', $etapa->requerimientos_especificos) }}</textarea>
                @error('requerimientos_especificos') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Actualizar Etapa Fenológica</button>
                <a href="{{ route('etapas-fenologicas.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection