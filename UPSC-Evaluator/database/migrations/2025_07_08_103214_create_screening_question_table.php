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
        Schema::create('screening_question', function (Blueprint $table) {
            $table->id();
            $table->string('question', 500);
            $table->tinyInteger('question_type')->comment('1 for mcq and 2 for short question');
            $table->json('options')->nullable()->comment('if question_type 1 then selected options');
        });

        DB::table('screening_question')->insert([
            [
                'question' => "Which year's Civil Services Exam are you targeting?",
                'question_type' => 1,
                'options' => json_encode(['2025', '2026', '2027 or later', "I'm still exploring"])
            ],
            [
                'question' => 'What is your primary medium for writing Mains answers?',
                'question_type' => 1,
                'options' => json_encode(['English', 'हिन्दी (Hindi)']),
            ],
            [
                'question' => 'Great! What is your optional subject? (e.g., PSIR, Sociology, Anthropology)',
                'question_type' => 2,
                'options' => null
            ],
            [
                'question' => 'Which of these best describes your current stage of UPSC preparation?',
                'question_type' => 1,
                'options' => json_encode(['Just starting out (Beginner)', 'Have attempted Prelims before', 'Have written Mains before', 'Have appeared for the Interview'])
            ],
            [
                'question' => "We're curious! How did you discover our app?",
                'question_type' => 1,
                'options' => json_encode(['Friend or Colleague', 'WhatsApp Group', 'YouTube', 'Instagram / Facebook', 'Google Search', 'Other'])
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('screening_question');
    }
};
