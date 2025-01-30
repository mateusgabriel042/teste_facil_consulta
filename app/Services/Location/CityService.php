<?php

namespace App\Services\Location;

use App\Contracts\Location\CityRepository;
use App\Contracts\Doctor\DoctorRepository;
use App\Services\Core\BaseService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CityService extends BaseService
{
    public function __construct(
        private readonly CityRepository $cityRepository,
        private readonly DoctorRepository $doctorRepository
    ) {
        parent::__construct($cityRepository);
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
        $items = $this->cityRepository->with($relations);

        if (isset($dataRequest['nome'])) {
            $items->where('nome', 'like', '%' . $dataRequest['nome'] . '%');
        }

        return $items->orderBy('nome', 'asc')->paginate(15);
    }

    /**
     * Get a paginated list of items.
     *
     * @param Request $request
     * @param array $relations
     * @return LengthAwarePaginator
     */
    public function getDoctors($cityId, $request): LengthAwarePaginator
    {
        $dataRequest = $request->query();
        $items = $this->doctorRepository->where('cidade_id', $cityId);

        if (isset($dataRequest['nome'])) {
            $items->where('nome', 'like', '%' . $dataRequest['nome'] . '%');
        }

        return $items->orderBy('nome', 'asc')->paginate(15);
    }
}
