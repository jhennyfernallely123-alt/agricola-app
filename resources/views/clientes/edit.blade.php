@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Cliente: {{ $cliente->nombre }}</h1>
    <form action="{{ route('clientes.update', $cliente) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $cliente->nombre) }}" required>
            @error('nombre') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label for="contacto" class="form-label">Contacto</label>
            <input type="text" name="contacto" id="contacto" class="form-control" value="{{ old('contacto', $cliente->contacto) }}">
            @error('contacto') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label for="canal_distribucion" class="form-label">Canal de Distribución</label>
            <input type="text" name="canal_distribucion" id="canal_distribucion" class="form-control" value="{{ old('canal_distribucion', $cliente->canal_distribucion) }}">
            @error('canal_distribucion') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Cliente</button>
        <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection