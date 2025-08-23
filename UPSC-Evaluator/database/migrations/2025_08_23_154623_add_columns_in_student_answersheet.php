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
        Schema::table('student_answersheet', function (Blueprint $table) {
            $table->integer('subject_id')->after('file_name');
            $table->boolean('is_evaluated')->default(false)->after('file_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_answersheet', function (Blueprint $table) {
            //
        });
    }
};
