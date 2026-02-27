<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // El Jefe solo da la orden de ejecutar a los empleados
        $this->call([
            UserSeeder::class,    // 1. Crea al admin
            ProductSeeder::class, // 2. Crea los productos
        ]);
    }
}