@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-cart3"></i> Gestión de Pedidos</h1>
        @if(session('success'))
            <div class="alert alert-success-agricola">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger-agricola">{{ session('error') }}</div>
        @endif
        <a href="{{ route('pedidos.create') }}" class="btn btn-natural mb-3">
            <i class="bi bi-cart-plus"></i> Nuevo Pedido
        </a>
        <table class="tabla-agricola">
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
                    <td><strong>#{{ $pedido->id }}</strong></td>
                    <td>{{ $pedido->cliente->nombre ?? 'N/A' }}</td>
                    <td>{{ $pedido->fecha }}</td>
                    <td>
                        <span class="estado-badge estado-{{ $pedido->estado }}">
                            {{ $pedido->estado }}
                        </span>
                    </td>
                    <td>{{ $pedido->transporte->placa ?? 'Sin asignar' }}</td>
                    <td>
                        <a href="{{ route('pedidos.show', $pedido) }}" class="btn-accion btn-ver">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('pedidos.edit', $pedido) }}" class="btn-accion btn-editar">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('pedidos.updateEstado', $pedido) }}" method="POST" style="display:inline">
                            @csrf @method('PATCH')
                            <select name="estado" class="form-select form-select-sm d-inline w-auto" style="border-radius:8px;border:2px solid #d4cfc7;padding:5px 10px;" onchange="this.form.submit()">
                                <option value="">⚡ Estado</option>
                                <option value="pendiente">⏳ Pendiente</option>
                                <option value="en_proceso">🔄 En Proceso</option>
                                <option value="enviado">📦 Enviado</option>
                                <option value="entregado">✅ Entregado</option>
                                <option value="cancelado">❌ Cancelado</option>
                            </select>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
