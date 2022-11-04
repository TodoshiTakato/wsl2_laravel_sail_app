<?php

namespace Database\Factories\Order;

use Illuminate\Database\Eloquent\Factories\Factory;

// Customized additions:

use App\Models\Order;
use App\Models\User;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()  //  $faker->setDefaultTimezone('Asia/Tashkent');
    {
        return [
            'name'        => fake()->unique()->word,
            'user_id'     => User::factory(),
            'total_price' => fake()->numberBetween($min = 1000000, $max = 10000000), // add 00 at the end because price is integer
            'paid'        => fake()->randomElement($array = array (true, false)),
            'paid_at'     => fake()->dateTimeBetween('-4 months', 'now', null),
//            'created_at' => fake()->dateTimeBetween('-4 months', 'now', null),
//            'updated_at' => fake()->dateTimeBetween('-4 months','now', null),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function (Order $category) {
            //
        })->afterCreating(function (Order $category) {
            //
        });
    }
}

