<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('type', ['fixed', 'percentage']); // fixed amount or percentage
            $table->decimal('value', 10, 2); // discount amount or percentage
            $table->decimal('minimum_amount', 10, 2)->nullable(); // minimum order amount
            $table->decimal('maximum_amount', 10, 2)->nullable(); // maximum discount amount
            $table->integer('usage_limit')->nullable(); // total usage limit
            $table->integer('usage_limit_per_user')->nullable(); // per user usage limit
            $table->integer('used_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->datetime('starts_at');
            $table->datetime('expires_at');
            $table->json('applicable_categories')->nullable(); // category IDs
            $table->json('applicable_products')->nullable(); // product IDs
            $table->timestamps();

            $table->index(['code', 'is_active']);
            $table->index(['is_active', 'starts_at', 'expires_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};