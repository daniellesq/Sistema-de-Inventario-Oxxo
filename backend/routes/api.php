<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\InventoryController; 

// RUTAS PÚBLICAS 
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// RUTAS PROTEGIDAS (Necesita Token)
Route::middleware('auth:sanctum')->group(function () {
    
    // 1. Productos
    Route::apiResource('products', ProductController::class);
    
    // 2. Ventas (Caja)
    Route::post('/sales', [SaleController::class, 'store']); 
    
    // 3. Inventario (Surtir y Kardex)
    Route::post('/inventory/add', [InventoryController::class, 'addStock']);
    Route::get('/inventory/history/{id}', [InventoryController::class, 'history']);

    // 4. Salir
    Route::post('/logout', [AuthController::class, 'logout']);
    // Obtener historial
    Route::get('/inventory/all', [InventoryController::class, 'getAllHistory']);
    // Corte de caja
    Route::get('/sales/daily-summary', [SaleController::class, 'dailySummary']);

});