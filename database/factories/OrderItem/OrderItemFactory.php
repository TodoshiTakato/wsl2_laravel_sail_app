<?php

namespace Database\Factories\OrderItem;

use Illuminate\Database\Eloquent\Factories\Factory;

// Customized additions:

use App\Models\OrderItem;

use App\Models\Order;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderItem::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        fake()->setDefaultTimezone('Asia/Tashkent');
        return [
            'order_id' => factory(Order::class),
            'product_id' => Product::all()->pluck('id')->random(),
            'quantity' => fake()->randomNumber($nbDigits = 2, $strict = false),
            'item_price' => fake()->numberBetween($min = 1000000, $max = 10000000), // add 00 at the end because price is integer
//            'created_at' => fake()->dateTimeBetween('-4 months', 'now', null),
//            'updated_at' => fake()->dateTimeBetween('-4 months','now', null),
        ];
    }
}


