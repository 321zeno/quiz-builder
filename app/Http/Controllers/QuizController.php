<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuizStoreRequest;
use App\Models\Quiz;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Quiz::with('questions')->get());
    }

    public function create()
    {
        return view('quiz.create');
    }

    public function edit($quizId, string $format = null)
    {
        $quiz = Quiz::with('questions')->findOrFail($quizId);

        if ($quiz->user_id !== auth()->id()) {
            abort(403);
        }

        return ($format === 'json')
            ? response()->json($quiz)
            : view('quiz.edit')->with(compact('quiz'));
    }

    public function store(QuizStoreRequest $request): JsonResponse
    {
        $quiz = ($request->id) ? Quiz::findOrFail($request->id) : new Quiz();
        $quiz->user_id = auth()->id();

        // wrap in transaction so we don't end up with partial data
        DB::beginTransaction();
        try {
            $quiz->fill([
                'title' => $request->title,
                'description' => $request->description,
            ]);
            $quiz->save();
            $questions = $quiz->questions;
            // new questions (without id's) are created
            collect($request->questions)
                ->filter(fn ($question) => !isset($question['id']))
                ->each(fn ($question) => $quiz->questions()->create($question));
            // remove questions that are not in the payload
            $questions->whereNotIn('id', collect($request->questions)->pluck('id')->filter())
                ->each(fn($question) => $question->delete());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return response()->json($quiz->load('questions'));
    }

    public function destroy($quizId): JsonResponse
    {
        $quiz = Quiz::findOrFail($quizId);

        if ($quiz->user_id !== auth()->id()) {
            abort(403);
        }

        $quiz->delete();

        return response()->json(['message' => 'Quiz deleted']);
    }
}
