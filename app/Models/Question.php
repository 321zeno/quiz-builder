<?php

namespace App\Models;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Model;
use App\Services\Trivia\TriviaQuestionDTO;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'incorrect_answers' => 'array'
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public static function createFromTriviaQuestionDTO(Quiz $quiz, TriviaQuestionDTO $triviaQuestion): self
    {
        return static::create([
            'quiz_id' => $quiz->id,
            'category' => $triviaQuestion->category,
            'type' => $triviaQuestion->type,
            'difficulty' => $triviaQuestion->difficulty,
            'question' => $triviaQuestion->question,
            'correct_answer' => $triviaQuestion->correctAnswer,
            'incorrect_answers' => $triviaQuestion->incorrectAnswers,
        ]);
    }

    public function getAnswersAttribute(): array
    {
        $answers = $this->incorrect_answers;
        $answers[] = $this->correct_answer;

        shuffle($answers);

        return $answers;
    }
}
