@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-pencil-square"></i> Editar Proveedor: {{ $proveedor->nombre }}</h1>
        <form action="{{ route('proveedores.update', $proveedor) }}" method="POST" class="form-agricola">
            @csrf @method('PUT')
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $proveedor->nombre) }}" required>
                @error('nombre') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="contacto" class="form-label">Contacto</label>
                <input type="text" name="contacto" id="contacto" class="form-control" value="{{ old('contacto', $proveedor->contacto) }}">
                @error('contacto') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="contrato" class="form-label">Contrato</label>
                <textarea name="contrato" id="contrato" class="form-control" rows="3">{{ old('contrato', $proveedor->contrato) }}</textarea>
                @error('contrato') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Actualizar Proveedor</button>
                <a href="{{ route('proveedores.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection