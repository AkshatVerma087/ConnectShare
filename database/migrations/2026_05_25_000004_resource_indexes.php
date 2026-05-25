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
        Schema::table('resources', function (Blueprint $table) {
            $table->index(['user_id', 'category_id'], 'resources_user_category_index');
            $table->index(['user_id', 'updated_at'], 'resources_user_updated_at_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resources', function (Blueprint $table) {
            $table->dropIndex('resources_user_category_index');
            $table->dropIndex('resources_user_updated_at_index');
        });
    }
};
