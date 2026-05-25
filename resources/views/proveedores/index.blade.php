@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-truck"></i> Gestión de Proveedores</h1>
        @if(session('success'))
            <div class="alert alert-success-agricola">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger-agricola">{{ session('error') }}</div>
        @endif
        <a href="{{ route('proveedores.create') }}" class="btn btn-natural mb-3">
            <i class="bi bi-person-plus"></i> Nuevo Proveedor
        </a>
        <table class="tabla-agricola">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Contacto</th>
                    <th>Contrato</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($proveedores as $proveedor)
                <tr>
                    <td>{{ $proveedor->id }}</td>
                    <td><strong>{{ $proveedor->nombre }}</strong></td>
                    <td>{{ $proveedor->contacto ?? 'N/A' }}</td>
                    <td>{{ $proveedor->contrato ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('proveedores.show', $proveedor) }}" class="btn-accion btn-ver">
                            <i class="bi bi-eye"></i> Ver
                        </a>
                        <a href="{{ route('proveedores.edit', $proveedor) }}" class="btn-accion btn-editar">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <form action="{{ route('proveedores.destroy', $proveedor) }}" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar este proveedor?')">
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