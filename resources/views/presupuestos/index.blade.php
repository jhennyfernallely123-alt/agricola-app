@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-file-earmark-text"></i> Gestión de Presupuestos</h1>
        @if(session('success'))
            <div class="alert alert-success-agricola">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger-agricola">{{ session('error') }}</div>
        @endif
        <a href="{{ route('presupuestos.create') }}" class="btn btn-natural mb-3">
            <i class="bi bi-plus-lg"></i> Nuevo Presupuesto
        </a>
        <table class="tabla-agricola">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Monto Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($presupuestos as $presupuesto)
                <tr>
                    <td>{{ $presupuesto->id }}</td>
                    <td><strong>{{ $presupuesto->nombre }}</strong></td>
                    <td>{{ $presupuesto->fecha_inicio }}</td>
                    <td>{{ $presupuesto->fecha_fin }}</td>
                    <td>${{ number_format($presupuesto->monto_total, 2) }}</td>
                    <td>
                        <a href="{{ route('presupuestos.show', $presupuesto) }}" class="btn-accion btn-ver">
                            <i class="bi bi-eye"></i> Ver
                        </a>
                        <a href="{{ route('presupuestos.edit', $presupuesto) }}" class="btn-accion btn-editar">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <form action="{{ route('presupuestos.destroy', $presupuesto) }}" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar este presupuesto?')">
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