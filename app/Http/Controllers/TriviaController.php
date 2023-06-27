<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Services\Trivia\TriviaService;
use App\Http\Requests\QuestionSearchRequest;

class TriviaController extends Controller
{
    public function __construct(private TriviaService $triviaService)
    {
    }

    public function search(QuestionSearchRequest $request): JsonResponse
    {
        $input = $request->validated();
        $params = array_filter($input['params']);
        $question = $this->triviaService->getQuestion($params);

        return response()->json($question);
    }

    public function categories(): JsonResponse
    {
        $categories = collect($this->triviaService->getCategories())
            ->map(function ($category) {
                return [
                    'value' => $category['id'],
                    'name' => $category['name'],
                ];
            });

        return response()->json($categories);
    }
}
