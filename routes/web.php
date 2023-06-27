<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\TriviaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect(route('dashboard'));
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('quiz/create', [QuizController::class, 'create'])->name('quiz.create');
});

Route::middleware('auth')->prefix('json')->group(function () {
    Route::get('quizzes', [QuizController::class, 'index'])->name('quizzes.index');

    Route::get('trivia/categories', [TriviaController::class, 'categories'])->name('trivia.categories');
    Route::post('trivia/search', [TriviaController::class, 'search'])->name('trivia.search');
});

require __DIR__.'/auth.php';
