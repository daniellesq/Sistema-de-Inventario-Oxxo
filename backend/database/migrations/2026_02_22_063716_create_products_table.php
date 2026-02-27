<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('sku')->unique(); // Código de barras
        $table->string('name'); // Nombre (Ej: Coca Cola 600ml)
        $table->text('description')->nullable();
        $table->decimal('price', 8, 2); // Precio (Ej: 18.50)
        $table->integer('stock'); // Cantidad actual
        $table->integer('min_stock')->default(5); // Alerta de stock bajo
        $table->string('image_url')->nullable(); // Foto del producto
        $table->boolean('is_active')->default(true); // Para "borrar" sin borrar
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
