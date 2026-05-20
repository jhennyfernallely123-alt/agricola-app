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
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('clientes.*') ? 'active' : '' }}" 
                           href="{{ route('clientes.index') }}">
                            <i class="bi bi-people"></i> Clientes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pedidos.*') ? 'active' : '' }}" 
                           href="{{ route('pedidos.index') }}">
                            <i class="bi bi-cart3"></i> Pedidos
                        </a>
                    </li>
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
