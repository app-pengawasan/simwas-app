<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisSurat;

class JenisSuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JenisSurat::create([
            'nama' => 'Surat Undangan',
            'file' => 'http://www.sample.org/head'
        ]);
        JenisSurat::create([
            'nama' => 'Surat A',
            'file' => 'http://www.sample.org/head'
        ]);
        JenisSurat::create([
            'nama' => 'Surat B',
            'file' => 'http://www.sample.org/head'
        ]);
        JenisSurat::create([
            'nama' => 'Surat C',
            'file' => 'http://www.sample.org/head'
        ]);
        JenisSurat::create([
            'nama' => 'Surat D',
            'file' => 'http://www.sample.org/head'
        ]);
    }
}
