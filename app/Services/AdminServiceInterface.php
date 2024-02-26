<?php

namespace App\Services;

interface AdminServiceInterface
{
    public function getAllAdmins(array $filter,array $paginate);

    public function detailAdmin($id);

    public function deleteAdmin($id);

    public function createAdmin($params);

    public function updateAdmin($params);
}
