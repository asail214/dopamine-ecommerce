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
        Schema::table('categories', function (Blueprint $table) {
            if (Schema::hasColumn('categories', 'order') && !Schema::hasColumn('categories', 'sort_order')) {
                $table->renameColumn('order', 'sort_order');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    { 
        Schema::table('categories', function (Blueprint $table) {
            // Revert back to 'order' if needed
            if (Schema::hasColumn('categories', 'sort_order') && !Schema::hasColumn('categories', 'order')) {
                $table->renameColumn('sort_order', 'order');
            }
        });
    }
};