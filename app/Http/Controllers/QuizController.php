<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class QuizController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            [
                'id' => 1,
                'title' => 'Demo Quiz',
            ]
        ]);
    }

    public function create()
    {
        return view('quiz.create');
    }

}
