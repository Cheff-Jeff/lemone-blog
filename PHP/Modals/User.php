<?php
declare(strict_types=1);

namespace PHP\Modals;

class User
{
    public $id;
    public $email;
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