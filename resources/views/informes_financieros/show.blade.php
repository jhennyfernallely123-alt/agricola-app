@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-bar-chart-line"></i> Detalle de Informe Financiero</h1>
        @if(session('success'))
            <div class="alert alert-success-agricola">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger-agricola">{{ session('error') }}</div>
        @endif
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="tarjeta-detalle">
                    <h3>Información del Informe</h3>
                    <p><strong>Tipo:</strong> {{ $informe->tipo }}</p>
                    <p><strong>Fecha de Inicio:</strong> {{ $informe->fecha_inicio }}</p>
                    <p><strong>Fecha de Fin:</strong> {{ $informe->fecha_fin }}</p>
                    <p><strong>Ingresos Totales:</strong> ${{ number_format($informe->ingresos_totales, 2) }}</p>
                    <p><strong>Gastos Totales:</strong> ${{ number_format($informe->gastos_totales, 2) }}</p>
                    <p><strong>Rentabilidad:</strong> {{ number_format($informe->rentabilidad ?? 0, 2) }}%</p>
                </div>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('informes.edit', $informe) }}" class="btn btn-secondary"><i class="bi bi-pencil"></i> Editar</a>
            <a href="{{ route('informes.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Volver</a>
        </div>
    </div>
</div>
@endsection