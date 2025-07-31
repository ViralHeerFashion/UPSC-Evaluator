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
        Schema::create('student_answer_evaluation', function (Blueprint $table) {
            $table->id();
            $table->integer('student_answersheet_id');
            $table->string('question', 1000);
            $table->string('deconstruction', 1000);
            $table->text('model_answer');
            $table->integer('micro_marking_grid_total_marks');
            $table->integer('max_marks');
            $table->integer('marks_awarded');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_answer_evaluation');
    }
};
