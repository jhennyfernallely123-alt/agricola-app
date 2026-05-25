<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema de Gestión Agrícola')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">
</head>
<body>
    {{-- Barra de navegación --}}
    <nav class="navbar navbar-expand-lg navbar-agricola">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="bi bi-flower1"></i> Sistema Agrícola
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                    {{-- MÓDULO: GESTIÓN DE CULTIVO --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-tree"></i> Gestión de Cultivo
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('parcelas.index') }}"><i class="bi bi-map"></i> Parcelas</a></li>
                            <li><a class="dropdown-item" href="{{ route('cultivos.index') }}"><i class="bi bi-flower1"></i> Cultivos</a></li>
                            <li><a class="dropdown-item" href="{{ route('sistemas-riego.index') }}"><i class="bi bi-droplet"></i> Sistemas de Riego</a></li>
                            <li><a class="dropdown-item" href="{{ route('fertilizantes.index') }}"><i class="bi bi-flask"></i> Fertilizantes</a></li>
                            <li><a class="dropdown-item" href="{{ route('planes-cultivo.index') }}"><i class="bi bi-calendar-check"></i> Planes de Cultivo</a></li>
                            <li><a class="dropdown-item" href="{{ route('etapas-fenologicas.index') }}"><i class="bi bi-graph-up"></i> Etapas Fenológicas</a></li>
                            <li><a class="dropdown-item" href="{{ route('labores-agricolas.index') }}"><i class="bi bi-tools"></i> Labores Agrícolas</a></li>
                            <li><a class="dropdown-item" href="{{ route('planes-fertilizacion.index') }}"><i class="bi bi-droplet-half"></i> Planes de Fertilización</a></li>
                            <li><a class="dropdown-item" href="{{ route('plagas.index') }}"><i class="bi bi-bug"></i> Control de Plagas</a></li>
                        </ul>
                    </li>

                    {{-- MÓDULO: VENTA Y DISTRIBUCIÓN --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-shop"></i> Venta y Distribución
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('clientes.index') }}"><i class="bi bi-people"></i> Clientes</a></li>
                            <li><a class="dropdown-item" href="{{ route('pedidos.index') }}"><i class="bi bi-cart3"></i> Pedidos</a></li>
                            <li><a class="dropdown-item" href="{{ route('productos.index') }}"><i class="bi bi-box-seam"></i> Productos</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('facturas.index') }}"><i class="bi bi-file-text"></i> Facturas</a></li>
                            <li><a class="dropdown-item" href="{{ route('pagos.index') }}"><i class="bi bi-credit-card"></i> Pagos</a></li>
                            <li><a class="dropdown-item" href="{{ route('devoluciones.index') }}"><i class="bi bi-arrow-return-left"></i> Devoluciones</a></li>
                            <li><a class="dropdown-item" href="{{ route('rutas-entrega.index') }}"><i class="bi bi-truck"></i> Rutas de Entrega</a></li>
                            <li><a class="dropdown-item" href="{{ route('transportes.index') }}"><i class="bi bi-bus-front"></i> Transportes</a></li>
                        </ul>
                    </li>

                    {{-- MÓDULO: GESTIÓN DE RECURSOS --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-gear"></i> Gestión de Recursos
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('personal.index') }}"><i class="bi bi-person-badge"></i> Personal</a></li>
                            <li><a class="dropdown-item" href="{{ route('maquinaria.index') }}"><i class="bi bi-tractor"></i> Maquinaria</a></li>
                            <li><a class="dropdown-item" href="{{ route('mantenimiento.index') }}"><i class="bi bi-wrench"></i> Mantenimiento</a></li>
                            <li><a class="dropdown-item" href="{{ route('proveedores.index') }}"><i class="bi bi-truck"></i> Proveedores</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('presupuestos.index') }}"><i class="bi bi-pie-chart"></i> Presupuestos</a></li>
                            <li><a class="dropdown-item" href="{{ route('gastos.index') }}"><i class="bi bi-cash-stack"></i> Gastos</a></li>
                            <li><a class="dropdown-item" href="{{ route('ingresos.index') }}"><i class="bi bi-graph-up-arrow"></i> Ingresos</a></li>
                            <li><a class="dropdown-item" href="{{ route('informes.index') }}"><i class="bi bi-bar-chart"></i> Informes Financieros</a></li>
                            <li><a class="dropdown-item" href="{{ route('roles.index') }}"><i class="bi bi-shield-check"></i> Roles</a></li>
                        </ul>
                    </li>
                    @endauth

                    {{-- Botón de autenticación --}}
                    @auth
                        <li class="nav-item dropdown ms-2">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i>
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item ms-2">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    {{-- Contenido principal --}}
    <main class="pagina-interna">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="footer-agricola">
        <div class="container">
            <p class="mb-1">© 2026 <span>Sistema de Gestión Agrícola</span></p>
            <p class="mb-0 small">Jhennyfer Nallely Arevalo Naranjo & Luis Daniel Obando Betancurt</p>
        </div>
    </footer>

    {{-- Reproductor de música flotante --}}
    <div class="music-player" id="musicPlayer">
        <div class="music-tooltip" id="musicTooltip">🎵 Activar música</div>
        <button class="music-btn" id="musicBtn" onclick="toggleMusic()">
            <i class="bi bi-music-note-beamed" id="musicIcon"></i>
        </button>
    </div>

    <audio id="bgMusic" loop preload="auto">
        <source src="{{ asset('musica.mp3') }}" type="audio/mpeg">
    </audio>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const music = document.getElementById('bgMusic');
        const btn = document.getElementById('musicBtn');
        const icon = document.getElementById('musicIcon');
        const tooltip = document.getElementById('musicTooltip');
        let isPlaying = false;

        // Intentar reproducir automáticamente al cargar
        document.addEventListener('DOMContentLoaded', function() {
            music.volume = 0.3;
            // Algunos navegadores bloquean autoplay, así que lo intentamos
            let playPromise = music.play();
            if (playPromise !== undefined) {
                playPromise.then(() => {
                    isPlaying = true;
                    btn.classList.add('playing');
                    icon.className = 'bi bi-pause-fill';
                    tooltip.textContent = '⏸ Pausar música';
                }).catch(() => {
                    // Autoplay bloqueado, el usuario debe hacer clic
                    isPlaying = false;
                });
            }
        });

        function toggleMusic() {
            if (isPlaying) {
                music.pause();
                btn.classList.remove('playing');
                icon.className = 'bi bi-music-note-beamed';
                tooltip.textContent = '🎵 Activar música';
            } else {
                music.play().then(() => {
                    btn.classList.add('playing');
                    icon.className = 'bi bi-pause-fill';
                    tooltip.textContent = '⏸ Pausar música';
                }).catch(e => {
                    alert('No se pudo reproducir la música. Haz clic en la página primero.');
                });
            }
            isPlaying = !isPlaying;
        }
    </script>
</body>
</html>
