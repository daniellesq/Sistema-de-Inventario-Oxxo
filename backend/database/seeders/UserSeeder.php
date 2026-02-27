<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Creamos un usuario Admin por defecto
        User::create([
            'name' => 'Gerente Oxxo',
            'email' => 'admin@oxxo.com',
            'password' => Hash::make('contraoxxo123'), // Contraseña segura
        ]);
    }
}