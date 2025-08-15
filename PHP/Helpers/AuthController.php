<?php
declare(strict_types=1);

namespace PHP\Helpers;

use PDOException;

class AuthController
{
    private $db;

    public function __construct()
    {
        $this->db = new DatabaseConnectoion();
    }

    public function login(string $email, string $password)
    {

    }

    public function logout()
    {

    }

    public function register(string $email, string $password): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return;
        }

        try {
            $this->db->connect();

            if (!$this->db->database) {
                return;
            }

            if (!$this->checkEmail($email)) {
                return;
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $this->db->database->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);

            $stmt->execute();

            $this->db->disconnect();

//            TODO: Login user after sucses
        }catch (PDOException $e){
            die($e->getMessage());
        }
    }

    private function checkEmail(string $email): bool
    {
        try {
            $this->db->connect();

            if (!$this->db->database) {
                return false;
            }

            $stmt = $this->db->database->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $this->db->disconnect();
                return true;
            }

            $this->db->disconnect();
            return false;
        }catch (\Exception $exception) {
            return false;
        }
    }
}