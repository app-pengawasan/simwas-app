<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NamaPp;

class NamaPpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NamaPp::create([
            'pp_id' => 1,
            'nama' => 'CISA',
            'is_aktif' => true
        ]);
        NamaPp::create([
            'pp_id' => 1,
            'nama' => 'CRMP',
            'is_aktif' => true
        ]);
        NamaPp::create([
            'pp_id' => 1,
            'nama' => 'QIA',
            'is_aktif' => true
        ]);
        NamaPp::create([
            'pp_id' => 2,
            'nama' => 'Diklat Auditor Ahli Pertama',
            'is_aktif' => true
        ]);
        NamaPp::create([
            'pp_id' => 3,
            'peserta' => 100,
            'nama' => 'Diklat Penyusunan Kertas Kerja Audit',
            'is_aktif' => true
        ]);
        NamaPp::create([
            'pp_id' => 3,
            'peserta' => 200,
            'nama' => 'Diklat Penyusunan Laporan Hasil Audit',
            'is_aktif' => true
        ]);
        NamaPp::create([
            'pp_id' => 3,
            'peserta' => 300,
            'nama' => 'Diklat Manajemen Pengawasan',
            'is_aktif' => true
        ]);
        NamaPp::create([
            'pp_id' => 3,
            'peserta' => 400,
            'nama' => 'Audit TIK',
            'is_aktif' => true
        ]);
        NamaPp::create([
            'id' => 999,
            'pp_id' => NULL,
            'nama' => 'Lainnya',
            'is_aktif' => 2
        ]);
    }
}
