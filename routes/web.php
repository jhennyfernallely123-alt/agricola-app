<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;
// Módulo: Gestión de Cultivo
use App\Http\Controllers\ParcelaController;
use App\Http\Controllers\CultivoController;
use App\Http\Controllers\SistemaRiegoController;
use App\Http\Controllers\FertilizanteController;
use App\Http\Controllers\PlanCultivoController;
use App\Http\Controllers\EtapaFenologicaController;
use App\Http\Controllers\LaborAgricolaController;
use App\Http\Controllers\PlanFertilizacionController;
use App\Http\Controllers\ControlPlagasController;
// Módulo: Venta y Distribución (restantes)
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\DevolucionController;
use App\Http\Controllers\RutaEntregaController;
use App\Http\Controllers\TransporteController;
// Módulo: Gestión de Recursos
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\MaquinariaController;
use App\Http\Controllers\MantenimientoMaquinariaController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\PresupuestoController;
use App\Http\Controllers\GastoController;
use App\Http\Controllers\IngresoController;
use App\Http\Controllers\InformeFinancieroController;
use App\Http\Controllers\RolController;

// ===== AUTENTICACIÓN =====
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// ===== RUTAS PÚBLICAS (sin autenticación) =====
Route::get('/', function () {
    return view('welcome');
});

// ===== RUTAS PROTEGIDAS (requieren iniciar sesión) =====
Route::middleware('auth')->group(function () {
    // ===== MÓDULO: GESTIÓN DE CULTIVO =====
    Route::resource('parcelas', ParcelaController::class);
    Route::resource('cultivos', CultivoController::class);
    Route::resource('sistemas-riego', SistemaRiegoController::class);
    Route::resource('fertilizantes', FertilizanteController::class);
    Route::resource('planes-cultivo', PlanCultivoController::class);
    Route::resource('etapas-fenologicas', EtapaFenologicaController::class);
    Route::resource('labores-agricolas', LaborAgricolaController::class);
    Route::resource('planes-fertilizacion', PlanFertilizacionController::class);
    Route::resource('plagas', ControlPlagasController::class);

    // ===== MÓDULO: VENTA Y DISTRIBUCIÓN =====
    // HU-1: Gestión de Pedidos
    Route::resource('pedidos', PedidoController::class);
    Route::patch('pedidos/{pedido}/estado', [PedidoController::class, 'updateEstado'])
        ->name('pedidos.updateEstado');

    // HU-2: Gestión de Clientes
    Route::resource('clientes', ClienteController::class);

    // HU-3: Gestión de Productos e Inventario
    Route::get('productos', [ProductoController::class, 'index'])->name('productos.index');

    // Resto del módulo Venta y Distribución
    Route::resource('facturas', FacturaController::class);
    Route::resource('pagos', PagoController::class);
    Route::resource('devoluciones', DevolucionController::class);
    Route::resource('rutas-entrega', RutaEntregaController::class);
    Route::resource('transportes', TransporteController::class);

    // ===== MÓDULO: GESTIÓN DE RECURSOS =====
    Route::resource('personal', PersonalController::class);
    Route::resource('maquinaria', MaquinariaController::class);
    Route::resource('mantenimiento', MantenimientoMaquinariaController::class);
    Route::resource('proveedores', ProveedorController::class);
    Route::resource('presupuestos', PresupuestoController::class);
    Route::resource('gastos', GastoController::class);
    Route::resource('ingresos', IngresoController::class);
    Route::resource('informes', InformeFinancieroController::class);
    Route::resource('roles', RolController::class);
});