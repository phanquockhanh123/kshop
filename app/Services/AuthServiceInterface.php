<?php

namespace App\Services;

interface AuthServiceInterface
{
    public function login(array $params);

    public function resetPassword(array $params);

    public function confirmResetPasswordToken(array $params);

    public function forgotPassword(array $params);

    public function logout();

    public function changePassword($params);
}