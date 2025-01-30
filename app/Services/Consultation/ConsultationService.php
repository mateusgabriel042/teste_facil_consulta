<?php

namespace App\Services\Consultation;

use App\Contracts\Consultation\ConsultationRepository;
use App\Services\Core\BaseService;

class ConsultationService extends BaseService
{
    public function __construct(
        private readonly ConsultationRepository $consultationRepository,
    ) {
        parent::__construct($consultationRepository);
    }
}
