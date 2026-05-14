# Sistema de Gestión Agrícola

Sistema de información para la gestión integral de una hacienda agrícola, desarrollado con **Laravel 13** y **Eloquent ORM**, aplicando **Diseño Guiado por el Dominio (DDD)** y **Contextos Delimitados (Bounded Contexts)**.

## Integrantes del Equipo

| Nombre | Rol |
|--------|-----|
| Jhennyfer Nallely Arevalo Naranjo | Desarrolladora - Historia de Usuario 1: Gestión de Pedidos |
| Luis Daniel Obando Betancurt | Desarrollador - Historia de Usuario 2: Gestión de Clientes |

## Contextos Delimitados (Bounded Contexts)

1. **Gestión de Cultivo** — Producción agrícola (parcelas, cultivos, labores agrícolas)
2. **Venta y Distribución** — Comercialización (clientes, pedidos, facturación)
3. **Gestión de Recursos** — Soporte operativo (personal, maquinaria, finanzas)

## Historias de Usuario

### Historia de Usuario 1: Gestión de Pedidos
- Crear, consultar, actualizar y eliminar pedidos
- Cambio de estado: pendiente → en proceso → enviado → entregado
- Asociación con clientes, transportes y productos

### Historia de Usuario 2: Gestión de Clientes
- Crear, consultar, actualizar y eliminar clientes
- Validaciones de datos obligatorios
- Visualización de pedidos por cliente

## Pruebas Unitarias

```bash
php vendor/bin/phpunit
```

**33 pruebas** — **63 afirmaciones** (mínimo 3 pruebas por modelo)

| Modelo | Pruebas |
|--------|---------|
| Cliente | 7 pruebas |
| Pedido | 8 pruebas |
| Factura | 4 pruebas |
| Producto | 5 pruebas |
| Relaciones | 7 pruebas |

## Instalación

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Luego abrir http://localhost:8000 en el navegador.

## Ramas de Git

- `main` — Versión estable del proyecto
- `develop` — Rama de integración
- `feature/HU-1-gestion-pedidos` — Historia de Usuario 1
- `feature/HU-2-gestion-clientes` — Historia de Usuario 2

## Repositorio en GitHub

[https://github.com/jhennyfernallely123-alt/agricola-app](https://github.com/jhennyfernallely123-alt/agricola-app)
