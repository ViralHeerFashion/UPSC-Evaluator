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
        Schema::create('recharge', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('amount');
            $table->string('order_id', 255);
            $table->string('razorpay_order_id', 255);
            $table->string('razorpay_payment_id', 255)->nullable();
            $table->string('razorpay_signature', 255)->nullable();
            $table->boolean('payment_status')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->onUpdate(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recharge');
    }
};
