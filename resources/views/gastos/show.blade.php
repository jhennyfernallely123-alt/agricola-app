@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-cash-coin"></i> Detalle de Gasto</h1>
        @if(session('success'))
            <div class="alert alert-success-agricola">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger-agricola">{{ session('error') }}</div>
        @endif
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="tarjeta-detalle">
                    <h3>Información del Gasto</h3>
                    <p><strong>Concepto:</strong> {{ $gasto->concepto }}</p>
                    <p><strong>Monto:</strong> ${{ number_format($gasto->monto, 2) }}</p>
                    <p><strong>Fecha:</strong> {{ $gasto->fecha }}</p>
                    <p><strong>Proveedor:</strong> {{ $gasto->proveedor ? $gasto->proveedor->nombre : 'N/A' }}</p>
                </div>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('gastos.edit', $gasto) }}" class="btn btn-secondary"><i class="bi bi-pencil"></i> Editar</a>
            <a href="{{ route('gastos.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Volver</a>
        </div>
    </div>
</div>
@endsection