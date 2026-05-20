@extends('layouts.app')

@section('title', 'Inicio - Sistema de Gestión Agrícola')

@section('content')
{{-- Eliminamos el padding que viene de pagina-interna para el hero --}}
<style>
    .pagina-interna { padding: 0 !important; }
</style>

{{-- ============================================
     HERO SECTION
     ============================================ --}}
<section class="hero-section">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <div class="hero-icono">
            <i class="bi bi-flower1"></i>
        </div>
        <h1 class="hero-titulo">Sistema de Gestión Agrícola</h1>
        <p class="hero-subtitulo">
            Plataforma integral para la administración de haciendas agrícolas,
            combinando tecnología moderna con las tradiciones del campo.
        </p>
        <div class="hero-botones">
            <a href="{{ route('clientes.index') }}" class="btn btn-natural btn-lg">
                <i class="bi bi-people"></i> Gestionar Clientes
            </a>
            <a href="{{ route('pedidos.index') }}" class="btn btn-outline-natural btn-lg">
                <i class="bi bi-cart3"></i> Gestionar Pedidos
            </a>
        </div>
    </div>
</section>

{{-- ============================================
     CONTEXTOS DEL NEGOCIO
     ============================================ --}}
<section class="seccion" style="background: var(--blanco);">
    <div class="container">
        <h2 class="seccion-titulo">Contextos del Negocio</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="tarjeta-contexto animate-fade-up">
                    <span class="icono"><i class="bi bi-tree"></i></span>
                    <h3>Gestión de Cultivo</h3>
                    <p>Administración integral del ciclo productivo: parcelas, cultivos, labores agrícolas, riego y control fitosanitario.</p>
                    <span class="badge-contexto badge-cultivo">🌱 Producción</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="tarjeta-contexto animate-fade-up" style="animation-delay: 0.2s">
                    <span class="icono"><i class="bi bi-shop"></i></span>
                    <h3>Venta y Distribución</h3>
                    <p>Gestión comercial completa: clientes, pedidos, facturación, logística de entregas y control de inventario.</p>
                    <span class="badge-contexto badge-venta">💰 Comercial</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="tarjeta-contexto animate-fade-up" style="animation-delay: 0.4s">
                    <span class="icono"><i class="bi bi-gear"></i></span>
                    <h3>Gestión de Recursos</h3>
                    <p>Control de personal, maquinaria, mantenimiento, proveedores y análisis financiero para la toma de decisiones.</p>
                    <span class="badge-contexto badge-recursos">📊 Soporte</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================
     TECNOLOGÍAS
     ============================================ --}}
<section class="seccion" style="background: var(--crema);">
    <div class="container text-center">
        <h2 class="seccion-titulo">Tecnologías Utilizadas</h2>
        <div>
            <span class="badge-tecnologia"><i class="bi bi-laravel"></i> Laravel 13</span>
            <span class="badge-tecnologia"><i class="bi bi-database"></i> Eloquent ORM</span>
            <span class="badge-tecnologia"><i class="bi bi-filetype-php"></i> PHP 8.5</span>
            <span class="badge-tecnologia"><i class="bi bi-bootstrap"></i> Bootstrap 5</span>
            <span class="badge-tecnologia"><i class="bi bi-git"></i> Git + GitHub</span>
            <span class="badge-tecnologia"><i class="bi bi-check-circle"></i> PHPUnit</span>
        </div>
    </div>
</section>

{{-- ============================================
     EQUIPO
     ============================================ --}}
<section class="seccion" style="background: var(--blanco);">
    <div class="container">
        <h2 class="seccion-titulo">Nuestro Equipo</h2>
        <div class="row justify-content-center g-4">
            <div class="col-md-5">
                <div class="tarjeta-equipo">
                    <div class="avatar-equipo">JN</div>
                    <h5>Jhennyfer Nallely Arevalo Naranjo</h5>
                    <p class="text-muted">Desarrolladora</p>
                    <p class="small">Historia de Usuario 1: Gestión de Pedidos</p>
                </div>
            </div>
            <div class="col-md-5">
                <div class="tarjeta-equipo">
                    <div class="avatar-equipo">DO</div>
                    <h5>Luis Daniel Obando Betancurt</h5>
                    <p class="text-muted">Desarrollador</p>
                    <p class="small">Historia de Usuario 2: Gestión de Clientes</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================
     ESTADÍSTICAS RÁPIDAS
     ============================================ --}}
<section class="seccion" style="background: linear-gradient(135deg, var(--verde-oscuro), var(--verde-medio)); padding: 60px 0;">
    <div class="container text-center text-white">
        <div class="row g-4">
            <div class="col-6 col-md-3">
                <h2 class="fw-bold display-5">27</h2>
                <p class="mb-0 opacity-75">Modelos</p>
            </div>
            <div class="col-6 col-md-3">
                <h2 class="fw-bold display-5">31</h2>
                <p class="mb-0 opacity-75">Migraciones</p>
            </div>
            <div class="col-6 col-md-3">
                <h2 class="fw-bold display-5">33</h2>
                <p class="mb-0 opacity-75">Pruebas</p>
            </div>
            <div class="col-6 col-md-3">
                <h2 class="fw-bold display-5">2</h2>
                <p class="mb-0 opacity-75">H. Usuario</p>
            </div>
        </div>
    </div>
</section>
@endsection
