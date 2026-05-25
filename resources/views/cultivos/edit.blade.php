@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-pencil"></i> Editar Cultivo</h1>
        <form action="{{ route('cultivos.update', $cultivo) }}" method="POST" class="form-agricola">
            @csrf @method('PUT')
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $cultivo->nombre) }}" required>
                @error('nombre') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="variedad" class="form-label">Variedad</label>
                <input type="text" name="variedad" id="variedad" class="form-control" value="{{ old('variedad', $cultivo->variedad) }}">
                @error('variedad') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="requerimientos" class="form-label">Requerimientos</label>
                <textarea name="requerimientos" id="requerimientos" class="form-control" rows="3">{{ old('requerimientos', $cultivo->requerimientos) }}</textarea>
                @error('requerimientos') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="parcela_id" class="form-label">Parcela</label>
                <select name="parcela_id" id="parcela_id" class="form-select" required>
                    <option value="">Seleccione una parcela</option>
                    @foreach($parcelas as $parcela)
                    <option value="{{ $parcela->id }}" {{ old('parcela_id', $cultivo->parcela_id) == $parcela->id ? 'selected' : '' }}>
                        {{ $parcela->nombre }}
                    </option>
                    @endforeach
                </select>
                @error('parcela_id') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Actualizar Cultivo</button>
                <a href="{{ route('cultivos.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection