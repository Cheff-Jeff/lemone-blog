<?php
declare(strict_types=1);

namespace PHP\Modals;

class User
{
    public int $id;
    public string $email;
    private string|null $password;
    private $session_token;

    public function __construct(int $id, string $email, string|null $password)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
    }
}