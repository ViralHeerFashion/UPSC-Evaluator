<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->onUpdate(DB::raw('CURRENT_TIMESTAMP'));
        });

        DB::table('admins')->insert([
            [
                'name' => "Viral Ghodadara",
                'email' => 'veerghodadara37@gmail.com',
                'email_verified_at' => date("Y-m-d H:i:s"),
                'password' => Hash::make('12345678')
            ],
            [
                'name' => "Ganesh Rode",
                'email' => 'ganeshrode3510@gmail.com',
                'email_verified_at' => date("Y-m-d H:i:s"),
                'password' => Hash::make('12345678')
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
