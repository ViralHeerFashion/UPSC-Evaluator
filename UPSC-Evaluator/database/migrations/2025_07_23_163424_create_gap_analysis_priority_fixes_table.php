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
        Schema::create('gap_analysis_priority_fixes', function (Blueprint $table) {
            $table->id();
            $table->integer('student_answer_evaluation_id');
            $table->string('gap');
            $table->text('impact');
            $table->text('correct_action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gap_analysis_priority_fixes');
    }
};
