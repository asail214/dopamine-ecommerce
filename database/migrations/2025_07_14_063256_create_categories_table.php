<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned()->nullable()->default(null);
            $table->integer('order')->default(1);
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('categories')->onUpdate('cascade')->onDelete('set null');
            $table->index(['is_active', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};