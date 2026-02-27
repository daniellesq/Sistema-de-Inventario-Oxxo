<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // --- BEBIDAS ---
            ['name' => 'Coca Cola 600ml', 'sku' => '7501055310886', 'price' => 19.00, 'stock' => 50, 'min_stock' => 10],
            ['name' => 'Agua Ciel 1L', 'sku' => '7501055304724', 'price' => 12.00, 'stock' => 60, 'min_stock' => 10],
            ['name' => 'Powerade Moras', 'sku' => '7501055320557', 'price' => 22.00, 'stock' => 20, 'min_stock' => 5],
            ['name' => 'Arizona Sandía 680ml', 'sku' => '7501055330001', 'price' => 19.50, 'stock' => 25, 'min_stock' => 5],
            ['name' => 'Monster Energy 473ml', 'sku' => '7501055340002', 'price' => 38.00, 'stock' => 15, 'min_stock' => 5],
            ['name' => 'Jumex Durazno 1L', 'sku' => '7501055350003', 'price' => 24.00, 'stock' => 20, 'min_stock' => 5],
            ['name' => 'Peñafiel Naranja 600ml', 'sku' => '7501055360004', 'price' => 16.00, 'stock' => 30, 'min_stock' => 8],
            ['name' => 'Cafe Andatti Americano', 'sku' => '7500000000003', 'price' => 21.00, 'stock' => 200, 'min_stock' => 20],

            // --- CERVEZA Y ALCOHOL ---
            ['name' => 'Cerveza Modelo Esp. Latón', 'sku' => '7501064191827', 'price' => 26.00, 'stock' => 100, 'min_stock' => 24],
            ['name' => 'Tecate Light Latón 473ml', 'sku' => '7501064192000', 'price' => 24.00, 'stock' => 100, 'min_stock' => 24],
            ['name' => 'Six Pack Carta Blanca', 'sku' => '7501064193000', 'price' => 78.00, 'stock' => 10, 'min_stock' => 3],
            ['name' => 'Caribe Cooler Durazno', 'sku' => '7501064194000', 'price' => 28.00, 'stock' => 15, 'min_stock' => 5],

            // --- BOTANAS Y DULCES ---
            ['name' => 'Sabritas Sal 45g', 'sku' => '7501011123450', 'price' => 18.00, 'stock' => 40, 'min_stock' => 8],
            ['name' => 'Ruffles Queso 45g', 'sku' => '7501011123451', 'price' => 18.00, 'stock' => 35, 'min_stock' => 8],
            ['name' => 'Doritos Nacho 58g', 'sku' => '7501011123452', 'price' => 19.00, 'stock' => 40, 'min_stock' => 8],
            ['name' => 'Cheetos Torciditos 52g', 'sku' => '7501011123453', 'price' => 16.00, 'stock' => 30, 'min_stock' => 8],
            ['name' => 'Sabritas Limón 45g', 'sku' => '7501011123454', 'price' => 18.00, 'stock' => 25, 'min_stock' => 8],
            ['name' => 'Gansito Marinela', 'sku' => '7501000153107', 'price' => 16.00, 'stock' => 30, 'min_stock' => 5],
            ['name' => 'Emperador Chocolate', 'sku' => '7501000112203', 'price' => 17.50, 'stock' => 25, 'min_stock' => 5],
            ['name' => 'Chokis Clasica', 'sku' => '7501000132409', 'price' => 17.00, 'stock' => 30, 'min_stock' => 5],
            ['name' => 'Bubulubu', 'sku' => '7501000142309', 'price' => 9.00, 'stock' => 80, 'min_stock' => 15],
            ['name' => 'Halls Cereza', 'sku' => '7501000160001', 'price' => 10.00, 'stock' => 50, 'min_stock' => 10],
            ['name' => 'Chicles Trident Menta', 'sku' => '7501000170002', 'price' => 12.00, 'stock' => 50, 'min_stock' => 10],
            ['name' => 'Mazapán De la Rosa', 'sku' => '7501000180003', 'price' => 8.00, 'stock' => 60, 'min_stock' => 10],

            // --- COMIDA RÁPIDA ---
            ['name' => 'Pizza Jamon y Queso', 'sku' => '7500000000001', 'price' => 35.00, 'stock' => 20, 'min_stock' => 5],
            ['name' => 'Pizza Pepperoni', 'sku' => '7500000000002', 'price' => 36.00, 'stock' => 15, 'min_stock' => 5],
            ['name' => 'Maruchan Instantanea', 'sku' => '041789001236', 'price' => 15.00, 'stock' => 100, 'min_stock' => 20],
            ['name' => 'Sándwich Jamón y Queso', 'sku' => '7500000000010', 'price' => 32.00, 'stock' => 8, 'min_stock' => 2],

            // --- CIGARROS ---
            ['name' => 'Marlboro Rojo 20s', 'sku' => '7501000200001', 'price' => 75.00, 'stock' => 50, 'min_stock' => 10],
            ['name' => 'Marlboro Fresh 20s', 'sku' => '7501000210002', 'price' => 75.00, 'stock' => 40, 'min_stock' => 10],
            ['name' => 'Pall Mall XL Pepino', 'sku' => '7501000220003', 'price' => 68.00, 'stock' => 30, 'min_stock' => 10],

            // --- FARMACIA Y CUIDADO PERSONAL ---
            ['name' => 'Condones Trojan 3pz', 'sku' => '7501000300001', 'price' => 65.00, 'stock' => 15, 'min_stock' => 5],
            ['name' => 'Aspirina 500mg 10pz', 'sku' => '7501000310002', 'price' => 35.00, 'stock' => 20, 'min_stock' => 5],
            ['name' => 'Suero 500ml', 'sku' => '7501000320003', 'price' => 38.00, 'stock' => 12, 'min_stock' => 3],
            ['name' => 'Papel Higiénico Pétalo 4pz', 'sku' => '7501000330004', 'price' => 28.00, 'stock' => 20, 'min_stock' => 5],
            ['name' => 'Shampoo Head & Shoulders', 'sku' => '7501000340005', 'price' => 55.00, 'stock' => 10, 'min_stock' => 2],

            // --- BASICOS DEL HOGAR ---
            ['name' => 'Hielo 5kg', 'sku' => '7500000000004', 'price' => 32.00, 'stock' => 10, 'min_stock' => 3],
            ['name' => 'Leche Lala Entera 1L', 'sku' => '7501000400001', 'price' => 26.00, 'stock' => 24, 'min_stock' => 6],
            ['name' => 'Pan Blanco Bimbo Gde', 'sku' => '7501000410002', 'price' => 48.00, 'stock' => 15, 'min_stock' => 4],
            ['name' => 'Huevo San Juan 12pz', 'sku' => '7501000420003', 'price' => 42.00, 'stock' => 10, 'min_stock' => 3],
            ['name' => 'Atún Dolores Agua', 'sku' => '7501000430004', 'price' => 22.00, 'stock' => 30, 'min_stock' => 5],
        ];

        foreach ($products as $prod) {
            Product::updateOrCreate(['sku' => $prod['sku']], $prod);
        }
    }
}