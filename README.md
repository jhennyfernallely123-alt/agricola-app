# Sistema de Gestión Agrícola

Sistema de información para la gestión integral de una hacienda agrícola, desarrollado con **Laravel 13** y **Eloquent ORM**, aplicando **Domain-Driven Design (DDD)** y **Bounded Contexts**.

## Integrantes

| Nombre | Rol |
|--------|-----|
| Jhennyfer Nallely Arevalo Naranjo | Desarrolladora - HU-1: Gestión de Pedidos |
| Luis Daniel Obando Betancurt | Desarrollador - HU-2: Gestión de Clientes |

## Bounded Contexts

1. **Gestión de Cultivo** - Producción agrícola (parcelas, cultivos, labores)
2. **Venta y Distribución** - Comercialización (clientes, pedidos, facturación)
3. **Gestión de Recursos** - Soporte operativo (personal, maquinaria, finanzas)

## Historias de Usuario

### HU-1: Gestión de Pedidos
- CRUD de pedidos con cambio de estado (pendiente → en_proceso → enviado → entregado)
- Asociación con clientes, transportes y productos

### HU-2: Gestión de Clientes
- CRUD de clientes con validaciones
- Visualización de pedidos por cliente

## Pruebas

```bash
php vendor/bin/phpunit
```

**30 tests** — 57 assertions (mínimo 3 pruebas por entidad)

## Instalación

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

## Ramas

- `main` - Versión estable
- `develop` - Integración
- `feature/HU-1-gestion-pedidos` - HU-1
- `feature/HU-2-gestion-clientes` - HU-2

## Repositorio

[https://github.com/jhennyfernallely123-alt/agricola-app](https://github.com/jhennyfernallely123-alt/agricola-app)
