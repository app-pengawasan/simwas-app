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
        
        $this->call([
            PpSeeder::class,
            NamaPpSeeder::class,
            KkaSeeder::class,
            StKinerjaSeeder::class,
            StpSeeder::class,
            SlSeeder::class,
            // KirimSeeder::class,
            // StpdSeeder::class,
            // EksternalSeeder::class
        ]);

        User::create([
            'email'     => '221911003@stis.ac.id',
            'nip'       => '221911003',
            'name'      => 'Gestyan Ramadhan',
            'pangkat'   => 'IV/a',
            'is_admin'  => 1
        ]);

        MasterAnggaran::create([
            'program'       => '054.01.WA Program Dukungan Manajemen dan Pelaksanaan Tugas Teknis Lainnya BPS',
            'id_kegiatan'   => '4203',
            'kegiatan'      => '4203 Pengawasan dan Peningkatan Akuntabilitas Inspektorat I'
        ]);
        MasterAnggaran::create([
            'program'       => '054.01.WA Program Dukungan Manajemen dan Pelaksanaan Tugas Teknis Lainnya BPS',
            'id_kegiatan'   => '4204',
            'kegiatan'      => '4204 Pengawasan dan Peningkatan Akuntabilitas Inspektorat II'
        ]);
        MasterAnggaran::create([
            'program'       => '054.01.WA Program Dukungan Manajemen dan Pelaksanaan Tugas Teknis Lainnya BPS',
            'id_kegiatan'   => '4205',
            'kegiatan'      => '4205 Pengawasan dan Peningkatan Akuntabilitas Inspektorat III'
        ]);
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
