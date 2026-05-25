# Guía de Explicación Técnica — Sistema de Gestión Agrícola

> Documento de apoyo para que puedas explicarle al profesor **cómo se hizo todo**, desde cero, con todas las herramientas usadas.

---

## ÍNDICE

1. [¿Qué tecnologías se usaron y por qué?](#1-qué-tecnologías-se-usaron-y-por-qué)
2. [¿Cómo se creó el proyecto desde cero?](#2-cómo-se-creó-el-proyecto-desde-cero)
3. [Arquitectura: Contextos Delimitados (DDD)](#3-arquitectura-contextos-delimitados-ddd)
4. [Base de datos: Migraciones y relaciones](#4-base-de-datos-migraciones-y-relaciones)
5. [Modelos Eloquent ORM](#5-modelos-eloquent-orm)
6. [Controladores y Rutas](#6-controladores-y-rutas)
7. [Vistas con Blade + Bootstrap](#7-vistas-con-blade--bootstrap)
8. [Pruebas Unitarias con PHPUnit](#8-pruebas-unitarias-con-phpunit)
9. [Trabajo en equipo con Git y GitHub](#9-trabajo-en-equipo-con-git-y-github)
10. [Seeders: Datos de prueba realistas](#10-seeders-datos-de-prueba-realistas)
11. [Cómo ejecutar todo](#11-cómo-ejecutar-todo)

---

## 1. ¿Qué tecnologías se usaron y por qué?

### Laravel 13 (PHP 8.5)
**¿Qué es?** Laravel es el framework web más popular de PHP. Nos da una estructura ya organizada para crear aplicaciones web sin tener que inventar todo desde cero.

**¿Por qué lo elegimos?**
- Viene con **Eloquent ORM** (manejo de base de datos sin escribir SQL)
- **Blade** para las vistas (HTML con lógica PHP)
- **Migraciones** para versionar la base de datos
- **PHPUnit** ya integrado para pruebas
- **Rutas** (Routing) ya organizadas
- Comunidad muy grande y documentación excelente

### Eloquent ORM
**¿Qué es?** Es el manejador de base de datos de Laravel. Traduce objetos PHP a registros de base de datos automáticamente.

**Ejemplo:**
```php
// En lugar de escribir SQL:
$clientes = DB::select("SELECT * FROM clientes WHERE canal = 'directo'");

// Con Eloquent escribes:
$clientes = Cliente::where('canal_distribucion', 'directo')->get();
```

### SQLite
**¿Qué es?** Base de datos ligera que se guarda en un solo archivo (`database/database.sqlite`).

**¿Por qué SQLite y no MySQL?**
- Para desarrollo y pruebas es más simple: no necesitas instalar MySQL
- Para las pruebas se usa SQLite **en memoria** (más rápido que disco)
- En producción se puede cambiar a MySQL cambiando una línea en el `.env`

### Bootstrap 5
**¿Qué es?** Framework de estilos CSS. Hace que la interfaz se vea profesional sin tener que escribir CSS desde cero.

**¿Qué usamos de Bootstrap?**
- Barra de navegación (navbar con dropdowns por módulo)
- Tablas con estilo (table table-striped)
- Formularios con validación
- Botones, alertas, tarjetas
- Sistema de rejilla (grid) responsive para 12 columnas

### TailwindCSS 4 (Vite)
Además de Bootstrap, el proyecto tiene configurado **TailwindCSS** y **Vite** para procesar CSS moderno. Bootstrap se carga desde un CDN y Tailwind se usa para estilos personalizados.

### PHPUnit 12
**¿Qué es?** Es la herramienta de pruebas automatizadas. Escribes código que verifica que tu app funciona correctamente.

**¿Por qué es importante?**
- Verifica que las funcionalidades NO se rompan cuando haces cambios
- Automatiza la "prueba manual" que harías cada vez
- Son 199 pruebas que se ejecutan en ~10 segundos

---

## 2. ¿Cómo se creó el proyecto desde cero?

### Paso 1: Crear el proyecto Laravel
```bash
composer create-project laravel/laravel agricola-app
```

Esto crea la carpeta `agricola-app` con toda la estructura de Laravel:
```
agricola-app/
├── app/           → Código de la aplicación (Modelos, Controladores)
├── bootstrap/     → Archivos de inicio
├── config/        → Configuración (base de datos, correo, etc.)
├── database/      → Migraciones, factories, seeders
├── public/        → Archivos públicos (CSS, JS, imágenes)
├── resources/     → Vistas (Blade), CSS, JS
├── routes/        → Definición de rutas (web.php, api.php)
├── storage/       → Archivos generados por la app
├── tests/         → Pruebas unitarias y de integración
└── vendor/        → Dependencias (instaladas por Composer)
```

### Paso 2: Configurar la base de datos
En el archivo `.env`:
```
DB_CONNECTION=sqlite
```

Laravel ya usa SQLite por defecto, así que no hay que hacer nada más.

### Paso 3: Crear los modelos con sus migraciones
Para cada entidad usamos el comando:
```bash
php artisan make:model Parcela -m
php artisan make:model Cultivo -m
php artisan make:model Cliente -m
# ... etc
```

El flag `-m` crea también la migración (la tabla en la base de datos).

### Paso 4: Definir las relaciones en las migraciones
Cada migración define las columnas de la tabla:
```php
Schema::create('clientes', function (Blueprint $table) {
    $table->id();
    $table->string('nombre');
    $table->string('contacto')->nullable();
    $table->string('canal_distribucion')->nullable();
    $table->timestamps();
});
```

### Paso 5: Crear los controladores
```bash
php artisan make:controller ParcelaController --resource
```

El flag `--resource` crea los métodos: `index`, `create`, `store`, `show`, `edit`, `update`, `destroy`.

### Paso 6: Definir las rutas
En `routes/web.php`:
```php
Route::resource('parcelas', ParcelaController::class);
```

Esto crea automáticamente las 7 rutas REST:
| Verbo | URL | Método del controlador |
|-------|-----|----------------------|
| GET | /parcelas | index() |
| GET | /parcelas/create | create() |
| POST | /parcelas | store() |
| GET | /parcelas/{id} | show() |
| GET | /parcelas/{id}/edit | edit() |
| PUT/PATCH | /parcelas/{id} | update() |
| DELETE | /parcelas/{id} | destroy() |

### Paso 7: Crear las vistas
En `resources/views/parcelas/` creamos:
- `index.blade.php` — Listado de parcelas
- `create.blade.php` — Formulario de creación
- `edit.blade.php` — Formulario de edición
- `show.blade.php` — Detalle de una parcela

### Paso 8: Crear factories y seeders
```bash
php artisan make:factory ParcelaFactory
php artisan make:seeder ParcelasSeeder
```

### Paso 9: Ejecutar migraciones
```bash
php artisan migrate
```

---

## 3. Arquitectura: Contextos Delimitados (DDD)

El proyecto usa **Domain-Driven Design** (Diseño Guiado por el Dominio), que significa que organizamos el código **por áreas del negocio**, no por tecnologías.

### Los 3 Contextos Delimitados

```
SISTEMA DE GESTIÓN AGRÍCOLA
├── 🌱 GESTIÓN DE CULTIVO
│   ├── Parcela ───────────→ Cultivo
│   ├── SistemaRiego ──────→ (N:M) Cultivo
│   ├── InsumoAgricola ────→ (N:M) Cultivo
│   ├── PlanCultivo ───────→ Cultivo
│   ├── EtapaFenologica ───→ Cultivo
│   ├── LaborAgricola ─────→ Cultivo + Personal
│   ├── PlanFertilizacion ──→ Cultivo + Insumo
│   └── ControlPlagas ─────→ Cultivo
│
├── 💰 VENTA Y DISTRIBUCIÓN
│   ├── Cliente ───────────→ (1:N) Pedido
│   ├── Pedido ────────────→ (N:M) ProductoTerminado
│   ├── Factura ───────────→ Pedido
│   ├── Pago ──────────────→ Factura
│   ├── Devolucion ────────→ Pedido + Producto
│   ├── RutaEntrega ───────→ Pedido
│   ├── Transporte ────────→ Pedido
│   ├── ProductoTerminado ──→ InventarioProductos
│   └── InventarioProductos → ProductoTerminado
│
└── 🔧 GESTIÓN DE RECURSOS
    ├── Rol ───────────────→ Personal
    ├── Personal ──────────→ LaborAgricola
    ├── Maquinaria ────────→ MantenimientoMaquinaria
    ├── Proveedor ─────────→ Gasto
    ├── Presupuesto
    ├── Gasto ─────────────→ Proveedor
    ├── Ingreso ───────────→ Pedido
    └── InformeFinanciero
```

**¿Por qué separamos en 3 contextos?**
- Cada contexto representa un área del negocio independiente
- Los cambios en un contexto NO afectan a los otros
- Es más fácil de entender y mantener
- Sigue principios de DDD (Domain-Driven Design)

### ¿Qué es DDD?

**DDD** es una forma de diseñar software donde:
1. El código refleja el **lenguaje del negocio** (no términos técnicos)
2. El dominio (agricultura) es el centro, no la tecnología
3. Se divide en **contextos delimitados** (bounded contexts) que agrupan conceptos relacionados

**Ejemplo en nuestro código:**
```php
// En lugar de nombres genéricos:
class User {}

// Usamos nombres del negocio:
class Cliente {}
class Parcela {}
class Pedido {}
```

---

## 4. Base de datos: Migraciones y relaciones

### ¿Qué son las migraciones?

Las migraciones son archivos PHP que describen **cómo crear y modificar las tablas** de la base de datos. Se ejecutan en orden (por la fecha del nombre del archivo).

**Ejemplo de migración:**
```php
// database/migrations/2026_05_13_000008_create_clientes_table.php
Schema::create('clientes', function (Blueprint $table) {
    $table->id();                          // Columna ID autoincremental
    $table->string('nombre');              // VARCHAR(255)
    $table->string('contacto')->nullable(); // Puede ser nulo
    $table->string('canal_distribucion');   // VARCHAR obligatorio
    $table->timestamps();                  // created_at y updated_at
});
```

### Tipos de relaciones entre tablas

Nuestro sistema tiene 3 tipos de relaciones:

#### 1. Uno a Muchos (1:N) — La más común
Un **Cliente** tiene muchos **Pedidos**. Un **Pedido** pertenece a un **Cliente**.

```php
// En la migración del Pedido:
$table->foreignId('cliente_id')->constrained('clientes')->cascadeOnDelete();
```

```php
// En el modelo Cliente:
public function pedidos(): HasMany {
    return $this->hasMany(Pedido::class);
}

// En el modelo Pedido:
public function cliente(): BelongsTo {
    return $this->belongsTo(Cliente::class);
}
```

#### 2. Muchos a Muchos (N:M) — Tablas pivote
Un **Cultivo** tiene muchos **Sistemas de Riego**. Un **Sistema de Riego** sirve a muchos **Cultivos**.

Se necesita una **tabla pivote** (intermedia):
```php
// Migración: cultivo_sistema_riego
Schema::create('cultivo_sistema_riego', function (Blueprint $table) {
    $table->foreignId('cultivo_id')->constrained();
    $table->foreignId('sistema_riego_id')->constrained();
});
```

```php
// En el modelo Cultivo:
public function sistemasRiego(): BelongsToMany {
    return $this->belongsToMany(SistemaRiego::class, 'cultivo_sistema_riego');
}
```

#### 3. Uno a Uno (1:1)
Un **Pedido** tiene una **Factura**. Una **Factura** pertenece a un **Pedido**.

```php
// En el modelo Pedido:
public function factura(): HasOne {
    return $this->hasOne(Factura::class);
}

// En el modelo Factura:
public function pedido(): BelongsTo {
    return $this->belongsTo(Pedido::class);
}
```

### Las 35 migraciones del proyecto

Se ejecutan en orden cronológico (por la fecha en el nombre del archivo):

1. Usuarios, caché, jobs (Laravel por defecto)
2. Parcelas → Cultivos → Fertilizantes → Sistemas de Riego
3. Maquinaria, Proveedores, Transportes
4. **Clientes**, **Productos**, **Pedidos** (tablas principales)
5. Empleados, Roles
6. Tablas pivote (pedido_producto, cultivo_fertilizante, cultivo_sistema_riego)
7. Planes de cultivo, Etapas fenológicas, Labores agrícolas
8. Facturas, Pagos, Devoluciones
9. Rutas de entrega, Inventarios
10. Mantenimiento, Presupuestos, Informes financieros, Gastos, Ingresos

---

## 5. Modelos Eloquent ORM

### ¿Qué es un Modelo?

Un **Modelo** es una clase PHP que representa una tabla de la base de datos. Cada **registro** (fila) de la tabla se convierte en un **objeto** PHP.

```php
// Esto busca en la tabla 'clientes' WHERE id = 5
$cliente = Cliente::find(5);

// Esto devuelve el nombre del cliente
echo $cliente->nombre; // "Carlos Alberto Martínez"

// Relación: obtiene los pedidos de este cliente
$pedidos = $cliente->pedidos;
```

### Estructura de un modelo

```php
class Cliente extends Model
{
    use HasFactory;

    // Nombre de la tabla (porque está en español)
    protected $table = 'clientes';

    // Campos que se pueden llenar masivamente
    protected $fillable = ['nombre', 'contacto', 'canal_distribucion'];

    // Relaciones
    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class, 'cliente_id');
    }
}
```

### ¿Qué significa $fillable?

Es una **medida de seguridad**. Define qué campos pueden ser llenados cuando usamos:
```php
Cliente::create($request->all()); // Solo llena 'nombre', 'contacto', 'canal_distribucion'
```

Si un hacker envía campos extra en el formulario, Eloquent los ignora.

### Los 27 modelos del proyecto

| Modelo | Tabla | Contexto |
|--------|-------|----------|
| Parcela | parcelas | Cultivo |
| Cultivo | cultivos | Cultivo |
| SistemaRiego | sistema_riegos | Cultivo |
| InsumoAgricola | fertilizantes | Cultivo |
| PlanCultivo | plan_cultivos | Cultivo |
| EtapaFenologica | etapa_fenologicas | Cultivo |
| LaborAgricola | labor_agricolas | Cultivo |
| PlanFertilizacion | plan_fertilizacions | Cultivo |
| ControlPlagasEnfermedades | control_plagas_enfermedades | Cultivo |
| Cliente | clientes | Venta |
| Pedido | pedidos | Venta |
| ProductoTerminado | productos | Venta |
| InventarioProductos | inventario_productos | Venta |
| Factura | facturas | Venta |
| Pago | pagos | Venta |
| Devolucion | devoluciones | Venta |
| RutaEntrega | ruta_entregas | Venta |
| Transporte | transportes | Venta |
| Personal | empleados | Recursos |
| Rol | rols | Recursos |
| Maquinaria | maquinarias | Recursos |
| MantenimientoMaquinaria | mantenimiento_maquinarias | Recursos |
| Proveedor | proveedores | Recursos |
| Presupuesto | presupuestos | Recursos |
| Gasto | gastos | Recursos |
| Ingreso | ingresos | Recursos |
| InformeFinanciero | informe_financieros | Recursos |

### Principio "Fat Models, Skinny Controllers"

Es una buena práctica en Laravel: **los modelos tienen la lógica de negocio** y los controladores son delgados (solo reciben peticiones y devuelven respuestas).

**Bueno:**
```php
// En el modelo Pedido:
public function puedeCambiarEstado($nuevoEstado): bool {
    if ($this->estado === 'entregado') return false;
    return true;
}

// En el controlador:
public function updateEstado(Request $request, Pedido $pedido) {
    if ($pedido->puedeCambiarEstado($request->estado)) { ... }
}
```

---

## 6. Controladores y Rutas

### ¿Qué es un Controlador?

Un **Controlador** recibe una petición HTTP, procesa los datos y devuelve una respuesta (generalmente una vista).

### Ejemplo completo del flujo:

```
Usuario hace clic en "Clientes"
        ↓
Navegador: GET /clientes
        ↓
Laravel busca la ruta en routes/web.php:
    Route::resource('clientes', ClienteController::class);
        ↓
Llama al método index() de ClienteController:
    public function index() {
        $clientes = Cliente::withCount('pedidos')->get();
        return view('clientes.index', compact('clientes'));
    }
        ↓
Carga la vista resources/views/clientes/index.blade.php
        ↓
Navegador muestra la lista de clientes
```

### Los 27 controladores

Cada controlador tiene 7 métodos (CRUD):

| Método | URL | ¿Qué hace? |
|--------|-----|-----------|
| `index()` | GET /recurso | Muestra el listado |
| `create()` | GET /recurso/create | Muestra el formulario de crear |
| `store()` | POST /recurso | Guarda el nuevo registro |
| `show($id)` | GET /recurso/{id} | Muestra el detalle |
| `edit($id)` | GET /recurso/{id}/edit | Muestra el formulario de editar |
| `update($id)` | PUT /recurso/{id} | Actualiza el registro |
| `destroy($id)` | DELETE /recurso/{id} | Elimina el registro |

### Validación en los controladores

Antes de guardar, validamos los datos:
```php
$validated = $request->validate([
    'nombre' => 'required|string|max:255',
    'contacto' => 'nullable|string|max:255',
]);

Cliente::create($validated);
```

Si la validación falla, Laravel automáticamente regresa al formulario con los errores.

---

## 7. Vistas con Blade + Bootstrap

### ¿Qué es Blade?

Blade es el motor de plantillas de Laravel. Te permite escribir HTML con lógica PHP de forma limpia.

### Layout principal (app.blade.php)

```php
<html>
<head>
    <link href="bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
        {{-- Menú con 3 dropdowns: Gestión de Cultivo, Venta, Recursos --}}
    </nav>
    
    <main>
        @yield('content')  {{-- Aquí se inserta el contenido de cada página --}}
    </main>
    
    <footer> ... </footer>
</body>
</html>
```

### Vista de ejemplo (clientes/index.blade.php)

```php
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Clientes</h1>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <a href="{{ route('clientes.create') }}" class="btn btn-primary">
        + Nuevo Cliente
    </a>
    
    <table class="table table-striped">
        @foreach($clientes as $cliente)
        <tr>
            <td>{{ $cliente->nombre }}</td>
            <td>{{ $cliente->contacto }}</td>
            <td>{{ $cliente->pedidos_count }} pedidos</td>
            <td>
                <a href="{{ route('clientes.edit', $cliente) }}">Editar</a>
                <form action="{{ route('clientes.destroy', $cliente) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
```

### Componentes de Bootstrap usados

1. **Navbar** con dropdowns — Menú principal con 3 módulos
2. **Tablas** (`.table`, `.table-striped`) — Listados de datos
3. **Formularios** con validación — Crear y editar registros
4. **Alertas** (`.alert-success`, `.alert-danger`) — Mensajes de éxito/error
5. **Botones** (`.btn-primary`, `.btn-danger`) — Acciones
6. **Tarjetas** (`.card`) — Detalles de registros
7. **Sistema de rejilla** (`.row`, `.col-md-*`) — Layout responsive

### Diseño visual personalizado

Además de Bootstrap, tenemos:
- **CSS personalizado** en `public/css/estilo.css` con paleta de colores agrícolas (verdes, tierra, crema)
- **Reproductor de música** flotante (toca una canción ambiental de fondo)
- **Página de inicio (hero section)** con tarjetas de los 3 contextos
- **Estadísticas rápidas** en la página principal (27 modelos, 31 migraciones, 33 pruebas, 2 HU)

---

## 8. Pruebas Unitarias con PHPUnit

### ¿Qué son las pruebas automatizadas?

Son fragmentos de código que verifican que el sistema funciona correctamente.

**Sin pruebas:** Cada vez que haces un cambio, debes probar TODO manualmente.
**Con pruebas:** Ejecutas `php artisan test` y en 10 segundos sabes si algo se rompió.

### Estructura de una prueba

```php
class ClienteTest extends TestCase
{
    use RefreshDatabase;  // Limpia la BD entre cada prueba

    public function test_puede_crear_un_cliente()
    {
        // 1. Preparación: datos de entrada
        $response = $this->post(route('clientes.store'), [
            'nombre' => 'Carlos Alberto Martínez',
            'contacto' => 'carlos@email.com',
        ]);

        // 2. Verificación: ¿qué debería pasar?
        $response->assertRedirect(route('clientes.index'));
        $this->assertDatabaseHas('clientes', [
            'nombre' => 'Carlos Alberto Martínez',
        ]);
    }
}
```

### ¿Qué es RefreshDatabase?

```php
use RefreshDatabase;
```

Hace que cada prueba empiece con la base de datos **vacía y recién migrada**. Así:
- Las pruebas son independientes entre sí
- No importa el orden en que se ejecuten
- Siempre dan el mismo resultado

### Tipos de pruebas que tenemos

#### Pruebas de creación
```php
public function test_puede_crear_un_pedido()
{
    $cliente = Cliente::factory()->create();
    
    $response = $this->post(route('pedidos.store'), [
        'cliente_id' => $cliente->id,
        'fecha' => '2026-05-13',
        'estado' => 'pendiente',
    ]);
    
    $response->assertRedirect(route('pedidos.index'));
    $this->assertDatabaseHas('pedidos', ['estado' => 'pendiente']);
}
```

#### Pruebas de validación
```php
public function test_valida_que_nombre_es_obligatorio()
{
    $response = $this->post(route('clientes.store'), [
        'nombre' => '',
    ]);
    
    $response->assertSessionHasErrors('nombre');
}
```

#### Pruebas de reglas de negocio
```php
public function test_no_puede_eliminar_cliente_con_pedidos()
{
    $cliente = Cliente::factory()->create();
    Pedido::factory()->for($cliente)->create();
    
    $response = $this->delete(route('clientes.destroy', $cliente));
    
    $response->assertSessionHas('error');
    $this->assertDatabaseHas('clientes', ['id' => $cliente->id]);
}
```

#### Pruebas de relaciones
```php
public function test_cliente_tiene_muchos_pedidos()
{
    $cliente = Cliente::factory()->create();
    Pedido::factory()->count(3)->for($cliente)->create();
    
    $this->assertCount(3, $cliente->pedidos);
}
```

### ¿Qué son las Factories?

Las **factories** son "fábricas" de datos de prueba. Generan registros falsos pero realistas:

```php
class ClienteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre' => fake()->name(),       // "Carlos Martínez"
            'contacto' => fake()->email(),     // "carlos@example.com"
            'canal_distribucion' => fake()->randomElement(['directo', 'mayorista']),
        ];
    }
}
```

Luego en las pruebas:
```php
// Crea un cliente con datos aleatorios
$cliente = Cliente::factory()->create();

// O con datos específicos
$cliente = Cliente::factory()->create([
    'nombre' => 'Carlos Alberto Martínez',
]);
```

### Nuestros 10 archivos de prueba

| Archivo | Pruebas | ¿Qué cubre? |
|---------|---------|-------------|
| `ClienteTest.php` | 7 | CRUD, validación, eliminación protegida, relación |
| `PedidoTest.php` | 8 | CRUD, cambios de estado, productos, relación |
| `FacturaTest.php` | 4 | Creación, unicidad de número, relación |
| `ModelRelationshipsTest.php` | 7 | Relaciones entre modelos |
| `GestionCultivoModuleTest.php` | ~30 | Parcelas, Cultivos, Riego, Insumos, Labores |
| `VentaDistribucionModuleTest.php` | ~20 | Devoluciones, Rutas, Transportes, Pagos |
| `GestionRecursosModuleTest.php` | ~25 | Personal, Maquinaria, Proveedores, Roles |
| `DemoDataTest.php` | 26 | **NUEVO** — Verifica datos realistas sembrados |
| `StockValidationTest.php` | - | Validación de stock en pedidos |
| `ProductoTerminadoTest.php` | - | Pruebas de productos terminados |

**Total: 199 pruebas, todas con RefreshDatabase y datos realistas.**

---

## 9. Trabajo en equipo con Git y GitHub

### ¿Qué es Git?

Git es un sistema de **control de versiones**. Guarda el historial de todos los cambios del proyecto y permite que varias personas trabajen al mismo tiempo.

### Nuestra estrategia de ramas

```
main  ───●───────────────────●─── (versión estable)
           \                 /
develop     ●───●───●───●───●─── (integración)
            |       |       |
HU-1         ●───●───●          (Jhennyfer - Pedidos)
            |       |       |
HU-2         ●───●───●───●      (Daniel - Clientes)
```

### ¿Cómo trabajamos?

1. **main**: Siempre estable, lo que se entrega al profesor
2. **develop**: Donde se unen las dos historias de usuario
3. **feature/HU-1**: Jhennyfer trabaja aquí (Gestión de Pedidos)
4. **feature/HU-2**: Daniel trabaja aquí (Gestión de Clientes)

```bash
# Daniel crea su rama:
git checkout -b feature/HU-2-gestion-clientes develop

# Trabaja y hace commits:
git add .
git commit -m "HU-2: Agregada validación de nombre obligatorio #HU-2"

# Cuando termina, fusiona a develop:
git checkout develop
git merge feature/HU-2-gestion-clientes
```

### Convención de commits

Cada mensaje de commit tiene el formato: `"Descripción #HU-N"`

```
"HU-2: Seeder de clientes con datos de prueba #HU-2"
"HU-1: Agregado cambio de estado en pedidos #HU-1"
"README en español con info del proyecto #HU-2"
```

### GitHub

- Repositorio: `https://github.com/jhennyfernallely123-alt/agricola-app`
- Cada miembro tiene sus commits registrados
- Se usó autenticación con **Personal Access Token** (token clásico)
- Se resolvieron conflictos al fusionar ramas

---

## 10. Seeders: Datos de prueba realistas

### ¿Qué es un Seeder?

Un **seeder** es una clase que llena la base de datos con datos de prueba. Se ejecuta con:
```bash
php artisan db:seed
```

### Los 3 seeders que creamos

#### 1. GestionCultivoSeeder (datos colombianos realistas)

**Parcelas** — Nombres de fincas colombianas típicas:
- La Esperanza (45.5 ha), El Porvenir (32 ha), Buenavista (28.7 ha)
- San Isidro Labrador (52.3 ha), Los Arrayanes (18.2 ha)
- El Manantial (22 ha), Santa Bárbara (35.8 ha), La Pradera (15 ha)

**Cultivos** — Especies que se cultivan en Colombia:
- Tomate Chonto, Cebolla de Ramas, Uva Isabella, Mora de Castilla
- Fresa Albión, Lechuga Crespa, Pimentón Rojo, Gulupa
- Granadilla, Aguacate Hass, Cilantro, Pepino Coquito

**Labores agrícolas** — Con empleados y costos realistas:
- Preparación del suelo: $350,000
- Siembra: $280,000
- Cosecha: $520,000
- Control de plagas: $180,000

#### 2. VentaDistribucionSeeder

**Clientes** — Personas y empresas:
- Personas: Carlos Alberto Martínez (carlos.martinez@gmail.com)
- Empresas: Frutas del Campo SAS, Supermercados El Campesino

**Pedidos** — En diferentes estados:
- 3 entregados, 2 enviados, 2 en proceso, 4 pendientes

**Direcciones de entrega** — Reales colombianas:
- "Calle 45 # 12-34, Barrio El Poblado, Medellín"
- "Autopista Norte # 45-120, Zona Industrial, Bogotá"

#### 3. GestionRecursosSeeder

**Personal** — 12 empleados con nombres reales:
- Juan Pablo García — Administrador
- María Fernanda Gómez — Jefe de Cultivo
- Luis Fernando Rodríguez — Tractorista
- Paola Andrea Ramírez — Auxiliar Contable

**Roles** — Cargos de hacienda agrícola:
Administrador, Jefe de Cultivo, Tractorista, Operario de Campo, etc.

**Maquinaria** — Equipos agrícolas:
Tractor John Deere 5075E, Cosechadora de Hortalizas, etc.

**Gastos** — Con conceptos detallados:
"Compra de fertilizante NPK 15-15-15 (50 bultos)" — $6,250,000

### DemoDataTest — Prueba de verificación

Creamos un test especial (`DemoDataTest.php`) que:
1. Ejecuta los 3 seeders
2. Verifica que todos los datos se hayan guardado correctamente
3. Verifica las relaciones entre módulos (parcela→cultivo→labor, cliente→pedido→factura)

**Resultado: 26 pruebas, 101 aserciones, 100% pasan.**

---

## 11. Cómo ejecutar todo

### Para resetear la base de datos con datos realistas:
```bash
php artisan migrate:fresh --seed
```

### Para ejecutar las pruebas:
```bash
# Todas las pruebas
php artisan test

# Solo el demo test (para mostrar al profesor)
php artisan test --filter DemoDataTest

# Solo pruebas de clientes
php artisan test --filter ClienteTest

# Solo pruebas de pedidos
php artisan test --filter PedidoTest
```

### Para iniciar el servidor:
```bash
php artisan serve
# Abrir en el navegador: http://localhost:8000
```

### Para ver el árbol de ramas de Git:
```bash
git log --graph --oneline --all
```

---

## Resumen Visual de la Arquitectura

```
┌─────────────────────────────────────────────────────────┐
│                   NAVEGADOR WEB                         │
│              (Interfaz Bootstrap 5)                     │
└────────────────────┬────────────────────────────────────┘
                     │ HTTP (GET, POST, PUT, DELETE)
                     ▼
┌─────────────────────────────────────────────────────────┐
│              RUTAS (routes/web.php)                     │
│        27 Route::resource() → 27 controladores          │
└────────────────────┬────────────────────────────────────┘
                     │
                     ▼
┌─────────────────────────────────────────────────────────┐
│              CONTROLADORES (27)                         │
│    Reciben request → validan → llaman modelo → vista    │
└────────────────────┬────────────────────────────────────┘
                     │ Eloquent ORM
                     ▼
┌─────────────────────────────────────────────────────────┐
│              MODELOS (27) + RELACIONES                  │
│    1:N, N:M (pivot), 1:1 entre todas las entidades     │
└────────────────────┬────────────────────────────────────┘
                     │ SQL
                     ▼
┌─────────────────────────────────────────────────────────┐
│           BASE DE DATOS (SQLite)                        │
│   35 migraciones → 27 tablas + tablas pivote            │
└─────────────────────────────────────────────────────────┘

PRUEBAS (PHPUnit): 199 pruebas, RefreshDatabase, SQLite en memoria
GIT: main → develop → feature/HU-1, feature/HU-2
```

---

> **Consejo para la presentación:** Explica cada punto en orden. Si el profesor pregunta detalles técnicos, aquí tienes las respuestas. Practica la demo corriendo los tests y mostrando los seeders en la base de datos.
