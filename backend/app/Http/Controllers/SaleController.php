<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Product;
use Illuminate\Support\Facades\DB; // Importante para la transacción

class SaleController extends Controller
{
    public function store(Request $request)
    {
        // El frontend nos enviará un array "cart" con {id, quantity}
        $request->validate([
            'cart' => 'required|array|min:1',
            'cart.*.id' => 'required|exists:products,id',
            'cart.*.quantity' => 'required|integer|min:1'
        ]);

        try {
            // INICIO DE LA TRANSACCIÓN (Todo o nada)
            $sale = DB::transaction(function () use ($request) {
                
                // 1. Crear el Ticket (Cabecera)
                $sale = Sale::create([
                    'user_id' => $request->user()->id, // El usuario logueado
                    'total' => 0 // Lo calcularemos abajo
                ]);

                $total = 0;

                // 2. Procesar cada producto del carrito
                foreach ($request->cart as $item) {
                    $product = Product::lockForUpdate()->find($item['id']); // Bloqueamos el producto para que nadie más lo compre a la vez

                    // Checar stock
                    if ($product->stock < $item['quantity']) {
                        throw new \Exception("No hay suficiente stock de " . $product->name);
                    }

                    // Descontar inventario
                    $product->decrement('stock', $item['quantity']);

                    \App\Models\InventoryMovement::create([
                    'product_id' => $product->id,
                    'user_id' => $request->user()->id,
                    'type' => 'salida',
                    'quantity' => $item['quantity'],
                    'reason' => 'Venta #' . $sale->id
                    ]);
                    
                    // Guardar el detalle
                    SaleDetail::create([
                        'sale_id' => $sale->id,
                        'product_id' => $product->id,
                        'quantity' => $item['quantity'],
                        'price' => $product->price
                    ]);

                    $total += $product->price * $item['quantity'];
                }

                // 3. Actualizar el total final del ticket
                $sale->update(['total' => $total]);

                return $sale;
            });

            return response()->json(['message' => 'Venta registrada', 'sale' => $sale], 201);

        } catch (\Exception $e) {
            // Si algo falla, Laravel deshace todo automáticamente gracias a la transacción
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    // ... al final de la clase SaleController ...

    // Función para el Corte de Caja
    public function dailySummary()
    {
        // Usamos Carbon para obtener la fecha de hoy
        $today = \Carbon\Carbon::today();

        $totalVendido = Sale::whereDate('created_at', $today)->sum('total');
        $cantidadVentas = Sale::whereDate('created_at', $today)->count();
        
        // Opcional: Obtener el producto más vendido hoy
        // Esto es un query avanzado, si te da error bórralo, pero impresiona mucho
        $productoEstrella = \Illuminate\Support\Facades\DB::table('sale_details')
            ->select('products.name', \Illuminate\Support\Facades\DB::raw('SUM(sale_details.quantity) as total_qty'))
            ->join('sales', 'sales.id', '=', 'sale_details.sale_id')
            ->join('products', 'products.id', '=', 'sale_details.product_id')
            ->whereDate('sales.created_at', $today)
            ->groupBy('products.name')
            ->orderByDesc('total_qty')
            ->first();

        return response()->json([
            'total_money' => $totalVendido,
            'total_sales' => $cantidadVentas,
            'top_product' => $productoEstrella ? $productoEstrella->name : 'N/A'
        ]);
    }

}