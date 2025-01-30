<?php
namespace App\Http\Controllers\Admin\Patient;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Patient\PatientRequest;
use App\Http\Resources\Patient\PatientResource;
use App\Services\Patient\PatientService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Traits\ApiResponser;

class PatientController extends Controller
{
    use ApiResponser;

    private $relations = [];

    public function __construct(
        private readonly PatientService $patientService
    )
    {}

    public function store(PatientRequest $request): JsonResponse
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->verifyValidation($request);
        }

        try {
            $item = $this->patientService->create($request);

            return $this->success([
                'paciente' => new PatientResource($item),
            ], 'Cadastro realizado com sucesso.');
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function update(PatientRequest $request, $id): JsonResponse
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->verifyValidation($request);
        }

        try {
            $item = $this->patientService->update($request, $id);

            return $this->success([
                'paciente' => new PatientResource($item),
            ], 'Atualização realizada com sucesso.');
        } catch (ModelNotFoundException $e) {
            return $this->error("Record with ID {$id} not found.", $e->getCode());
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}
