<?php

namespace App\Services\Patient;

use App\Contracts\Patient\PatientRepository;
use App\Services\Core\BaseService;

class PatientService extends BaseService
{
    public function __construct(
        private readonly PatientRepository $patientRepository,
    ) {
        parent::__construct($patientRepository);
    }

}
