<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VentaController;

Route::get('/registros', function () {
    return view('registros');
})->middleware('auth');

Route::get('/venta', function () {
    return view('venta');
})->middleware('auth');

Route::post('/save-venta', [VentaController::class, 'saveVenta'])->middleware('auth');
Route::get('/get-ventas', [VentaController::class, 'getVentas'])->middleware('auth');
Route::delete('/venta/delete/{id}', [VentaController::class, 'deleteVenta'])->middleware('auth');
Route::post('/venta/pay-remaining', [VentaController::class, 'payRemaining'])->middleware('auth');
Route::get('/venta/detalles/{id}', [VentaController::class, 'detalles'])->name('venta.detalles');
Route::get('/venta/{ventaId}/ticket', [VentaController::class, 'generateTicket'])->name('venta.ticket');
Route::get('/venta/{id}/ticket', [VentaController::class, 'getTicket']);
Route::get('/venta/{id}/ticket', [VentaController::class, 'generateTicket'])->name('venta.ticket');

Route::get('/servicios', [ServicioController::class, 'index']);
Route::post('/servicios', [ServicioController::class, 'store']);
Route::put('/servicios/{id}', [ServicioController::class, 'update']);
Route::delete('/servicios/{id}', [ServicioController::class, 'destroy']);

Route::get('/', function () {
    return view('index');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/servicio', [AuthController::class, 'servi'])->name('misservi');
Route::get('/servicios', [AuthController::class, 'servi2'])->name('misservi');
Route::get('/registros', [AuthController::class, 'regis'])->name('registros');
Route::get('/registros', [AuthController::class, 'regis'])->name('registros')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/servicios', [ServicioController::class, 'index'])->name('servicios.index');
    Route::post('/servicios', [ServicioController::class, 'store'])->name('servicios.store');
    Route::put('/servicios/{id}', [ServicioController::class, 'update'])->name('servicios.update');
    Route::delete('/servicios/{id}', [ServicioController::class, 'destroy'])->name('servicios.destroy');
});
