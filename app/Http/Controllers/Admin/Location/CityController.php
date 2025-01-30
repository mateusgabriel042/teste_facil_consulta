<?php
namespace App\Http\Controllers\Admin\Location;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Location\CityRequest;
use App\Http\Requests\Doctor\DoctorRequest;
use App\Http\Resources\Location\CityResource;
use App\Http\Resources\Doctor\DoctorResource;
use App\Services\Location\CityService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Traits\ApiResponser;

class CityController extends Controller
{
    use ApiResponser;

    private $relations = [];

    public function __construct(
        private readonly CityService $cityService
    ){}

    public function index(CityRequest $request): JsonResponse
    {
        try {
            $items = $this->cityService->getList($request, $this->relations);

            return $this->success([
                'cidades' => CityResource::collection($items),
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

    public function doctors($id_cidade, DoctorRequest $request): JsonResponse
    {
        try {
            $items = $this->cityService->getDoctors($id_cidade, $request);

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
}
