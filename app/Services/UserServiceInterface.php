<?php

namespace App\Services;

interface UserServiceInterface
{
    public function getAllUsers(array $filter,array $paginate);

    public function detailUser($id);

    public function deleteUser($id);

    public function createUser($params);

    public function updateUser($params);
}
