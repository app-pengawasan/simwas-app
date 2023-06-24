<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Eksternal>
 */
class EksternalFactory extends Factory
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
            'pengirim' => $this->faker->numberBetween(0,2),
            'tanggal_ekspedisi' => $this->faker->date(),
            'penerima_ekspedisi' => $this->faker->name(),
            'tanggal_dok' => $this->faker->date(),
            'penerima_dok' => $this->faker->name(),
            'asal' => $this->faker->word(),
            'no_surat' => $this->faker->bothify('?????#####'),
            'tanggal_surat' => $this->faker->date(),
            'perihal' => $this->faker->sentence(),
            'jumlah_hal' => $this->faker->numberBetween(1,4),
            'is_tembusan' => $this->faker->boolean(),
            'is_disposisi' => $this->faker->boolean(),
            'tanggal_dispo' => $this->faker->date(),
            'file' => $this->faker->url(),
            'kepada' => $this->faker->numberBetween(0,3),
            'status' => $this->faker->numberBetween(0,2)
        ];
    }
}
