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
        if (!Schema::hasTable('category_product')) {
            Schema::create('category_product', function (Blueprint $table) {
                $table->id(); // This will be bigint unsigned
                
                // Match the exact data types from your existing tables
                $table->unsignedInteger('category_id');  // integer to match categories.id
                $table->unsignedBigInteger('product_id'); // bigint to match products.id
                
                $table->timestamps();

                // Add indexes for performance
                $table->index(['category_id']);
                $table->index(['product_id']);
                
                // Ensure unique combinations
                $table->unique(['category_id', 'product_id']);

                // Add foreign key constraints with correct data types
                $table->foreign('category_id')
                      ->references('id')
                      ->on('categories')
                      ->onDelete('cascade');
                      
                $table->foreign('product_id')
                      ->references('id')
                      ->on('products')
                      ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_product');
    }
};