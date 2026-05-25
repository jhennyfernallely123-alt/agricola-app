@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-pencil"></i> Editar Sistema de Riego</h1>
        <form action="{{ route('sistemas-riego.update', $sistema) }}" method="POST" class="form-agricola">
            @csrf @method('PUT')
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo</label>
                <input type="text" name="tipo" id="tipo" class="form-control" value="{{ old('tipo', $sistema->tipo) }}" required>
                @error('tipo') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="fuente" class="form-label">Fuente de Agua</label>
                <input type="text" name="fuente" id="fuente" class="form-control" value="{{ old('fuente', $sistema->fuente) }}">
                @error('fuente') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Actualizar Sistema de Riego</button>
                <a href="{{ route('sistemas-riego.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection