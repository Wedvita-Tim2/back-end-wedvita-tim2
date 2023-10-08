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
        Schema::table('wedding_wishes', function (Blueprint $table){
            $table->foreignId('event_information_id')->change()->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wedding_wishes', function (Blueprint $table) {
            $table->dropForeign('wedding_wishes_event_information_id_foreign');
        });
    }
};
