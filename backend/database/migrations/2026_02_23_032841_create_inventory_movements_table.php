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
        Schema::create('inventory_movements', function (Blueprint $table) {
        $table->id();
        $table->foreignId('product_id')->constrained(); // Qué producto
        $table->foreignId('user_id')->constrained();    // Quién hizo el movimiento
        $table->enum('type', ['entrada', 'salida']);    // Tipo de movimiento
        $table->integer('quantity');                    // Cuántos
        $table->string('reason')->nullable();           // Razón (Ej: "Venta #123", "Compra a Sabritas")
        $table->timestamps();                           // Cuándo (Fecha)
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
    }
};
