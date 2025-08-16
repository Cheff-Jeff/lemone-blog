<?php
declare(strict_types=1);

namespace PHP\Helpers;

use PDO;
use PDOException;
use PHP\Modals\User;

class AuthController
{
    private $db;

    public function __construct()
    {
        $this->db = new DatabaseConnectoion();
    }

    public function login(string $email, string $password)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        try {
            $this->db->connect();

            if (!$this->db->database) {
                return false;
            }

            $stmt = $this->db->database->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $preUser = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!password_verify($password, $preUser["password"])){
                return false;
            }

            $this->db->connect();
            return $this->setSessionToken(new User($preUser["id"], $preUser["email"], $preUser["password"]));
        }catch (\Exception $exception){
            return false;
        }
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
            if (!$this->checkEmail($email)) {
                return;
            }

            $this->db->connect();

            if (!$this->db->database) {
                return;
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $this->db->database->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);

            $result = $stmt->execute();
            var_dump($result);
            $this->db->disconnect();

            $this->login($email, $password);
        }catch (PDOException $e){
            var_dump($e);
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
                return false;
            }

            $this->db->disconnect();
            return true;
        }catch (\Exception $exception) {
            return false;
        }
    }

    public function startSession(): void
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    private function setSessionToken(User $user): string
    {
        try {
            $token = bin2hex(random_bytes(32));

            $this->db->connect();
            $stmt = $this->db->database->prepare("UPDATE users SET session_token = :token WHERE id = :id");
            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':id', $user["id"]);
            $stmt->execute();
            $this->db->disconnect();

            $this->startSession();
            $_SESSION['token'] = $token;

            return $token;
        }catch (PDOException $e){
            return $e->getMessage();
        }
    }
}