<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Thing;
use App\Models\Place;
use App\Models\Usage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Явные пользователи с понятными логинами/паролями (пароль у всех: "password")

            User::factory()->create([
                'name' => 'mireshka',
                'email' => 'lefward@yandex.ru',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
            ]);
            User::factory()->create([
                'name' => 'Bob',
                'email' => 'dashulamireshkina@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'user',
            ]);
            User::factory()->create([
                'name' => 'lala',
                'email' => 'lala@example.com',
                'password' => Hash::make('12345678'),
                'role' => 'user',
            ]);

        // Пара мест
        Place::factory(3)->create();

        // Несколько вещей, привязанных к этим пользователям

        // Пара записей использования
        Usage::factory(10)->create();
    }
}
