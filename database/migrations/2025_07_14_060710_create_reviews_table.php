<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('set null');
            $table->integer('rating')->unsigned(); // 1-5 stars
            $table->string('title')->nullable();
            $table->text('comment')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_verified_purchase')->default(false);
            $table->json('helpful_votes')->nullable(); // Store user IDs who found helpful
            $table->timestamps();

            $table->unique(['product_id', 'user_id', 'order_id']);
            $table->index(['product_id', 'is_approved']);
            $table->index(['user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};