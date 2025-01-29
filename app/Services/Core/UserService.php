<?php

namespace App\Services\Core;

use App\Contracts\Core\UserRepository;
use App\Http\Requests\Core\UserRequest;
use App\Traits\CheckAccess;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;

class UserService extends BaseService
{
    use CheckAccess;

    private $role = 'user';

    public function __construct(
        private readonly UserRepository $userRepository,
    ) {
        parent::__construct($this->role, $userRepository);
    }

    /**
     * Cria um novo usuário.
     *
     * @param UserRequest $request
     * @return mixed
     */
    public function createUser(UserRequest $request): mixed
    {
        $this->checkAccess($this->role.'-create');
        $dataRequest = $request->all();
        $dataRequest['password'] = Hash::make($dataRequest['password']);
        $user = $this->userRepository->create($dataRequest);

        return $user;
    }

    /**
     * Atualiza um usuário com base na solicitação.
     *
     * @param UserRequest $request
     * @param int $id
     * @return mixed
     */
    public function updateUser(UserRequest $request, $id): mixed
    {
        $this->checkAccess($this->role.'-update');
        $user = $this->userRepository->find($id);
        $dataUser = $request->except('role_id', 'permissions');

        if (isset($dataUser['password']) != null && trim($dataUser['password']) != '') {
            $newPassword = Hash::make($dataUser['password']);

            $dataUser['password'] = $newPassword;
        }

        $user->update($dataUser);
        $user->roles()->detach();
        $user->permissions()->detach();

        return $user;
    }

     /**
     * Exclui um ou mais usuários.
     *
     * @param \Illuminate\Http\Request $request
     * @return Collection
     */
    public function delete($request): Collection
    {
        $this->checkAccess($this->role.'-delete');

        $ids = explode(',', trim($request->get('ids')));
        $users = $this->userRepository->whereIn('id', $ids)->get();

        foreach($users as $user) {
            $user->roles()->detach();
            $user->permissions()->detach();
            $user->delete();
        }

        return $users;
    }


}
