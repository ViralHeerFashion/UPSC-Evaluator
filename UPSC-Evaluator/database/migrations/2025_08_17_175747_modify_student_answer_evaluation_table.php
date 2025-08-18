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
        Schema::table('student_answer_evaluation', function (Blueprint $table) {
            $table->string('model_answer_intro', 1000)->nullable()->change();
            $table->string('model_answer_conclusion', 1000)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_answer_evaluation', function (Blueprint $table) {
            //
        });
    }
};
