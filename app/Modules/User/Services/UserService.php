<?php

namespace App\Modules\User\Services;

use App\Models\User;
use App\Modules\User\Repositories\UserRepository;



readonly class UserService
{
    public function __construct(private UserRepository $userRepository) {}

    public function create($data): User
    {
        $userData = $this->constructUserModel($data);

        $user = $this->userRepository->create($userData);

        return $user;
    }



    public function constructUserModel($data, bool $forUpdate = false): array
    {
        $fields = ['name', 'email', 'password'];
        $userData = [];

        foreach ($fields as $field) {
            $value = $data[$field] ?? null;

            if ($value !== null) {
                if ($field === 'password' && $forUpdate) {
                    continue;
                }

                $userData[$field] = $value;
            }
        }

        return $userData;
    }


    public function update($data, int $id): User
    {
        $userData = $this->constructUserModel($data, true);

        $user = $this->userRepository->update($userData, $id);

        return $user;
    }

    public function find($user_id)
    {
        return $this->userRepository->find($user_id);
    }
}
