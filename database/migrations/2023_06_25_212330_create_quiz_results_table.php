<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quiz_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quiz_id');
            $table->string('email');
            $table->json('answers')
                ->comment('JSON array of question IDs and answers')->nullable();
            $table->unsignedInteger('score')->nullable();
            $table->unsignedInteger('out_of')->nullable();
            $table->enum('status', ['unknown', 'in-progress', 'completed'])->default('unknown');
            $table->timestamps();
        });

        Schema::table('quiz_results', function (Blueprint $table) {
            $table->foreign('quiz_id')->references('id')->on('quizzes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_results');
    }
};
