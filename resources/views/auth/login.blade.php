@extends('layouts.app')

@section('title', 'Iniciar Sesión - Sistema de Gestión Agrícola')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 70vh;">
    <div class="row justify-content-center w-100">
        <div class="col-md-5 col-lg-4">

            {{-- Tarjeta de login --}}
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">

                    {{-- Encabezado --}}
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <i class="bi bi-flower1" style="font-size: 2.5rem; color: var(--verde-medio);"></i>
                        </div>
                        <h4 class="fw-bold" style="color: var(--verde-oscuro);">Iniciar Sesión</h4>
                        <p class="text-muted small">Sistema de Gestión Agrícola</p>
                    </div>

                    {{-- Mensajes de error --}}
                    @if($errors->any())
                        <div class="alert alert-danger py-2 small">
                            <i class="bi bi-exclamation-triangle me-1"></i>
                            {{ $errors->first('email') }}
                        </div>
                    @endif

                    {{-- Formulario --}}
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label small fw-medium">Correo electrónico</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       id="email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       placeholder="admin@agricola.com"
                                       required
                                       autofocus>
                            </div>
                        </div>

                        {{-- Contraseña --}}
                        <div class="mb-3">
                            <label for="password" class="form-label small fw-medium">Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       id="password"
                                       name="password"
                                       placeholder="••••••••"
                                       required>
                            </div>
                        </div>

                        {{-- Recordar --}}
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label small" for="remember">Recordar sesión</label>
                        </div>

                        {{-- Botón --}}
                        <button type="submit" class="btn btn-natural w-100 py-2">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Entrar
                        </button>
                    </form>

                    {{-- Footer de la tarjeta --}}
                    <div class="text-center mt-3">
                        <small class="text-muted">
                            <i class="bi bi-info-circle"></i>
                            Demo: <strong>admin@agricola.com</strong> / <strong>admin123</strong>
                        </small>
                    </div>
                </div>
            </div>

            {{-- Créditos --}}
            <p class="text-center text-muted small mt-3 mb-0">
                &copy; 2026 Jhennyfer Arevalo &amp; Luis Daniel Obando
            </p>
        </div>
    </div>
</div>
@endsection
