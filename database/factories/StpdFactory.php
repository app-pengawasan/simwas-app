<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stpd>
 */
class StpdFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'tanggal' => $this->faker->date(),
            'unit_kerja' => $this->faker->numberBetween(0,4),
            'melaksanakan' => $this->faker->sentence(),
            'kota' => $this->faker->randomElement(['Temanggung', 'Semarang', 'Palembang', 'Malang']),
            'mulai' => $this->faker->dateTimeBetween('-2 month', '-1 month')->format('Y-m-d'),
            'selesai' => $this->faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
            'pelaksana' => $this->faker->name(),
            'no_st' => $this->faker->bothify('?????#####'),
            'st_kinerja_id' => $this->faker->numberBetween(1,20),
            'pembebanan' => $this->faker->word(),
            'laporan' => $this->faker->numberBetween(0,3),
            'tanggal_laporan' => $this->faker->date(),
            'penandatangan' => $this->faker->numberBetween(0, 4),
            'status' => mt_rand(0,3),
            'is_esign' => $this->faker->boolean()
        ];
    }
}
