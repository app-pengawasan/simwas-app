<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kka;

class KkaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kka::create([
            'kode' => 'PW.110',
            'is_aktif' => true
        ]);
        Kka::create([
            'kode' => 'PW.120',
            'is_aktif' => true
        ]);
        Kka::create([
            'kode' => 'KP.310',
            'is_aktif' => true
        ]);
    }
}
