<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\InventoryMovement;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    // FUNCIÓN PARA AÑADIR UN PRODUCTO 
    public function addStock(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $product = Product::findOrFail($request->product_id);
                $product->increment('stock', $request->quantity);

                // Registrar en Kardex
                InventoryMovement::create([
                    'product_id' => $product->id,
                    'user_id' => $request->user()->id,
                    'type' => 'entrada',
                    'quantity' => $request->quantity,
                    'reason' => $request->reason ?? 'Reabastecimiento manual'
                ]);
            });

            return response()->json(['message' => 'Stock actualizado']);
            
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // FUNCIÓN PARA VER EL HISTORIAL
    public function getAllHistory()
    {
        // Movimientos con info del producto y del usuario
        return InventoryMovement::with(['product', 'user'])
            ->latest() // Ordenar del más reciente al más antiguo
            ->take(50) // Solo los últimos 50
            ->get();
    }
}