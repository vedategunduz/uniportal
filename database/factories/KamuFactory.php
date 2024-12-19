<?php

namespace Database\Factories;

use App\Models\Kamu;
use Illuminate\Database\Eloquent\Factories\Factory;

class KamuFactory extends Factory
{
    protected $model = Kamu::class;

    public function definition(): array
    {
        return [
            'referans_uuid' => $this->faker->uuid(),
            'baslik' => $this->faker->company,
        ];
    }
}
