<?php
namespace App\Http\Controllers\Admin\Doctor;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\DoctorRequest;
use App\Http\Requests\Consultation\ConsultationRequest;
use App\Http\Requests\Patient\PatientRequest;
use App\Http\Resources\Doctor\DoctorResource;
use App\Http\Resources\Consultation\ConsultationResource;
use App\Http\Resources\Patient\PatientResource;
use App\Services\Doctor\DoctorService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Traits\ApiResponser;

class DoctorController extends Controller
{
    use ApiResponser;

    private $relations = [];

    public function __construct(
        private readonly DoctorService $doctorService
    ){}

    public function index(DoctorRequest $request): JsonResponse
    {
        try {
            $items = $this->doctorService->getList($request, $this->relations);

            return $this->success([
                'medicos' => DoctorResource::collection($items),
                'pagination' => [
                    'current_page' => $items->currentPage(),
                    'per_page' => $items->perPage(),
                    'pages' => $items->lastPage()
                ],
            ], 'Listagem realizada com sucesso!');
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function store(DoctorRequest $request): JsonResponse
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->verifyValidation($request);
        }

        try {
            $item = $this->doctorService->create($request);

            return $this->success([
                'medico' => new DoctorResource($item),
            ], 'Cadastro realizado com sucesso.');
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function storeConsultation(ConsultationRequest $request): JsonResponse
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->verifyValidation($request);
        }

        try {
            $item = $this->doctorService->storeConsultation($request);

            return $this->success([
                'consulta' => new ConsultationResource($item),
            ], 'Cadastro realizado com sucesso.');
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function patients(PatientRequest $request, $id_medico): JsonResponse
    {
        try {
            $items = $this->doctorService->getPatientsByDoctorId($id_medico, $request);

            return $this->success([
                'pacientes' => PatientResource::collection($items),
            ], 'Listagem realizada com sucesso!');
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}
