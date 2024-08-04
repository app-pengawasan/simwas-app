<?php
use function Pest\Laravel\{actingAs};
use function Pest\Laravel\{get};


test('can retrieve master pegawai list', function () {
    $user = \App\Models\User::factory()->create();
    $user->is_admin = true;
    actingAs($user)->get('/admin/master-pegawai')
        ->assertStatus(200);
});

test('can create pegawai', function () {
    $user = \App\Models\User::factory()->create();
    $user->is_admin = true;
    actingAs($user)->post('/admin/master-pegawai', [
            'name'          => 'John Doe',
            'email'         => 'john@mail.com',
            'nip'           => '12341234234',
            'pangkat'       => 'IV/e',
            'unit_kerja'    => '8010',
            'jabatan'       => '10',
            'is_admin'      => 0,
            'is_sekma'      => 0,
            'is_sekwil'     => 0,
            'is_perencana'  => 0,
            'is_apkapbn'    => 0,
            'is_opwil'      => 0,
            'is_analissdm'  => 0,
            'is_arsiparis'  => 0,
            'is_aktif'      => 0,
            'is_irwil'      => 0,
    ])->assertStatus(302);
});

test('can view detail pegawai', function() {
    $user = \App\Models\User::factory()->create();
    $user->is_admin = true;
    $pegawai = \App\Models\User::factory()->create();
    actingAs($user)->get('/admin/master-pegawai/' . $pegawai->id)
        ->assertStatus(200);
});


test('can delete pegawai', function() {
    $user = \App\Models\User::factory()->create();
    $user->is_admin = true;
    $pegawai = \App\Models\User::factory()->create();
    actingAs($user)->delete('/admin/master-pegawai/' . $pegawai->id)
        ->assertStatus(200);
});


test('can update pegawai', function() {
    $user = \App\Models\User::factory()->create();
    $user->is_admin = true;
    $pegawai = \App\Models\User::factory()->create();
    actingAs($user)->put('/admin/master-pegawai/' . $pegawai->id, [
        'name'          => 'Nama Testing',
        'email'         => 'testemail@mail.com',
        'nip'           => '0000000000',
    ])->assertre
});


