<?php

namespace App\Services\Trivia;

class TriviaService
{

    public function __construct(private TriviaAPI $triviaAPI)
    {
        //
    }

    public function getCategories(): array
    {
        return $this->triviaAPI->getCategories();
    }

    public function getQuestion($params): array
    {
        $params['amount'] = $params['amount'] ?? null;
        $questions = $this->triviaAPI->getQuestions($params);

        return $questions['results'][0];
    }
}
