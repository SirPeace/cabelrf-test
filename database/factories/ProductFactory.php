<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $status = $this->faker->randomElement(ProductStatus::all());

        return [
            'title' => $this->faker->words(3, asText: true),
            'description' => $this->faker->paragraphs(asText: true),
            'price' => $this->faker->randomFloat(2, 10, 10000),
            'status_id' => $status->id,
            'available_count' => $status->name === 'active'
                ? $this->faker->numberBetween(1, 1000)
                : 0,
        ];
    }
}
