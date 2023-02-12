<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questions = [
            [
                'question' => 'Qual é a capital do Brasil?',
                'options' => [
                    ['text' => 'Rio de Janeiro', 'correct' => false],
                    ['text' => 'Belo Horizonte', 'correct' => false],
                    ['text' => 'São Paulo', 'correct' => false],
                    ['text' => 'Brasília', 'correct' => true],
                ],
            ],
            [
                'question' => 'Quantos estados tem o Brasil?',
                'options' => [
                    ['text' => '23', 'correct' => false],
                    ['text' => '26', 'correct' => false],
                    ['text' => '27', 'correct' => true],
                    ['text' => '28', 'correct' => false],
                ],
            ],
        ];

        foreach ($questions as $questionData) {
            $question = \App\Models\Question::create([
                'question' => $questionData['question'],
            ]);

            foreach ($questionData['options'] as $optionData) {
                \App\Models\Option::create([
                    'question_id' => $question->id,
                    'text' => $optionData['text'],
                    'correct' => $optionData['correct'],
                ]);
            }
        }
    }
}
