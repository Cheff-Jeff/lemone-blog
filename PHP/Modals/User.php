<?php
declare(strict_types=1);

namespace PHP\Modals;

class User
{
    private $id;
    private $email;
    private $password;
    private $session_token;
    private $token_expiration;

    public function __construct(int $id, string $email, string|null $password)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
    }
}