<?php

namespace App\Services\Doctor;

use App\Contracts\Doctor\DoctorRepository;
use App\Contracts\Consultation\ConsultationRepository;
use App\Contracts\Patient\PatientRepository;
use App\Services\Core\BaseService;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class DoctorService extends BaseService
{
    public function __construct(
        private readonly DoctorRepository $doctorRepository,
        private readonly ConsultationRepository $consultationRepository,
        private readonly PatientRepository $patientRepository,
    ) {
        parent::__construct($doctorRepository);
    }

    /**
     * Get a paginated list of items.
     *
     * @param Request $request
     * @param array $relations
     * @return LengthAwarePaginator
     */
    public function getList($request, $relations = []): LengthAwarePaginator
    {
        $dataRequest = $request->query();
        $items = $this->doctorRepository->with($relations);

        if (isset($dataRequest['nome'])) {
            $items->where('nome', 'like', '%' . $dataRequest['nome'] . '%');
        }

        return $items->orderBy('nome', 'asc')->paginate(15);
    }

    /**
     * Create a new record.
     *
     * @param Request $request
     * @return mixed
     */
    public function storeConsultation($request): mixed
    {
        $dataRequest = $request->all();
        $dataRequest['data'] = date('Y-m-d H:i:s');
        $objectRegistered = $this->consultationRepository->create($dataRequest);
        return $objectRegistered;
    }

    /**
     * Get a paginated list of items.
     *
     * @param Request $request
     * @param array $relations
     * @return LengthAwarePaginator
     */
    public function getPatientsByDoctorId($medicoId, $request): Collection
    {
        $dataRequest = $request->query();
        $doctor = $this->doctorRepository->with(['consultas.paciente'])->find($medicoId);
        $consultations = $doctor->consultas;

        $patients = collect();

        if ($consultations->isNotEmpty()) {
            if (isset($dataRequest['apenas-agendadas'])) {
                $consultations = $consultations->where('data', '<=', now());
            }

            $patients = $consultations->map(fn($consultation) => $consultation->paciente->load('consultas'))
                ->unique('id')
                ->values();

            if (isset($dataRequest['nome'])) {
                $patients = $patients->filter(fn($patient) => stripos($patient->nome, $dataRequest['nome']) !== false);
            }
        }

        $patients = $patients->sortBy('nome')->values();

        return $patients;
    }
}
