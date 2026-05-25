@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-file-earmark-text"></i> Detalle de Presupuesto</h1>
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
                    <p><strong>Nombre:</strong> {{ $presupuesto->nombre }}</p>
                    <p><strong>Fecha de Inicio:</strong> {{ $presupuesto->fecha_inicio }}</p>
                    <p><strong>Fecha de Fin:</strong> {{ $presupuesto->fecha_fin }}</p>
                    <p><strong>Monto Total:</strong> ${{ number_format($presupuesto->monto_total, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('presupuestos.edit', $presupuesto) }}" class="btn btn-secondary"><i class="bi bi-pencil"></i> Editar</a>
            <a href="{{ route('presupuestos.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Volver</a>
        </div>
    </div>
</div>
@endsection