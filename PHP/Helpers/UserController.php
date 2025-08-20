<?php
declare(strict_types=1);

namespace PHP\Helpers;

use PDO;
use PHP\Modals\Post;
use PHP\Modals\User;

class UserController
{
    private DatabaseConnectoion $db;

    public function __construct()
    {
        $this->db = new DataBaseConnectoion();
    }

    public function getUserByToken(): User|false
    {
        try {
            SessionController::startSession();

            if (!isset($_SESSION['token'])) {
                return false;
            }

            $token = $_SESSION['token'];

            $this->db->connect();

            if (!$this->db->database) {
                return false;
            }

            $stmt = $this->db->database->prepare("SELECT `id`, `email` FROM users WHERE session_token = :token LIMIT 1");
            $stmt->bindParam(':token', $token);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                return false;
            }

            return new User($user['id'], $user['email'], null);
        }catch (\PDOException $e){
            return false;
        }
    }

    public function getUserPosts()
    {
        try {
            $user = $this->getUserByToken();

            if (!$user) {
                return false;
            }

            $this->db->connect();

            if (!$this->db->database) {
                return false;
            }

            $stmt = $this->db->database->prepare("SELECT * FROM posts WHERE user_id = :id ORDER BY created_at DESC");
            $stmt->bindParam(':id', $user->id);
            $stmt->execute();
            $prePosts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $posts = [];

            foreach ($prePosts as $prePost) {
                $posts[] = new Post($prePost['id'], $prePost['user_id'], $prePost['title'], $prePost['content'], $prePost['created_at']);
            }

            return $posts;
        }catch (\PDOException $e){
            return false;
        }
    }
}