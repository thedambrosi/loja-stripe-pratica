<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Caneca de Cerâmica',
            'description' => 'Caneca de cerâmica 300ml, ideal para café ou chá.',
            'price_cents' => 3990,
        ]);

        Product::create([
            'name' => 'Camiseta Estampada',
            'description' => 'Camiseta 100% algodão com estampa exclusiva.',
            'price_cents' => 7990,
        ]);

        Product::create([
            'name' => 'Adesivo de Vinil (Kit)',
            'description' => 'Kit com 5 adesivos de vinil resistentes à água.',
            'price_cents' => 1990,
        ]);
    }
}
