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
        Schema::create('things', function (Blueprint $table) {
            $table->id(); // id
            $table->string('name'); // name
            $table->text('description')->nullable(); // description
            $table->date('wrnt')->nullable(); // гарантия / срок годности
            $table->foreignId('master_id')
                    ->constrained('users')
                    ->cascadeOnDelete(); // хозяин вещи
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('things');
    }
};
