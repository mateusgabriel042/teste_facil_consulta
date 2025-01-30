<?php

namespace App\Http\Controllers\Admin\Core;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Core\UserRequest;
use App\Http\Resources\Core\UserResource;
use App\Services\Core\UserService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ApiResponser;

    public function __construct(
        private readonly UserService $userService
    )
    {}

    public function index(UserRequest $request): JsonResponse
    {
        try {
            $items = $this->userService->listUsers();

            return $this->success([
                'usuarios' => UserResource::collection($items),
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
