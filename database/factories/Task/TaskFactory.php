<?php

namespace Database\Factories\Task;

use Illuminate\Database\Eloquent\Factories\Factory;

// Customized additions:

use App\Models\Task;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        //  fake()->setDefaultTimezone('Asia/Tashkent');
        $starts_at = Carbon::createFromTimestamp(
            fake()
                ->dateTimeBetween($startDate = '+2 days', $endDate = '+1 week')
                ->getTimeStamp()
        );
        $ends_at = Carbon::createFromFormat('Y-m-d H:i:s', $starts_at)
            ->addHours( fake()->numberBetween( 1, 8 ) );
        $time_spent = $starts_at->diffInHours($ends_at);

        return [
//            'user_id' => factory(\App\User::class),   TODO: Не закончен переход из Laravel 7 в Laravel 9
            'name' => fake()->sentence($nbWords = 3, $variableNbWords = true),
            'details' => fake()->realTextBetween($minNbChars = 60, $maxNbChars = 80, $indexSize = 2),
            'status' => fake()->randomElement(array(0, 1)),
            'priority' => fake()->randomElement(array(0, 1, 2, 3, 4, 5)),
            'start_time' => $starts_at,
            'finish_time' => $ends_at,
            'time_spent' => $time_spent,
//        'created_at' => fake()->dateTimeBetween('-4 months', 'now', null),
//        'updated_at' => fake()->dateTimeBetween('-4 months','now', null),
        ];
    }
}
