<?php

namespace Database\Factories\Consultation;

use App\Models\Doctor\Doctor;
use App\Models\Patient\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Consultation\Consultation>
 */
class ConsultationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'data' => $this->faker->date(),
            'medico_id' => Doctor::factory(),
            'paciente_id' => Patient::factory(),
        ];
    }
}
