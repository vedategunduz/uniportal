<?php

namespace Database\Factories;

use App\Models\HizmetIlDetaylari;
use Illuminate\Database\Eloquent\Factories\Factory;

class HizmetIlDetaylariFactory extends Factory
{
    protected $model = HizmetIlDetaylari::class;

    public function definition(): array
    {
        return [
            'firma_hizmetleri_id' => $this->faker->randomDigit(),
            'iller_id' => $this->faker->numberBetween(0, 80),
        ];
    }
}
