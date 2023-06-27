<?php

namespace App\Services\Trivia;

class TriviaQuestionDTO
{
    public function __construct(
        public string $category,
        public string $type,
        public string $difficulty,
        public string $question,
        public string $correct_answer,
        public array $incorrect_answers,
    )
    {
        //
    }
}
