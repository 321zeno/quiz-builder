<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category' => $this->faker->word(),
            'type' => $this->faker->word(),
            'difficulty' => $this->faker->word(),
            'question' => $this->faker->sentence(),
            'correct_answer' => $this->faker->word(),
            'incorrect_answers' => $this->faker->words(),
        ];
    }
}
