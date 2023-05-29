<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(25)->create();
        User::create([
            'id' => '01h1eqba5kj32kksa221910876',
            'name' => 'arya',
            'email' => 'arya@yahoo.com',
            'nip' => '197739384221910843',
            'pangkat' => 'IVa',
            'unit_kerja' => '0081',
            'jabatan' => '002',
            'email_verified_at' => '2023-05-27 13:46:11',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => 'IH33ijy9NR',
        ]);
    }
}
