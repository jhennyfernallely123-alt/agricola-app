@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-tools"></i> Gestión de Labores Agrícolas</h1>
        @if(session('success'))
            <div class="alert alert-success-agricola">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger-agricola">{{ session('error') }}</div>
        @endif
        <a href="{{ route('labores-agricolas.create') }}" class="btn btn-natural mb-3">
            <i class="bi bi-plus-lg"></i> Nueva Labor Agrícola
        </a>
        <table class="tabla-agricola">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cultivo</th>
                    <th>Empleado</th>
                    <th>Tipo</th>
                    <th>Fecha</th>
                    <th>Costo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($labores as $labor)
                <tr>
                    <td>{{ $labor->id }}</td>
                    <td>{{ $labor->cultivo->nombre }}</td>
                    <td>{{ $labor->empleado->nombre }}</td>
                    <td><strong>{{ $labor->tipo }}</strong></td>
                    <td>{{ $labor->fecha }}</td>
                    <td>{{ $labor->costo ?? '0.00' }}</td>
                    <td>
                        <a href="{{ route('labores-agricolas.show', $labor) }}" class="btn-accion btn-ver">
                            <i class="bi bi-eye"></i> Ver
                        </a>
                        <a href="{{ route('labores-agricolas.edit', $labor) }}" class="btn-accion btn-editar">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <form action="{{ route('labores-agricolas.destroy', $labor) }}" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar esta labor agrícola?')">
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