<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pp;
use App\Models\NamaPp;
use App\Models\JenisSurat;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            PpSeeder::class,
            NamaPpSeeder::class,
            JenisSuratSeeder::class,
            // StKinerjaSeeder::class,
            // StpSeeder::class,
            // SlSeeder::class,
            // StpdSeeder::class,
            // KirimSeeder::class,
            // EksternalSeeder::class
        ]);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
