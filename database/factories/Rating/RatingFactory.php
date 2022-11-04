<?php

namespace Database\Factories\Rating;

use Illuminate\Database\Eloquent\Factories\Factory;

// Customized additions:

use App\Models\Rating;
use App\Models\User;
use App\Models\Task;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rating>
 */
class RatingFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rating::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        //  fake()->setDefaultTimezone('Asia/Tashkent');

        return [
            'rating' => fake()->randomElement(array('1','2','3', '4', '5')),
            'comment' => fake()->realTextBetween($minNbChars = 60, $maxNbChars = 80, $indexSize = 2),
            'user_id' => factory(User::class),
            'task_id' => factory(Task::class),
//        'created_at' => fake()->dateTimeBetween('-4 months', 'now', null),
//        'updated_at' => fake()->dateTimeBetween('-4 months','now', null),
        ];
    }
}
