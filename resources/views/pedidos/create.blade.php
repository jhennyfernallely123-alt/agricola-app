@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-cart-plus"></i> Nuevo Pedido</h1>
        <form action="{{ route('pedidos.store') }}" method="POST" class="form-agricola">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="cliente_id" class="form-label"><i class="bi bi-people"></i> Cliente</label>
                    <select name="cliente_id" id="cliente_id" class="form-select" required>
                        <option value="">Seleccione un cliente</option>
                        @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}" @selected(old('cliente_id')==$cliente->id)>{{ $cliente->nombre }}</option>
                        @endforeach
                    </select>
                    @error('cliente_id') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label for="fecha" class="form-label"><i class="bi bi-calendar"></i> Fecha</label>
                    <input type="date" name="fecha" id="fecha" class="form-control" value="{{ old('fecha', date('Y-m-d')) }}" required>
                    @error('fecha') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label for="estado" class="form-label"><i class="bi bi-flag"></i> Estado</label>
                    <select name="estado" id="estado" class="form-select" required>
                        <option value="pendiente" @selected(old('estado')=='pendiente')>⏳ Pendiente</option>
                        <option value="en_proceso" @selected(old('estado')=='en_proceso')>🔄 En Proceso</option>
                        <option value="enviado" @selected(old('estado')=='enviado')>📦 Enviado</option>
                        <option value="entregado" @selected(old('estado')=='entregado')>✅ Entregado</option>
                        <option value="cancelado" @selected(old('estado')=='cancelado')>❌ Cancelado</option>
                    </select>
                    @error('estado') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
                </div>
            </div>
            {{-- Productos (lista completa) --}}
            <div class="mb-3">
                <label class="form-label"><i class="bi bi-box"></i> Productos</label>
                <div class="row">
                    @foreach($productos as $producto)
                    @php $inv = $producto->inventario; @endphp
                    <div class="col-12 mb-2">
                        <div class="row align-items-center p-2 border rounded mx-0">
                            <div class="col-5">
                                <div class="form-check mb-0">
                                    <input type="checkbox" name="productos[]" value="{{ $producto->id }}" class="form-check-input" id="prod{{ $producto->id }}"
                                        @checked(is_array(old('productos')) && in_array($producto->id, old('productos')))>
                                    <label class="form-check-label fw-bold" for="prod{{ $producto->id }}">
                                        {{ $producto->nombre }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-3 text-center">
                                @if($inv)
                                    <small class="text-muted">Stock:</small>
                                    <strong class="d-block">{{ number_format($inv->cantidad_disponible, 0) }} kg</strong>
                                    @if($inv->cantidad_disponible <= 0)
                                        <span class="badge bg-danger">Sin stock</span>
                                    @elseif($inv->cantidad_disponible < 50)
                                        <span class="badge bg-warning text-dark">Por agotarse</span>
                                    @endif
                                @else
                                    <span class="badge bg-secondary">Sin inventario</span>
                                @endif
                            </div>
                            <div class="col-4">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">kg</span>
                                    <input type="number" name="cantidades[{{ $producto->id }}]" class="form-control" placeholder="0"
                                        value="{{ old('cantidades.' . $producto->id, 0) }}" min="0" step="0.5">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @error('productos') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>

            {{-- Transporte al final --}}
            <div class="mb-3">
                <label for="transporte_id" class="form-label"><i class="bi bi-truck"></i> Transporte (opcional)</label>
                <select name="transporte_id" id="transporte_id" class="form-select">
                    <option value="">Sin transporte</option>
                    @foreach($transportes as $transporte)
                    <option value="{{ $transporte->id }}" @selected(old('transporte_id')==$transporte->id)>{{ $transporte->placa }} - {{ $transporte->tipo }} ({{ $transporte->capacidad }} kg)</option>
                    @endforeach
                </select>
                @error('transporte_id') <div class="text-danger mt-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div> @enderror
            </div>
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Crear Pedido</button>
                <a href="{{ route('pedidos.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
