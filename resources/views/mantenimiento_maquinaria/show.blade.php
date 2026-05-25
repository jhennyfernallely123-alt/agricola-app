@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-wrench"></i> Detalle de Mantenimiento</h1>
        @if(session('success'))
            <div class="alert alert-success-agricola">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger-agricola">{{ session('error') }}</div>
        @endif
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="tarjeta-detalle">
                    <h3>Información del Mantenimiento</h3>
                    <p><strong>Maquinaria:</strong> {{ $mantenimiento->maquinaria->nombre }}</p>
                    <p><strong>Fecha:</strong> {{ $mantenimiento->fecha }}</p>
                    <p><strong>Tipo:</strong> {{ $mantenimiento->tipo }}</p>
                    <p><strong>Costo:</strong> ${{ number_format($mantenimiento->costo, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('mantenimiento.edit', $mantenimiento) }}" class="btn btn-secondary"><i class="bi bi-pencil"></i> Editar</a>
            <a href="{{ route('mantenimiento.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Volver</a>
        </div>
    </div>
</div>
@endsection