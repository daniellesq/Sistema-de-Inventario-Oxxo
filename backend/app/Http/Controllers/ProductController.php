<?php

namespace App\Http\Controllers;

use App\Models\Product; // Importante: Importar el modelo
use Illuminate\Http\Request;

class ProductController extends Controller
{
    
     // Muestra la lista de productos (GET)
     
    public function index()
    {
        return Product::all();
    }

    
     // Guarda un nuevo producto (POST)
    public function store(Request $request)
    {
        // 1. Validamos que los datos vengan bien
        $request->validate([
            'sku' => 'required|numeric|digits_between:8,13|unique:products',
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        // 2. Creamos el producto
        $product = Product::create($request->all());

        // 3. Respondemos con éxito
        return response()->json([
            'message' => 'Producto guardado correctamente',
            'product' => $product
        ], 201);
    }

    /**
     * Muestra un producto específico (GET /products/{id})
     */
    public function show($id)
    {
        return Product::find($id);
    }

    /**
     * Actualiza un producto (PUT /products/{id})
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());
        return $product;
    }

    /**
     * Elimina un producto (DELETE /products/{id})
     */
    public function destroy($id)
    {
        return Product::destroy($id);
    }
}