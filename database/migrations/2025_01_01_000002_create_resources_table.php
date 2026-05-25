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
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('title', 255);
            $table->string('slug', 280)->unique();
            $table->text('description');
            $table->string('type', 10)->default('share'); // 'share' or 'request'
            $table->string('status', 10)->default('active'); // 'active', 'paused', 'closed'
            $table->string('location', 255)->nullable();
            $table->string('contact_email', 255)->nullable();
            $table->string('cover_image', 500)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'status']);
            $table->index('category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
