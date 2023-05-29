<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
            'tanggal' => $this->faker->date(),
            'user_id' => '01h1kntqv1bwmtbrc6ccmx7vcm',
            'kegiatan' => $this->faker->word(),
            'subkegiatan' => $this->faker->word(),
            'jenis_surat_id' => $this->faker->numberBetween(1,5),
            'no_surat' => $this->faker->bothify('?????#####'),
            'kka' => $this->faker->numberBetween(0, 4),
            'status' => $this->faker->numberBetween(0,5),
            'surat' => $this->faker->url()
        ];
    }
}
