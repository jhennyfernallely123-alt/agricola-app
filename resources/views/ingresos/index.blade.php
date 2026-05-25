@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-cash-coin"></i> Gestión de Ingresos</h1>
        @if(session('success'))
            <div class="alert alert-success-agricola">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger-agricola">{{ session('error') }}</div>
        @endif
        <a href="{{ route('ingresos.create') }}" class="btn btn-natural mb-3">
            <i class="bi bi-plus-lg"></i> Nuevo Ingreso
        </a>
        <table class="tabla-agricola">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fuente</th>
                    <th>Monto</th>
                    <th>Fecha</th>
                    <th>Pedido</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ingresos as $ingreso)
                <tr>
                    <td>{{ $ingreso->id }}</td>
                    <td><strong>{{ $ingreso->fuente }}</strong></td>
                    <td>${{ number_format($ingreso->monto, 2) }}</td>
                    <td>{{ $ingreso->fecha }}</td>
                    <td>{{ $ingreso->pedido ? $ingreso->pedido->nombre : 'N/A' }}</td>
                    <td>
                        <a href="{{ route('ingresos.show', $ingreso) }}" class="btn-accion btn-ver">
                            <i class="bi bi-eye"></i> Ver
                        </a>
                        <a href="{{ route('ingresos.edit', $ingreso) }}" class="btn-accion btn-editar">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <form action="{{ route('ingresos.destroy', $ingreso) }}" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar este ingreso?')">
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