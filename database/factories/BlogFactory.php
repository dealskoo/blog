<?php

namespace Database\Factories\Dealskoo\Blog\Models;

use Dealskoo\Blog\Models\Blog;
use Dealskoo\Country\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Blog::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'slug' => $this->faker->unique()->slug,
            'title' => $this->faker->title,
            'cover' => $this->faker->imageUrl,
            'content' => $this->faker->text,
            'published_at' => $this->faker->dateTime,
            'can_comment' => $this->faker->boolean,
            'views' => $this->faker->numberBetween(0, 1000),
            'country_id' => Country::factory()->create(),
        ];
    }
}
