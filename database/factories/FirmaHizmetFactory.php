<?php

namespace Database\Factories;

use App\Models\FirmaHizmet;
use Illuminate\Database\Eloquent\Factories\Factory;

class FirmaHizmetFactory extends Factory
{

    protected $model = FirmaHizmet::class;

    public function definition(): array
    {
        return [
            'hizmet_turleri_id' => $this->faker->randomDigit(),
            'firmalar_id' => $this->faker->randomDigit(),
            'aciklama' => $this->faker->paragraph(),
        ];
    }
}
