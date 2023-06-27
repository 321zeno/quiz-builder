<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Services\Trivia\TriviaService;
use App\Http\Requests\TriviaSearchRequest;

class TriviaController extends Controller
{
    public function __construct(private TriviaService $triviaService)
    {
    }

    public function search(TriviaSearchRequest $request): JsonResponse
    {
        $params = array_filter($request->validated());
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
