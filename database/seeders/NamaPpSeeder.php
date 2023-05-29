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
            'nama' => 'CISA'
        ]);
        NamaPp::create([
            'pp_id' => 1,
            'nama' => 'CRMP'
        ]);
        NamaPp::create([
            'pp_id' => 1,
            'nama' => 'QIA'
        ]);
        NamaPp::create([
            'pp_id' => 2,
            'nama' => 'Diklat Auditor Ahli Pertama'
        ]);
        NamaPp::create([
            'pp_id' => 3,
            'nama' => 'Audit Investigasi'
        ]);
    }
}
