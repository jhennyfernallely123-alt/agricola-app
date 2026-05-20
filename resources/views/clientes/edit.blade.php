@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-pencil-square"></i> Editar Cliente: {{ $cliente->nombre }}</h1>
        <form action="{{ route('clientes.update', $cliente) }}" method="POST" class="form-agricola">
            @csrf @method('PUT')
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $cliente->nombre) }}" required>
                @error('nombre') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="contacto" class="form-label">Contacto</label>
                <input type="text" name="contacto" id="contacto" class="form-control" value="{{ old('contacto', $cliente->contacto) }}">
                @error('contacto') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="canal_distribucion" class="form-label">Canal de Distribución</label>
                <input type="text" name="canal_distribucion" id="canal_distribucion" class="form-control" value="{{ old('canal_distribucion', $cliente->canal_distribucion) }}">
                @error('canal_distribucion') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Actualizar Cliente</button>
                <a href="{{ route('clientes.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
