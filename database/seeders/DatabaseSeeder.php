<?php

namespace Database\Seeders;

use App\Models\MasterAnggaran;
use App\Models\MasterPimpinan;
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

        User::factory(25)->create();
        MasterPimpinan::factory(4)->create();

        User::create([
            'email'     => '221911003@stis.ac.id',
            'nip'       => '221911003',
            'name'      => 'Gestyan Ramadhan',
            'pangkat'   => 'IV/a',
            'is_admin'  => 1
        ]);

        User::create([
            'email'     => '221910858@stis.ac.id',
            'nip'       => '221910858',
            'name'      => 'Muhamad Arya Fitra',
            'pangkat'   => 'IV/a',
            'unit_kerja' => '8000',
            'is_admin'  => 1,
            'is_aktif' => 1,
            'is_sekma' => 1,
            'is_analissdm' => 1
        ]);

        $this->call([
            PpSeeder::class,
            NamaPpSeeder::class,
            KkaSeeder::class,
            PembebananSeeder::class,
            // StKinerjaSeeder::class,
            StpSeeder::class,
            SlSeeder::class,
            // KirimSeeder::class,
            // StpdSeeder::class,
            // EksternalSeeder::class
        ]);

        MasterAnggaran::create([
            'program'       => '054.01.WA Program Dukungan Manajemen dan Pelaksanaan Tugas Teknis Lainnya BPS',
            'id_kegiatan'   => '4203',
            'kegiatan'      => 'Pengawasan dan Peningkatan Akuntabilitas Inspektorat I'
        ]);
        MasterAnggaran::create([
            'program'       => '054.01.WA Program Dukungan Manajemen dan Pelaksanaan Tugas Teknis Lainnya BPS',
            'id_kegiatan'   => '4204',
            'kegiatan'      => 'Pengawasan dan Peningkatan Akuntabilitas Inspektorat II'
        ]);
        MasterAnggaran::create([
            'program'       => '054.01.WA Program Dukungan Manajemen dan Pelaksanaan Tugas Teknis Lainnya BPS',
            'id_kegiatan'   => '4205',
            'kegiatan'      => 'Pengawasan dan Peningkatan Akuntabilitas Inspektorat III'
        ]);
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
