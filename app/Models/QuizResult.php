<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuizResult extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'quiz_id' => 'integer',
        'score' => 'integer',
        'out_of' => 'integer',
        'answers' => 'array',
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public static function createForQuiz(Quiz $quiz, string $email): self
    {
        return static::create([
            'quiz_id' => $quiz->id,
            'email' => $email,
            'score' => 0,
            'out_of' => $quiz->questions()->count(),
            'answers' => [],
        ]);
    }

    public function updateAnswers(array $answers): self
    {
        $this->answers = $answers;
        foreach ($answers as $questionId => $answer) {
            $question = Question::find($questionId);
            if ($question->correct_answer === $answer) {
                $this->score++;
            }
        }
        $this->save();

        return $this;
    }
}
