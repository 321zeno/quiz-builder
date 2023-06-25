<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\Trivia\TriviaService;
use Illuminate\Support\Facades\Http;

class TriviaServiceTest extends TestCase
{

    private TriviaService $triviaService;

    public function setUp(): void
    {
        parent::setUp();

        Http::fake([
            'https://opentdb.com/api_category.php' => Http::response([
                [
                    'id' => 9,
                    'name' => 'General Knowledge'
                ],
                [
                    'id' => 10,
                    'name' => 'Entertainment: Books'
                ]
            ], 200),

            'https://opentdb.com/api.php*' => Http::response([
                'response_code' => 0,
                'results' => [
                    [
                        'category' => 'Entertainment: Television',
                        'type' => 'multiple',
                        'difficulty' => 'hard',
                        'question' => 'Which of these Nickelodeon game shows aired first?',
                        'correct_answer' => 'Double Dare',
                        'incorrect_answers' => [
                            'Figure It Out',
                            'Nickelodeon GUTS',
                            'Legends of the Hidden Temple'
                        ]
                    ]
                ]
            ], 200),
        ]);

        $this->triviaService = app()->make(TriviaService::class);
    }

    /**
     * @group quiz
     */
    public function test_retriving_categories(): void
    {
        $categories = $this->triviaService->getCategories();
        $this->assertEquals(2, count($categories));
        $this->assertEquals('General Knowledge', $categories[0]['name']);
        $this->assertEquals('Entertainment: Books', $categories[1]['name']);
    }

    /**
     * @group quiz
     */
    public function test_getting_a_question(): void
    {
        $question = $this->triviaService->getQuestion([
            'category' => 14,
            'difficulty' => 'hard',
            'type' => 'multiple'
        ]);

        $this->assertInstanceOf(\App\Services\Trivia\TriviaQuestionDTO::class, $question);
        $this->assertEquals('Entertainment: Television', $question->category);
        $this->assertEquals('multiple', $question->type);
        $this->assertEquals('hard', $question->difficulty);
        $this->assertEquals('Which of these Nickelodeon game shows aired first?', $question->question);
        $this->assertEquals('Double Dare', $question->correctAnswer);
        $this->assertEquals([
            'Figure It Out',
            'Nickelodeon GUTS',
            'Legends of the Hidden Temple'
        ], $question->incorrectAnswers);
    }
}
