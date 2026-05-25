@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-person"></i> Detalle de Personal</h1>
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
                    <p><strong>Nombre:</strong> {{ $personal->nombre }}</p>
                    <p><strong>Rol:</strong> {{ $personal->rol ? $personal->rol->nombre : 'Sin asignar' }}</p>
                    <p><strong>Habilidades:</strong> {{ $personal->habilidades ?? 'N/A' }}</p>
                    <p><strong>Fecha de Contrato:</strong> {{ $personal->contrato ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('personal.edit', $personal) }}" class="btn btn-secondary"><i class="bi bi-pencil"></i> Editar</a>
            <a href="{{ route('personal.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Volver</a>
        </div>
    </div>
</div>
@endsection