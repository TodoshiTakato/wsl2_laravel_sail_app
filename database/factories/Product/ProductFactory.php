<?php

namespace Database\Factories\Product;

use Illuminate\Database\Eloquent\Factories\Factory;

// Customized additions:

use App\Models\Product;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
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
     * @return array<string, mixed>
     */
    public function definition()
    {
        //  fake()->setDefaultTimezone('Asia/Tashkent');

        return [
            'name' => fake()->word,
            'description' => fake()->paragraph($nbSentences = 3, $variableNbSentences = true),
            'price' => fake()->numberBetween($min = 1000000, $max = 10000000), // add 00 at the end because price is integer
            'status' => fake()->randomElement($array = array (0, 1)),
            'category_id' => Category::all()->pluck('id')->random(),
//        'created_at' => fake()->dateTimeBetween('-4 months', 'now', null),
//        'updated_at' => fake()->dateTimeBetween('-4 months','now', null),
        ];
    }
}


//$factory->afterCreating(App\Product::class, function ($product, $faker) {
//    $category = factory(App\Category::class)->make();
//    $product->category()->associate($category);
//    $order_item = factory(App\OrderItem::class)->make();
//    $product->order_item()->associate($order_item);
//    $product->category()->associate(factory(App\Category::class)->make());
//    $product->order_item()->associate(factory(App\OrderItem::class)->make());
//});
