<?php

namespace Database\Factories;

use App\Models\Kullanici;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kullanici>
 */
class KullaniciFactory extends Factory
{
    protected $model = Kullanici::class;

    public function definition(): array
    {
        return [
            'roller_id' => '1',
            'ad' => 'pat',
        ];
    }
}
