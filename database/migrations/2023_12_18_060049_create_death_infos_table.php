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
        Schema::create('death_infos', function (Blueprint $table) {
            $table->id();
            $table->string('character_id');
            $table->bigInteger('battle_id');
            $table->string('name');
            $table->string('guild');
            $table->string('equipment');
            $table->string('killer_name');
            $table->string('killer_equipment');
            $table->string('killer_guild');
            $table->string('death_fame');
            $table->string('timestamp');
            $table->double('regear_cost');
            $table->tinyInteger('is_oc')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->bigInteger('regeared_by')->default(0);
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('death_infos');
    }
};
