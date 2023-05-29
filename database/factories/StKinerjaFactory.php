<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'tanggal' => $this->faker->date(),
            'rencana_id' => $this->faker->bothify('####?'),
            'melaksanakan' => $this->faker->sentence(),
            'objek' => $this->faker->randomElement(['Temanggung', 'Semarang', 'DKI Jakarta', 'Palembang']),
            'mulai' => $this->faker->dateTimeBetween('-2 month', '-1 month')->format('Y-m-d'),
            'selesai' => $this->faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
            'penandatangan' => $this->faker->numberBetween(0, 4),
            'status' => mt_rand(0,3),
            'no_st' => $this->faker->bothify('?????#####'),
            'is_esign' => $this->faker->boolean()
        ];
    }
}
