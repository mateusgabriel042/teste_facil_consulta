<?php

namespace App\Providers;

use App\Contracts\Consultation\ConsultationRepository;
use App\Contracts\Doctor\DoctorRepository;
use App\Contracts\Location\CityRepository;
use App\Contracts\Patient\PatientRepository;
use App\Repositories\Consultation\ConsultationRepositoryEloquent;
use App\Repositories\Doctor\DoctorRepositoryEloquent;
use App\Repositories\Location\CityRepositoryEloquent;
use App\Repositories\Patient\PatientRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(CityRepository::class, CityRepositoryEloquent::class);
        $this->app->bind(DoctorRepository::class, DoctorRepositoryEloquent::class);
        $this->app->bind(PatientRepository::class, PatientRepositoryEloquent::class);
        $this->app->bind(ConsultationRepository::class, ConsultationRepositoryEloquent::class);
    }
}
