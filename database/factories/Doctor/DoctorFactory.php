<?php

namespace Database\Factories\Doctor;

use App\Models\Location\City;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor\Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->name,
            'especialidade' => $this->faker->randomElement(['cardiologia', 'ortopedia', 'pediatria', 'dermatologia']),
            'cidade_id' => City::factory(),
        ];
    }
}
