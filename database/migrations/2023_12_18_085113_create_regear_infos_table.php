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
        Schema::create('regear_infos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('death_id')->default(0);
            $table->string('equipment');
            $table->tinyInteger('allowed_gears')->default(0);
            $table->tinyInteger('is_oc')->default(0);
            $table->tinyInteger('is_scout')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regear_infos');
    }
};
