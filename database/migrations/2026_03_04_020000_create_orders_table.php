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
        Schema::create('orders', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->string('order_number')->unique();
            $blueprint->foreignId('theme_id')->constrained()->onDelete('cascade');
            $blueprint->foreignId('user_id')->constrained()->onDelete('cascade');
            $blueprint->integer('unique_code');
            $blueprint->bigInteger('total_amount');
            $blueprint->enum('status', ['pending', 'paid', 'expired'])->default('pending');
            $blueprint->timestamp('expired_at');
            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
