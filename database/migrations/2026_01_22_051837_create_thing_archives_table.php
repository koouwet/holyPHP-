<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('thing_archives', function (Blueprint $table) {
            $table->id();

            // данные вещи
            $table->string('name');
            $table->text('description')->nullable();

            // имена, а не связи
            $table->string('owner_name');
            $table->string('last_user_name')->nullable();
            $table->string('place_name')->nullable();

            // восстановлена или нет
            $table->boolean('restored')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('thing_archives');
    }
};
