<?php

namespace App\Services\Core;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BaseService
{

    private $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
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
        $this->checkAccess($this->role.'-view');
        $dataRequest = $request->query();
        $items = $this->repository->with($relations);

        if (isset($dataRequest['field_filter']) && isset($dataRequest['value_filter'])) {
            $items->where($dataRequest['field_filter'], 'like', '%' . $dataRequest['value_filter'] . '%');
        }

        if (isset($dataRequest['sort_by']) && isset($dataRequest['sort_order'])) {
            $items->orderBy($request['sort_by'], $request['sort_order']);
        }

        $perPage = isset($dataRequest['per_page']) ? $dataRequest['per_page'] : 15;
        return $items->paginate($perPage);
    }

    /**
     * Create a new record.
     *
     * @param Request $request
     * @return mixed
     */
    public function create($request): mixed
    {
        $this->checkAccess($this->role.'-create');
        $user = Auth::user();
        $dataRequest = $request->all();
        $dataRequest['created_by'] = $user->id;
        $dataRequest['user_creation_id'] = $user->id;
        $dataRequest['user_change_id'] = $user->id;
        $objectRegistered = $this->repository->create($dataRequest);

        return $objectRegistered;
    }

    /**
     * Find a record by ID.
     *
     * @param int|string $id
     * @param array $relations
     * @return mixed
     */
    public function find($id, $relations = []): mixed
    {
        $this->checkAccess($this->role.'-view');

        return $this->repository->with($relations)->findOrFail($id);
    }

    /**
     * Update a record by ID.
     *
     * @param Request $request
     * @param int|string $id
     * @return mixed
     */
    public function update($request, $id): mixed
    {
        $this->checkAccess($this->role.'-update');
        $user = Auth::user();
        $objectEdit = $this->repository->find($id);
        $dataRequest = $request->all();
        $dataRequest['updated_by'] = $user->id;
        $dataRequest['user_change_id'] = $user->id;
        $objectEdit->update($dataRequest);

        return $objectEdit;
    }

    /**
     * Delete records by ID.
     *
     * @param Request $request
     * @return Collection
     */
    public function delete($request): Collection
    {
        $this->checkAccess($this->role.'-delete');
        $ids = explode(',', trim($request->get('ids')));
        $registers = $this->repository->whereIn('id', $ids)->get();
        $this->repository->destroy($ids);
        return $registers;
    }

    /**
     * Get details for the current repository.
     *
     * @return array
     */
    public function getDetails(): array
    {
        $this->checkAccess($this->role.'-view');
        $data = [
            'count' => $this->repository->all()->count(),
        ];

        return $data;
    }
}
