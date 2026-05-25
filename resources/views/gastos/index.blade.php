@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-cash-coin"></i> Gestión de Gastos</h1>
        @if(session('success'))
            <div class="alert alert-success-agricola">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger-agricola">{{ session('error') }}</div>
        @endif
        <a href="{{ route('gastos.create') }}" class="btn btn-natural mb-3">
            <i class="bi bi-plus-lg"></i> Nuevo Gasto
        </a>
        <table class="tabla-agricola">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Concepto</th>
                    <th>Monto</th>
                    <th>Fecha</th>
                    <th>Proveedor</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($gastos as $gasto)
                <tr>
                    <td>{{ $gasto->id }}</td>
                    <td><strong>{{ $gasto->concepto }}</strong></td>
                    <td>${{ number_format($gasto->monto, 2) }}</td>
                    <td>{{ $gasto->fecha }}</td>
                    <td>{{ $gasto->proveedor ? $gasto->proveedor->nombre : 'N/A' }}</td>
                    <td>
                        <a href="{{ route('gastos.show', $gasto) }}" class="btn-accion btn-ver">
                            <i class="bi bi-eye"></i> Ver
                        </a>
                        <a href="{{ route('gastos.edit', $gasto) }}" class="btn-accion btn-editar">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <form action="{{ route('gastos.destroy', $gasto) }}" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar este gasto?')">
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