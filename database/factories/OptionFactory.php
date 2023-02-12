<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class OptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $question = Question::factory()->create();
        return [
            'question_id' => $question->id,
            'text' => $this->faker->word,
            'correct' => $this->faker->boolean,
        ];
    }
}
