<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Quiz;
use App\Models\User;
use App\Models\Question;
use App\Models\QuizResult;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuizResultTest extends TestCase
{
    private Quiz $quiz;

    public function setUp(): void
    {
        parent::setUp();

        DB::beginTransaction();

        $user = User::factory()->create();
        $this->quiz = Quiz::factory()
            ->has(Question::factory()->count(10))
            ->create([
                'user_id' => $user->id,
            ]);
    }

    /**
     * @group quiz
     */
    public function test_creating_a_quiz_result(): void
    {
        $quizResult = QuizResult::createForQuiz($this->quiz, 'quiz@quiz.quiz');
        $this->assertEquals($this->quiz->id, $quizResult->quiz_id);
        $this->assertEquals('quiz@quiz.quiz', $quizResult->email);
        $this->assertEquals(0, $quizResult->score);
        $this->assertEquals(10, $quizResult->out_of);

        $correctAnswer = $this->quiz->questions->first()->correct_answer;
        $quizResult->updateAnswers([
            $this->quiz->questions->first()->id => $correctAnswer,
        ]);
        $this->assertEquals(1, $quizResult->score);
        $secondCorrectAnswer = $this->quiz->questions->get(1)->correct_answer;
        $quizResult->updateAnswers([
            $this->quiz->questions->get(1)->id => $secondCorrectAnswer,
        ]);
        $this->assertEquals(2, $quizResult->score);
    }

    public function tearDown(): void
    {
        DB::rollBack();
    }
}
