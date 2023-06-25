<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Question;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuizTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        DB::beginTransaction();
        Question::unguard();
        User::unguard();
    }

    /**
     * @group quiz
     */
    public function test_quiz_relationships(): void
    {
        $user = User::factory()->create();
        $questions = Question::factory()->count(2)->make();

        $quiz = $user->quizzes()->create([
            'name' => 'Test Quiz',
            'description' => 'Test Quiz Description',
        ]);
        $quiz->questions()->saveMany($questions);

        $this->assertEquals(1, $quiz->user->id);
        $this->assertEquals(2, $quiz->questions->count());
    }

    public function tearDown(): void
    {
        DB::rollBack();
    }

}
