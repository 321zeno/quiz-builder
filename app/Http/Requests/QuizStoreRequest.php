<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuizStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (!auth()->check()) {
            return false;
        }

        if ($this->id) {
            return auth()->user()->quizzes()->where('id', $this->id)->exists();
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'nullable|integer|exists:quizzes,id',
            'title' => 'required|string',
            'description' => 'required|string',

            'questions' => 'required|array',
            'questions.*.id' => 'nullable|integer|exists:questions,id',
            'questions.*.question' => 'required|string',
            'questions.*.category' => 'required|string',
            'questions.*.difficulty' => 'required|string',
            'questions.*.type' => 'required|string',
            'questions.*.correct_answer' => 'required|string',
            'questions.*.incorrect_answers' => 'required|array',
        ];
    }
}
