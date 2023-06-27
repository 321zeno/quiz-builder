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
        return $this->triviaAPI->getCategories()['trivia_categories'];
    }

    public function getQuestion($params): TriviaQuestionDTO
    {
        $params['amount'] = 1;
        $questions = $this->triviaAPI->getQuestions($params);
        $question = collect($questions['results'])->first();

        return new TriviaQuestionDTO(
            urldecode($question['category']),
            $question['type'],
            $question['difficulty'],
            urldecode($question['question']),
            urldecode($question['correct_answer']),
            array_map(fn ($answer) => urldecode($answer), $question['incorrect_answers'])
        );
    }
}
