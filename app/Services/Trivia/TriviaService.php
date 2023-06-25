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

    public function getQuestion($params): TriviaQuestionDTO
    {
        $questions = $this->triviaAPI->getQuestions($params);
        $question = collect($questions['results'])->first();

        return new TriviaQuestionDTO(
            $question['category'],
            $question['type'],
            $question['difficulty'],
            $question['question'],
            $question['correct_answer'],
            $question['incorrect_answers'],
        );
    }
}
