<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kirim>
 */
class KirimFactory extends Factory
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
            'no_surat' => $this->faker->bothify('?????#####'),
            'user_id' => User::pluck('id')->random(),
            'email_tujuan' => $this->faker->email(),
            'pesan' => $this->faker->sentence()
        ];
    }
}
