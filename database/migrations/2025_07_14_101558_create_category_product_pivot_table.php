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
        // Only create if both parent tables exist and pivot table doesn't exist
        if (Schema::hasTable('categories') && Schema::hasTable('products') && !Schema::hasTable('category_product')) {
            Schema::create('category_product', function (Blueprint $table) {
                $table->id();
                
                // Match the exact data types from existing tables
                $table->unsignedInteger('category_id');  // categories uses increments() = unsigned int
                $table->unsignedBigInteger('product_id'); // products uses id() = unsigned bigint
                
                $table->timestamps();

                // Add indexes for performance
                $table->index(['category_id']);
                $table->index(['product_id']);
                
                // Ensure unique combinations
                $table->unique(['category_id', 'product_id']);

                // Add foreign key constraints ONLY if the tables exist
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