<?php

namespace Database\Factories\User;

use Illuminate\Database\Eloquent\Factories\Factory;

// Customized additions:

use App\Models\User;
use Illuminate\Support\Str;
// use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        //  fake()->setDefaultTimezone('Asia/Tashkent');
        return [
            'name'              => fake()->name(),
            'first_name'        => fake()->firstName,
            'last_name'         => fake()->lastName,
            'username'          => fake()->unique()->userName,
            'email'             => fake()->unique()->safeEmail,  //  'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),

            // with the aim to change to 'password' => Hash::make('12345678')
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // 'password'

            'remember_token'    => Str::random(10),
            'device'            => null,
            'is_active'         => null,
            'is_user'           => null,
            'is_admin'          => null,
            'role_id'           => null
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state( fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
