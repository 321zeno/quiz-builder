<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Quiz;
use App\Models\User;
use App\Models\Question;
use Illuminate\Support\Facades\DB;
use App\Services\Trivia\TriviaQuestionDTO;

class QuestionTest extends TestCase
{

    private Quiz $quiz;

    public function setUp(): void
    {
        parent::setUp();

        DB::beginTransaction();

        $user = User::factory()->create();
        $this->quiz = Quiz::factory()->create([
            'user_id' => $user->id,
        ]);
    }

    /**
     * @group quiz
     */
    public function test_creating_from_trivia_dto(): void
    {
        $triviaQuestion = new TriviaQuestionDTO(
            category: 'Entertainment: Video Games',
            type: 'multiple',
            difficulty: 'hard',
            question: 'What was the first game to feature Mario?',
            correctAnswer: 'Donkey Kong',
            incorrectAnswers: [
                'Super Mario Bros.',
                'Mario Bros.',
                'Donkey Kong Jr.',
            ],
        );

        $question = Question::createFromTriviaQuestionDTO($this->quiz, $triviaQuestion);

        $this->assertEquals($this->quiz->id, $question->quiz_id);
        $this->assertEquals('Entertainment: Video Games', $question->category);
        $this->assertEquals('multiple', $question->type);
        $this->assertEquals('hard', $question->difficulty);
        $this->assertEquals('What was the first game to feature Mario?', $question->question);
        $this->assertEquals('Donkey Kong', $question->correct_answer);
        $this->assertEquals([
            'Super Mario Bros.',
            'Mario Bros.',
            'Donkey Kong Jr.',
        ], $question->incorrect_answers);
    }

    public function tearDown(): void
    {
        DB::rollBack();
    }
}
