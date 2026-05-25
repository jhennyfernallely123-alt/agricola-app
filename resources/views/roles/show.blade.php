@extends('layouts.app')

@section('content')
<div class="container">
    <div class="tarjeta-crud">
        <h1><i class="bi bi-person-badge"></i> Detalle de Rol</h1>
        @if(session('success'))
            <div class="alert alert-success-agricola">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger-agricola">{{ session('error') }}</div>
        @endif
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="tarjeta-detalle">
                    <h3>Información Básica</h3>
                    <p><strong>Nombre:</strong> {{ $rol->nombre }}</p>
                    <p><strong>Descripción:</strong> {{ $rol->descripcion ?? 'N/A' }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="tarjeta-detalle">
                    <h3>Personal Asociado ({{ $rol->personales_count }})</h3>
                    @if($rol->personales->isEmpty())
                        <p>No hay personal asociado a este rol.</p>
                    @else
                        <ul class="list-group">
                            @foreach($rol->personales as $personal)
                                <li class="list-group-item">{{ $personal->nombre }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('roles.edit', $rol) }}" class="btn btn-secondary"><i class="bi bi-pencil"></i> Editar</a>
            <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Volver</a>
        </div>
    </div>
</div>
@endsection