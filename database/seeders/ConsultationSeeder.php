<?php

namespace Database\Seeders;

use App\Models\Consultation\Consultation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConsultationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Consultation::factory()->count(30)->create();
    }
}
