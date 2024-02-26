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
        Schema::create('battle_infos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('battle_id');

            $table->string('killer_character_id');
            $table->string('killer_name');
            $table->string('killer_equipment');
            $table->string('killer_guild');
            $table->string('killer_guild_id');

            $table->string('victim_character_id');
            $table->string('victim_name');
            $table->string('victim_equipment');
            $table->string('victim_guild');
            $table->string('victim_guild_id');

            $table->string('kill_fame');
            $table->string('timestamp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('battle_infos');
    }
};
