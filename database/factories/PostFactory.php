<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = post::class;
    
    public function definition()
    {
        return [
            "title" => $this->faker->sentence($maxNbChars = 1),
            "description" => $this->faker->realText($maxNbChars = 200),
            "user_id" => $this->faker->numberBetween(1,2)
        ];
    }
}
