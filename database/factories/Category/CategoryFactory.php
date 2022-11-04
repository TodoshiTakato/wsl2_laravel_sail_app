<?php

namespace Database\Factories\Category;

use Illuminate\Database\Eloquent\Factories\Factory;

// Customized additions:

use App\Models\Category;

///** @var Factory $factory */
//use Faker\Generator as Faker;
//use Illuminate\Support\Facades\Hash;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        //  fake()->setDefaultTimezone('Asia/Tashkent');
        return [
            'name'       => fake()->unique()->word,
//        'parent_id'      => fake()->optional($weight = 0.2, $default = null)->randomElement([1,2,3,4,5,6,7,8]),
//        'parent_id'      => factory(Category::class)->make(),
//        'created_at'     => fake()->dateTimeBetween('-4 months', 'now', null),
//        'updated_at'     => fake()->dateTimeBetween('-4 months','now', null),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function (Category $category) {
            //
        })->afterCreating(function (Category $category) {
            //    $category->parent_category()->save(factory(Category::class)->make());
            $category->child_category()->associate(fake()->optional($weight = 0.2, $default = null)->randomElement([1,2,3,4,5,6,7,8]));
            $category->save();
        });
    }
}
