@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-truck"></i> Detalle de Maquinaria</h1>
        @if(session('success'))
            <div class="alert alert-success-agricola">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger-agricola">{{ session('error') }}</div>
        @endif
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="tarjeta-detalle">
                    <h3>Información Básica</h3>
                    <p><strong>Nombre:</strong> {{ $maquinaria->nombre }}</p>
                    <p><strong>Tipo:</strong> {{ $maquinaria->tipo ?? 'N/A' }}</p>
                    <p><strong>Mantenimiento:</strong> {{ $maquinaria->mantenimiento ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('maquinaria.edit', $maquinaria) }}" class="btn btn-secondary"><i class="bi bi-pencil"></i> Editar</a>
            <a href="{{ route('maquinaria.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Volver</a>
        </div>
    </div>
</div>
@endsection