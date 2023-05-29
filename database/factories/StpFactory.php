<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stp>
 */
class StpFactory extends Factory
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
            'user_id' => '01h1kvh107kbektkxdyx9hbhgz',
            'pp_id' => $this->faker->numberBetween(1, 7),
            'nama_pp' => $this->faker->word(),
            'melaksanakan' => $this->faker->sentence(),
            'mulai' => $this->faker->dateTimeBetween('-2 month', '-1 month')->format('Y-m-d'),
            'selesai' => $this->faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
            'penandatangan' => $this->faker->numberBetween(0, 4),
            'status' => mt_rand(0,5),
            'no_st' => $this->faker->bothify('?????#####'),
            'tanggal_sertifikat' => $this->faker->date(),
            'is_esign' => $this->faker->boolean()
        ];
    }
}
