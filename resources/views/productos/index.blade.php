@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-box-seam"></i> Gestionar Productos</h1>
        <div class="table-responsive">
            <table class="table table-agricola">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Presentación</th>
                        <th>Stock (kg)</th>
                        <th>Ubicación</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productos as $producto)
                    @php $inv = $producto->inventario; @endphp
                    <tr>
                        <td><strong>{{ $producto->nombre }}</strong></td>
                        <td>{{ $producto->presentacion ?? '—' }}</td>
                        <td>
                            @if($inv)
                                <strong>{{ number_format($inv->cantidad_disponible, 2) }}</strong> kg
                            @else
                                <span class="text-muted">Sin inventario</span>
                            @endif
                        </td>
                        <td>{{ $inv->ubicacion ?? '—' }}</td>
                        <td>
                            @if(!$inv || $inv->cantidad_disponible <= 0)
                                <span class="badge bg-danger"><i class="bi bi-exclamation-triangle"></i> Sin stock</span>
                            @elseif($inv->cantidad_disponible < 50)
                                <span class="badge bg-warning text-dark"><i class="bi bi-exclamation-circle"></i> Por agotarse</span>
                            @else
                                <span class="badge bg-success"><i class="bi bi-check-circle"></i> Disponible</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($productos->isEmpty())
        <p class="text-muted text-center my-4">No hay productos registrados.</p>
        @endif
    </div>
</div>
@endsection
