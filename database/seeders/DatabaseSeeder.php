<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Spesialisasi;
use App\Models\User;
use App\Models\Vet;
use App\Models\VetDate;
use App\Models\VetTime;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
     // Buat 10 vet lengkap dengan vetDate dan vetTime
        Vet::factory(10)
            ->has(
                VetDate::factory()
                    ->count(3)
                    ->has(VetTime::factory()->count(4), 'vetTimes'),
                'vetDates'
            )
            ->create();

        // Buat 5 spesialisasi
        Spesialisasi::factory()->count(5)->create();

        // Buat user admin
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@vetconnect.com',
            'password' => bcrypt('gugun123'),
            'is_admin' => true,
        ]);

        // Buat user biasa
        User::create([
            'name' => 'gunawan',
            'email' => 'gugun@gmail.com',
            'password' => Hash::make('password'),
            'alamat' => 'Jl. Contoh No. 123',
            'no_telp' => '08123456789',
            'umur' => 30,
            'is_admin' => false,
        ]);

        // Buat 20 artikel
        Article::factory()->count(5)->create();
    }
}
