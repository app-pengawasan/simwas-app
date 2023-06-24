<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pp;

class PpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pp::create([
            'jenis' => 'Sertifikasi',
            'is_aktif' => true
        ]);
        Pp::create([
            'jenis' => 'Diklat Penjenjangan',
            'is_aktif' => true
        ]);
        Pp::create([
            'jenis' => 'Diklat Subtantif',
            'is_aktif' => true
        ]);
        Pp::create([
            'jenis' => 'Pelatihan',
            'is_aktif' => true
        ]);
        Pp::create([
            'jenis' => 'Workshop',
            'is_aktif' => true
        ]);
        Pp::create([
            'jenis' => 'Seminar',
            'is_aktif' => true
        ]);
        Pp::create([
            'jenis' => 'Pelatihan di Kantor Sendiri',
            'is_aktif' => true
        ]);
    }
}
