<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pp;
use App\Models\NamaPp;
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
            // UserSeeder::class,
            // PpSeeder::class,
            // NamaPpSeeder::class,
            // KkaSeeder::class,
            // StKinerjaSeeder::class,
            StpSeeder::class,
            SlSeeder::class,
            // KirimSeeder::class,
            // StpdSeeder::class,
            // EksternalSeeder::class
        ]);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
