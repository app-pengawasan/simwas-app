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
            'email'     => '222011617@stis.ac.id',
            'nip'       => '222011617',
            'name'      => 'Rarisza Nabila',
            'pangkat'   => 'IV/a',
            'unit_kerja' => '8100',
            'jabatan'   => 11,
            'is_admin'  => 1,
            'is_aktif' => 1,
            'is_sekma' => 1,
            'is_analissdm' => 1,
            'is_sekwil' => 1,
            'is_perencana' => 1,
            'is_apkapbn' => 1,
            'is_opwil' => 1,
        ]);

        User::create([
            'email'     => '222011395@stis.ac.id',
            'nip'       => '222011395',
            'name'      => 'Hendra Kusuma',
            'pangkat'   => 'IV/a',
            'unit_kerja' => '8200',
            'jabatan'   => 12,
            'is_admin'  => 1,
            'is_aktif' => 1,
            'is_sekma' => 1,
            'is_analissdm' => 1,
            'is_sekwil' => 1,
            'is_perencana' => 1,
            'is_apkapbn' => 1,
            'is_opwil' => 1,
        ]);

        User::create([
            'email'     => 'vony.bps4@gmail.com',
            'nip'       => '123456789',
            'name'      => 'Vony Wahyunurani',
            'pangkat'   => 'IV/a',
            'unit_kerja' => '8010',
            'jabatan'   => 14,
            'is_admin'  => 1,
            'is_aktif' => 1,
            'is_sekma' => 1,
            'is_analissdm' => 1,
            'is_sekwil' => 1,
            'is_perencana' => 1,
            'is_apkapbn' => 1,
            'is_opwil' => 1,
        ]);

        User::create([
            'email'     => 'putuhadi2808@gmail.com',
            'nip'       => '987654321',
            'name'      => 'Putu Hadi Purnama Jati',
            'pangkat'   => 'IV/a',
            'unit_kerja' => '8300',
            'jabatan'   => 13,
            'is_admin'  => 1,
            'is_aktif' => 1,
            'is_sekma' => 1,
            'is_analissdm' => 1,
            'is_sekwil' => 1,
            'is_perencana' => 1,
            'is_apkapbn' => 1,
            'is_opwil' => 1,
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
