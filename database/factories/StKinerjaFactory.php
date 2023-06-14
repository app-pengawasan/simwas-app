<?php

namespace Database\Factories;

use App\Models\MasterPimpinan;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StKinerja>
 */
class StKinerjaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $users = User::pluck('id')->toArray();
        $master = MasterPimpinan::pluck('id')->toArray();
        return [
            'tanggal' => $this->faker->date(),
            'user_id' => $this->faker->randomElement($users),
            'unit_kerja' => $this->faker->randomElement(['8000', '8010', '8100', '8200', '8300']),
            'tim_kerja' => $this->faker->randomNumber(1,5),
            'tugas' => $this->faker->randomNumber(1,7),
            'melaksanakan' => $this->faker->sentence(),
            'objek' => $this->faker->randomElement(['Temanggung', 'Semarang', 'DKI Jakarta', 'Palembang']),
            'mulai' => $this->faker->dateTimeBetween('-2 month', '-1 month')->format('Y-m-d'),
            'selesai' => $this->faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
            'is_gugus_tugas' => $this->faker->boolean(),
            'is_perseorangan' => $this->faker->boolean(),
            'dalnis_id' => $this->faker->randomElement($users),
            'ketua_koor_id' => $this->faker->randomElement($users),
            'anggota' => implode(', ', $this->faker->randomElements($users, $this->faker->numberBetween(1, 5))),
            'penandatangan' => $this->faker->numberBetween(0, 4),
            'status' => mt_rand(0,8),
            'no_surat' => $this->faker->bothify('?????#####'),
            'file' => $this->faker->url(),
            'is_esign' => $this->faker->boolean(),
            'is_backdate' => $this->faker->boolean(),
            'catatan' => $this->faker->sentence()
        ];
    }
}
