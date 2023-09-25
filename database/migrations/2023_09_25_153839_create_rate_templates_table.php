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
        Schema::create('rate_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id');
            $table->foreignId('user_id');
            $table->text('comment')->nullable();
            $table->decimal('rating', 4, 2);
            $table->enum('rate_status',['show','hide'])->nullable();
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rate_templates');
    }
};
