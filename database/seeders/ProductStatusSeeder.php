<?php

namespace Database\Seeders;

use App\Models\ProductStatus;
use Illuminate\Database\Seeder;

class ProductStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductStatus::factory()->createMany([
            [
                'name' => 'active',
                'alias' => 'Active',
            ],
            [
                'name' => 'out-of-stock',
                'alias' => 'Out of stock',
            ],
            [
                'name' => 'archived',
                'alias' => 'Archived',
            ],
        ]);
    }
}
