<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PasarelaController;
use App\Http\Controllers\AdminPedidoController;
use App\Http\Controllers\IAImagenController;
use App\Http\Controllers\ChatbotController;


/*
|--------------------------------------------------------------------------
| Rutas principales del proyecto D'Nokali / SweetCode
|--------------------------------------------------------------------------
*/

// 🟢 Página principal (vista pública)
Route::get('/', function () {
    return redirect()->route('index');
});

Route::get('/inicio', [IndexController::class, 'inicio'])->name('index');
Route::get('/inicio/{id}', [IndexController::class, 'detalleProducto'])->name('index.detalleProducto');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::get('/registro', [AuthController::class, 'showRegister'])->name('registro');
Route::post('/registro', [AuthController::class, 'register'])->name('registro.process');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===========================================================
// 🧁 RUTAS DE CLIENTE
// ===========================================================
Route::prefix('cliente')->group(function () {

    // Catálogo
    Route::get('/catalogo', [ClienteController::class, 'catalogo'])->name('cliente.catalogo');
    Route::get('/catalogo/{id}', [ClienteController::class, 'detalleProducto'])->name('cliente.catalogo.detalle');

    // Personalizados
    Route::get('/personalizados', [ClienteController::class, 'personalizados'])->name('cliente.personalizados');
    Route::get('/personalizados/nueva', [ClienteController::class, 'nuevaSolicitud'])->name('cliente.personalizados.nueva');
    Route::post('/personalizados/guardar', [ClienteController::class, 'guardarSolicitud'])->name('cliente.personalizados.guardar');
    Route::get('/personalizados/{id}', [ClienteController::class, 'detallesPersonalizado'])->name('cliente.personalizados.detalles');
    Route::get('/cliente/personalizados/{id}/editar', [ClienteController::class, 'editarPersonalizado'])
        ->name('cliente.personalizados.editar');
    Route::put('/cliente/personalizados/{id}/actualizar', [ClienteController::class, 'actualizarPersonalizado'])
        ->name('cliente.personalizados.actualizar');
    Route::delete('/cliente/personalizados/{id}/eliminar', [ClienteController::class, 'eliminarPersonalizado'])
        ->name('cliente.personalizados.eliminar');

    // Generar imagen con IA para personalizados
    Route::post('/generar-imagen-ia', [IAImagenController::class, 'generarImagenIA'])
        ->name('cliente.personalizado.generarIA');

    Route::get('/nosotros', function () {
        return view('cliente.nosotros');
    })->name('cliente.nosotros');

    Route::get('/pedidos/{id}/inline',
    [ClienteController::class, 'detalleInline'])
    ->name('cliente.pedidos.detalle.inline');





    // Pedidos
    Route::get('/pedidos', [ClienteController::class, 'verPedidos'])->name('cliente.pedidos');
    Route::get('/pedidos/{id}', [ClienteController::class, 'detallesPedidos'])->name('cliente.pedidos.detalles');

    //  Carrito
    Route::get('/carrito/obtener', [CarritoController::class, 'obtenerCarrito'])->name('carrito.obtener');
    Route::post('/carrito/agregar/{id}', [CarritoController::class, 'agregar'])->name('carrito.agregar');
    Route::post('/carrito/actualizar/{id}', [CarritoController::class, 'actualizarCantidad'])->name('carrito.actualizar');
    Route::post('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
    Route::post('/carrito/vaciar', [CarritoController::class, 'vaciar'])->name('carrito.vaciar');

    // ================================
    // PASARELA DE PAGO (3 pasos)
    // ================================

    // ================================
    // PASARELA DE PAGO (Checkout)
    // ================================

    // Vista única del checkout (carrito + datos + pago)
    Route::get('/pasarela/pago', [PasarelaController::class, 'pago'])
        ->name('cliente.pasarela.pago');

    // Guardar todo (datos + pago + pedido)
    Route::post('/pasarela/pago', [PasarelaController::class, 'guardarPago'])
        ->name('cliente.pasarela.pago.guardar');

    // Confirmación final
    Route::get('/pasarela/confirmacion', [PasarelaController::class, 'confirmacion'])
        ->name('cliente.pasarela.confirmacion');



});


// ===========================================================
// 🍰 RUTAS DE ADMINISTRADOR
// ===========================================================
Route::prefix('admin')->group(function () {
    
    // =============================
    // PRODUCTOS
    // =============================
    Route::get('/productos', [AdminController::class, 'productos'])->name('admin.productos');
    Route::get('/productos/agregar', [AdminController::class, 'formAgregarProducto'])->name('admin.productos.agregar');
    Route::post('/productos/store', [AdminController::class, 'storeProducto'])->name('productos.store');
    Route::get('/productos/{id}', [AdminController::class, 'detalleProducto'])->name('admin.productos.detalle');
    Route::get('/productos/{id}/editar', [AdminController::class, 'formEditarProducto'])->name('admin.productos.editar');
    Route::put('/productos/{id}', [AdminController::class, 'updateProducto'])->name('admin.productos.update');
    Route::delete('/productos/{id}', [AdminController::class, 'eliminarProducto'])->name('admin.productos.eliminar');


    // =============================
    // PEDIDOS (IMPORTANTE)
    // =============================
    Route::get('/pedidos', [AdminPedidoController::class, 'verPedidos'])
        ->name('admin.pedidos');

    Route::get('/pedidos/{id}', [AdminPedidoController::class, 'detallesPedido'])
        ->name('admin.pedidos.detalles');

    Route::post('/pedidos/{id}/estado', [AdminPedidoController::class, 'actualizarEstado'])
        ->name('admin.pedidos.estado');


    // =============================
    // PERSONALIZADOS
    // =============================
    Route::get('/personalizados', [AdminController::class, 'personalizados'])->name('admin.personalizados');
    Route::get('/personalizados/{id}',[AdminController::class, 'detallesPersonalizado'])->name('admin.personalizados.detalles');
    Route::post('/personalizados/{id}/estado', [AdminController::class, 'actualizarEstadoPersonalizado'])->name('admin.personalizados.estado');
    Route::post('/personalizados/{id}/costo', [AdminController::class, 'actualizarCostoPersonalizado'])->name('admin.personalizados.costo');

    // =============================
    // PROVEEDORES
    // =============================
    Route::get('/proveedores', [AdminController::class, 'proveedores'])->name('admin.proveedores');
    Route::get('/proveedores/crear', [AdminController::class, 'crearProveedor'])->name('admin.proveedores.create');
    Route::post('/proveedores', [AdminController::class, 'storeProveedor'])->name('admin.proveedores.store');
    Route::get('/proveedores/{id}/editar', [AdminController::class, 'editarProveedor'])->name('admin.proveedores.edit');
    Route::put('/proveedores/{id}', [AdminController::class, 'updateProveedor'])->name('admin.proveedores.update');
    Route::delete('/proveedores/{id}', [AdminController::class, 'eliminarProveedor'])->name('admin.proveedores.destroy');


    // =============================
    // CATEGORÍAS
    // =============================
    Route::get('/categorias', [AdminController::class, 'categorias'])->name('admin.categorias');
    Route::get('/categorias/crear', [AdminController::class, 'crearCategoria'])->name('admin.categorias.create');
    Route::post('/categorias', [AdminController::class, 'storeCategoria'])->name('admin.categorias.store');
    Route::get('/categorias/{id}/editar', [AdminController::class, 'editarCategoria'])->name('admin.categorias.edit');
    Route::put('/categorias/{id}', [AdminController::class, 'updateCategoria'])->name('admin.categorias.update');
    Route::delete('/categorias/{id}', [AdminController::class, 'eliminarCategoria'])->name('admin.categorias.destroy');
});


// ===========================================================
// 🤖 CHATBOT NOKALITO
// ===========================================================
Route::post('/chatbot-mensaje', [ChatbotController::class, 'responder'])
    ->name('chatbot.responder');


