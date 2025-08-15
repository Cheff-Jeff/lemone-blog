<?php
declare(strict_types=1);

namespace PHP\Helpers;

class AuthController
{
    public function login(string $email, string $password)
    {

    }

    public function logout()
    {

    }

    public function register(string $email, string $password)
    {

    }

    public function checkEmail(string $email)
    {
        try {

        }catch (\Exception $exception) {
            throw new \Exception("Email al in gebruik.");
        }
    }
}