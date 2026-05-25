@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-bar-chart-line"></i> Gestión de Informes Financieros</h1>
        @if(session('success'))
            <div class="alert alert-success-agricola">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger-agricola">{{ session('error') }}</div>
        @endif
        <a href="{{ route('informes.create') }}" class="btn btn-natural mb-3">
            <i class="bi bi-plus-lg"></i> Nuevo Informe Financiero
        </a>
        <table class="tabla-agricola">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Ingresos Totales</th>
                    <th>Gastos Totales</th>
                    <th>Rentabilidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($informes as $informe)
                <tr>
                    <td>{{ $informe->id }}</td>
                    <td><strong>{{ $informe->tipo }}</strong></td>
                    <td>{{ $informe->fecha_inicio }}</td>
                    <td>{{ $informe->fecha_fin }}</td>
                    <td>${{ number_format($informe->ingresos_totales, 2) }}</td>
                    <td>${{ number_format($informe->gastos_totales, 2) }}</td>
                    <td>{{ number_format($informe->rentabilidad ?? 0, 2) }}%</td>
                    <td>
                        <a href="{{ route('informes.show', $informe) }}" class="btn-accion btn-ver">
                            <i class="bi bi-eye"></i> Ver
                        </a>
                        <a href="{{ route('informes.edit', $informe) }}" class="btn-accion btn-editar">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <form action="{{ route('informes.destroy', $informe) }}" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar este informe financiero?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-accion btn-eliminar"><i class="bi bi-trash"></i> Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection