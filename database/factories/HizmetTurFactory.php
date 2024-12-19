<?php

namespace Database\Factories;

use App\Models\HizmetTur;
use Illuminate\Database\Eloquent\Factories\Factory;

class HizmetTurFactory extends Factory
{
    protected $model = HizmetTur::class;

    public function definition(): array
    {
        return [
            'baslik' => $this->faker->jobTitle(),
        ];
    }
}
