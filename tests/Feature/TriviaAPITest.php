<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\Trivia\TriviaAPI;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class TriviaAPITest extends TestCase
{
    private TriviaAPI $triviaAPI;

    public function setUp(): void
    {
        parent::setUp();

        Http::fake([
            'https://opentdb.com/api_token.php' => Http::response([
                [
                    'response_code' => 0,
                    'response_code' => 'Token Generated Successfully!',
                    'token' => 'token'
                ],
            ], 200),
        ]);
        Http::fake([
            'https://opentdb.com/api.php*' => Http::response([], 200),
        ]);

        $this->triviaAPI = app()->make(TriviaAPI::class);
    }

    /**
     * @group quiz
     */
    public function test_session_token_expiry(): void
    {
        Carbon::setTestNow(now());

        $this->assertNull($this->triviaAPI->getSessionTokenExpiry());
        $this->triviaAPI->getQuestions([]);
        $this->assertNotNull($this->triviaAPI->getSessionTokenExpiry());
        $this->assertTrue($this->triviaAPI->getSessionTokenExpiry()->equalTo(now()->addHours(6)));
    }
}
