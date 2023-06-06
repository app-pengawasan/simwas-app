<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MasterPimpinan>
 */
class MasterPimpinanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = DB::table('users')->limit(10)->get();
        $randnum = random_int(0,9);

        return [
            'id_user'   => $user[$randnum]->id,
            'jabatan'   => fake()->randomElement(['jpm000', 'jpm001', 'jpm002', 'jpm003']),
            'mulai'     => fake()->dateTimeThisYear(),
            'selesai'     => fake()->dateTimeThisYear('+10 months'),
        ];
    }
}
