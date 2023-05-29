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
            'jenis' => 'Sertifikasi'
        ]);
        Pp::create([
            'jenis' => 'Diklat Penjenjangan'
        ]);
        Pp::create([
            'jenis' => 'Diklat Subtantif'
        ]);
        Pp::create([
            'jenis' => 'Pelatihan'
        ]);
        Pp::create([
            'jenis' => 'Workshop'
        ]);
        Pp::create([
            'jenis' => 'Seminar'
        ]);
        Pp::create([
            'jenis' => 'Pelatihan di Kantor Sendiri'
        ]);
    }
}
