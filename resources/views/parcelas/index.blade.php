@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-geo-alt"></i> Gestión de Parcelas</h1>
        @if(session('success'))
            <div class="alert alert-success-agricola">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger-agricola">{{ session('error') }}</div>
        @endif
        <a href="{{ route('parcelas.create') }}" class="btn btn-natural mb-3">
            <i class="bi bi-plus-lg"></i> Nueva Parcela
        </a>
        <table class="tabla-agricola">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Área (ha)</th>
                    <th>Historial de Uso</th>
                    <th>Análisis de Suelo</th>
                    <th>Potencial Productivo</th>
                    <th>Cultivos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($parcelas as $parcela)
                <tr>
                    <td>{{ $parcela->id }}</td>
                    <td><strong>{{ $parcela->nombre }}</strong></td>
                    <td>{{ number_format($parcela->area, 2) }} ha</td>
                    <td>{{ $parcela->historial_uso ?? 'N/A' }}</td>
                    <td>{{ $parcela->analisis_suelo ?? 'N/A' }}</td>
                    <td>{{ $parcela->potencial_productivo ?? 'N/A' }}</td>
                    <td><span class="badge rounded-pill bg-secondary">{{ $parcela->cultivos_count }}</span></td>
                    <td>
                        <a href="{{ route('parcelas.show', $parcela) }}" class="btn-accion btn-ver">
                            <i class="bi bi-eye"></i> Ver
                        </a>
                        <a href="{{ route('parcelas.edit', $parcela) }}" class="btn-accion btn-editar">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <form action="{{ route('parcelas.destroy', $parcela) }}" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar esta parcela?')">
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