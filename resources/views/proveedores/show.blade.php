@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-truck"></i> Detalle de Proveedor</h1>
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
                    <p><strong>Nombre:</strong> {{ $proveedor->nombre }}</p>
                    <p><strong>Contacto:</strong> {{ $proveedor->contacto ?? 'N/A' }}</p>
                    <p><strong>Contrato:</strong> {{ $proveedor->contrato ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('proveedores.edit', $proveedor) }}" class="btn btn-secondary"><i class="bi bi-pencil"></i> Editar</a>
            <a href="{{ route('proveedores.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Volver</a>
        </div>
    </div>
</div>
@endsection