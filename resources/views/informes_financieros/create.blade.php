@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-plus-lg"></i> Nuevo Informe Financiero</h1>
        <form action="{{ route('informes.store') }}" method="POST" class="form-agricola">
            @csrf
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo de Informe</label>
                <input type="text" name="tipo" id="tipo" class="form-control" value="{{ old('tipo') }}" required>
                @error('tipo') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="{{ old('fecha_inicio') }}" required>
                @error('fecha_inicio') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="{{ old('fecha_fin') }}" required>
                @error('fecha_fin') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="ingresos_totales" class="form-label">Ingresos Totales ($)</label>
                <input type="number" name="ingresos_totales" id="ingresos_totales" class="form-control" value="{{ old('ingresos_totales') }}" step="0.01" min="0" required>
                @error('ingresos_totales') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="gastos_totales" class="form-label">Gastos Totales ($)</label>
                <input type="number" name="gastos_totales" id="gastos_totales" class="form-control" value="{{ old('gastos_totales') }}" step="0.01" min="0" required>
                @error('gastos_totales') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="rentabilidad" class="form-label">Rentabilidad (%)</label>
                <input type="number" name="rentabilidad" id="rentabilidad" class="form-control" value="{{ old('rentabilidad') }}" step="0.01">
                @error('rentabilidad') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Crear Informe Financiero</button>
                <a href="{{ route('informes.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection