<?php

namespace Database\Factories;

use App\Models\Firma;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class FirmaFactory extends Factory
{
    protected $model = Firma::class;

    public function definition(): array
    {
        return [
            'baslik' => $this->faker->company(),
            'email' => $this->faker->companyEmail(),
            'telefon' => $this->faker->phoneNumber(),
            'adres' => $this->faker->address(),
            'website' => $this->faker->url(),
        ];
    }
}
