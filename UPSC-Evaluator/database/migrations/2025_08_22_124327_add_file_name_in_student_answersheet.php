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
            $table->string('file_name', 255)->after('pdf')->comment('Original file name of the uploaded answer sheet');
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
