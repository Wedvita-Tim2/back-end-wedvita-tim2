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
        Schema::create('event_informations', function (Blueprint $table) {
            $table->id();
            $table->string('bride_name');
            $table->string('groom_name');
            $table->string('bride_mother_name');
            $table->string('bride_father_name');
            $table->string('groom_mother_name');
            $table->string('groom_father_name');
            $table->string('cover_image');
            $table->date('date_event');
            $table->string('guests');
            $table->string('account_number');
            $table->string('account_holder_name');
            $table->string('quotes')->nullable();
            $table->text('address');
            $table->string('building_name');
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('maps_url')->nullable();
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_informations');
    }
};
