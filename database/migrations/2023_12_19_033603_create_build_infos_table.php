<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *         'id',
        'role_id',
        'equipment',
        'consumables',
        'notes',
     */
    public function up(): void
    {
        Schema::create('build_infos', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('role_id');
            $table->string('equipment');
            $table->string('consumables')->nullable();
            $table->string('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('build_infos');
    }
};
