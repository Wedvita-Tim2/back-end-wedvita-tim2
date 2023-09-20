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
        Schema::table('orders', function (Blueprint $table){
            $table->foreignId('user_id')->change()->constrained()->onDelete('cascade');
            $table->foreignId('template_id')->change()->constrained()->onDelete('cascade');$table->foreignId('event_information_id')->change()->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_user_id_foreign');
            $table->dropForeign('orders_template_id_foreign');
            $table->dropForeign('orders_event_information_id_foreign');
        });
    }
};
