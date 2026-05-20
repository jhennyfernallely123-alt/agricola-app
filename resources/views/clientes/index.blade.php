@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-people"></i> Gestión de Clientes</h1>
        @if(session('success'))
            <div class="alert alert-success-agricola">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger-agricola">{{ session('error') }}</div>
        @endif
        <a href="{{ route('clientes.create') }}" class="btn btn-natural mb-3">
            <i class="bi bi-person-plus"></i> Nuevo Cliente
        </a>
        <table class="tabla-agricola">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Contacto</th>
                    <th>Canal Distribución</th>
                    <th>Pedidos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->id }}</td>
                    <td><strong>{{ $cliente->nombre }}</strong></td>
                    <td>{{ $cliente->contacto ?? 'N/A' }}</td>
                    <td>{{ $cliente->canal_distribucion ?? 'N/A' }}</td>
                    <td><span class="badge rounded-pill bg-secondary">{{ $cliente->pedidos_count }}</span></td>
                    <td>
                        <a href="{{ route('clientes.show', $cliente) }}" class="btn-accion btn-ver">
                            <i class="bi bi-eye"></i> Ver
                        </a>
                        <a href="{{ route('clientes.edit', $cliente) }}" class="btn-accion btn-editar">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar este cliente?')">
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
