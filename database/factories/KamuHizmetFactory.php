<?php

namespace Database\Factories;

use App\Models\KamuHizmet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KamuHizmet>
 */
class KamuHizmetFactory extends Factory
{
    protected $model = KamuHizmet::class;

    public function definition(): array
    {
        return [
            'hizmet_turleri_id' => $this->faker->randomDigit(),
            'kamular_id' => $this->faker->randomDigit(),
            'islem_yapan_id' => $this->faker->randomDigit(),
            'aciklama' => $this->faker->paragraph(),
        ];
    }
}
