<?php
// Helper function
use function Pest\Laravel\{actingAs};
use function Pest\Laravel\{get};



test('unauthenticated user cannot access the home page', function () {
    $user = \App\Models\User::factory()->create();
    $response = get('/pegawai/dashboard')->assertStatus(302);
    actingAs($user)->get('/pegawai/dashboard')->assertStatus(200);
});

test('authenticated user without admin rights cannot access the admin page', function () {
    $user = \App\Models\User::factory()->create();
    actingAs($user)->get('/admin')->assertStatus(302);
});

test('authenticated user without sekretaris rights cannot access the sekretaris page', function () {
    $user = \App\Models\User::factory()->create();
    actingAs($user)->get('/sekretaris')->assertStatus(302);
});

test('authenticated user without inspektur rights  cannot access the inspektur page', function () {
    $user = \App\Models\User::factory()->create();
    actingAs($user)->get('/inspektur')->assertStatus(302);
});

test('authenticated user without analis-sdm rights  cannot access the analis-sdm page', function () {
    $user = \App\Models\User::factory()->create();
    actingAs($user)->get('/analis-sdm')->assertStatus(302);
});

test('authenticated user without perencana rights cannot access the perencana page', function () {
    $user = \App\Models\User::factory()->create();
    actingAs($user)->get('/perencana')->assertStatus(302);
});

test('authenticated user without arsiparis rights cannot access the admin page', function () {
    $user = \App\Models\User::factory()->create();
    actingAs($user)->get('/arsiparis')->assertStatus(302);
});




test('authenticated user can access the home page', function () {
    $user = \App\Models\User::factory()->create();
    actingAs($user)->get('/pegawai/dashboard')->assertStatus(200);
});

test('authenticated user with admin rights can access the admin page', function () {
    $user = \App\Models\User::factory()->create();
    $user->is_admin = true;
    actingAs($user)->get('/admin')->assertStatus(200);
});

test('authenticated user with sekretaris wilayah rights can access the sekretaris page', function () {
    $user = \App\Models\User::factory()->create();
    $user->is_sekwil = true;
    actingAs($user)->get('/sekretaris')->assertStatus(200);
});

test('authenticated user with sekretaris utama rights can access the sekretaris page', function () {
    $user = \App\Models\User::factory()->create();
    $user->is_sekma = true;
    actingAs($user)->get('/sekretaris')->assertStatus(200);
});

test('authenticated user with inspektur rights can access the inspektur page', function () {
    $user = \App\Models\User::factory()->create();
    $user->is_aktif = true;
    actingAs($user)->get('/inspektur')->assertStatus(200);
});

test('authenticated user with analis-sdm rights can access the analis-sdm page', function () {
    $user = \App\Models\User::factory()->create();
    $user->is_analissdm = true;
    actingAs($user)->get('/analis-sdm')->assertStatus(200);
});

test('authenticated user with perencana rights can access the perencana page', function () {
    $user = \App\Models\User::factory()->create();
    $user->is_perencana = true;
    actingAs($user)->get('/perencana')->assertStatus(200);
});

test('authenticated user with arsiparis rights can access the arsiparis page', function () {
    $user = \App\Models\User::factory()->create();
    $user->is_arsiparis = true;
    actingAs($user)->get('/arsiparis')->assertStatus(200);
});

