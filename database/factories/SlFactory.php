<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sl>
 */
class SlFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'is_backdate' => false,
            'tanggal' => $this->faker->date(),
            'user_id' => User::pluck('id')->random(),
            'jenis_surat' => $this->faker->randomElement(['Surat Dinas', 'Nota Dinas', 'Surat Undangan']),
            'derajat_klasifikasi' => $this->faker->randomElement(['SR', 'R', 'T', 'B']),
            'kka_id' => $this->faker->numberBetween(1, 3),
            'unit_kerja' => $this->faker->randomElement(['8000', '8010', '8100', '8200', '8300']),
            'hal' => $this->faker->sentence(3),
            'draft' => $this->faker->url(),
            'no_surat' => $this->faker->bothify('?????#####'),
            'status' => $this->faker->numberBetween(0,5),
            'surat' => $this->faker->url()
        ];
    }
}
