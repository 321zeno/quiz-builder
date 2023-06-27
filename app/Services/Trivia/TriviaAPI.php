<?php

namespace App\Services\Trivia;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

final class TriviaAPI
{
    private const ENCODING = 'url3986';

    private const HOST = 'https://opentdb.com/';

    private ?string $sessionToken = null;

    private ?Carbon $sessionTokenExpiry = null;

    /**
     * Request a session token from the API.
     */
    public function requestSessionToken(): string
    {
        $response = Http::get(static::HOST . 'api_token.php', [
            'command' => 'request'
        ])->json();

        $this->sessionToken = $response['token'];

        return $this->sessionToken;
    }

    /**
     * Retrieves a new token if the current one is expired
     * (session tokens are deleted after 6 hours of inactivity)
     */
    private function useSessionToken(): string
    {
        if (!$this->sessionTokenExpiry || $this->sessionTokenExpiry->isPast()) {
            cache()->set('session_token', $this->requestSessionToken(), 6 * 60 * 60);
        }

        $this->sessionTokenExpiry = now()->addHours(6);

        return $this->sessionToken;
    }

    public function getSessionTokenExpiry()
    {
        return $this->sessionTokenExpiry;
    }

    public function getCategories(): array
    {
        return Http::get(static::HOST . 'api_category.php')->json();
    }

    public function getQuestions($params): array
    {
        $params['amount'] = $params['amount'] ?? null;
        $params['category'] = $params['category'] ?? null;
        $params['difficulty'] = $params['difficulty'] ?? null;
        $params['type'] = $params['type'] ?? null;

        $params['token'] = $this->useSessionToken();
        $params['encode'] = static::ENCODING;

        return Http::get(static::HOST . 'api.php', array_filter($params))->json();
    }
}
