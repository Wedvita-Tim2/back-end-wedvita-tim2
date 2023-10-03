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
        Schema::table('rate_templates', function (Blueprint $table){
            $table->foreignId('user_id')->change()->constrained()->cascadeOnDelete();
            $table->foreignId('template_id')->change()->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rate_templates', function (Blueprint $table) {
            $table->dropForeign('rate_templates_user_id_foreign');
            $table->dropForeign('rate_templates_template_id_foreign');
        });
    }
};
