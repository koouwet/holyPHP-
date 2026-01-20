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
        Schema::create('places', function (Blueprint $table) {
            $table->id(); // id места
            $table->string('name'); // название места
            $table->text('description')->nullable(); // описание
            $table->boolean('repair')->default(false); // спец. место (ремонт / мойка)
            $table->boolean('work')->default(false); // находится в работе
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('places');
    }
};
