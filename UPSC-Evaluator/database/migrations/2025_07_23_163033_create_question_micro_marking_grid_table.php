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
        Schema::create('question_micro_marking_grid', function (Blueprint $table) {
            $table->id();
            $table->integer('student_answer_evaluation_id');
            $table->string('component', 255);
            $table->float('weight');
            $table->integer('max_marks');
            $table->float('marks_awarded');
            $table->text('justifications');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_micro_marking_grid');
    }
};
