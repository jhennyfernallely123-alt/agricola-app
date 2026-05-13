@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gestión de Pedidos</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <a href="{{ route('pedidos.create') }}" class="btn btn-primary mb-3">Nuevo Pedido</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Transporte</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pedidos as $pedido)
            <tr>
                <td>{{ $pedido->id }}</td>
                <td>{{ $pedido->cliente->nombre ?? 'N/A' }}</td>
                <td>{{ $pedido->fecha }}</td>
                <td>
                    <span class="badge bg-{{ $pedido->estado == 'entregado' ? 'success' : ($pedido->estado == 'cancelado' ? 'danger' : 'warning') }}">
                        {{ $pedido->estado }}
                    </span>
                </td>
                <td>{{ $pedido->transporte->placa ?? 'Sin asignar' }}</td>
                <td>
                    <a href="{{ route('pedidos.show', $pedido) }}" class="btn btn-sm btn-info">Ver</a>
                    <a href="{{ route('pedidos.edit', $pedido) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('pedidos.updateEstado', $pedido) }}" method="POST" style="display:inline">
                        @csrf @method('PATCH')
                        <select name="estado" class="form-select form-select-sm d-inline w-auto" onchange="this.form.submit()">
                            <option value="">Cambiar estado</option>
                            <option value="pendiente">Pendiente</option>
                            <option value="en_proceso">En Proceso</option>
                            <option value="enviado">Enviado</option>
                            <option value="entregado">Entregado</option>
                            <option value="cancelado">Cancelado</option>
                        </select>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection