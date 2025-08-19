<?php
declare(strict_types=1);

namespace PHP\Helpers;

use DateTime;
use PDO;
use PDOException;
use PHP\Modals\Post;
use PHP\Modals\User;

class PostController
{
    private DatabaseConnectoion $db;
    private  UserController $userController;
    private User|false $user;

    public function __construct()
    {
        $this->db = new DataBaseConnectoion();
        $this->userController = new UserController();
        $this->user = $this->userController->getUserByToken();
    }

    public function createPost(string $title, string $content): false|Post
    {
        try {
            if (!$this->user) {
                return false;
            }
            $now = date('d-m-y');

            $this->db->connect();

            if (!$this->db->database) {
                return false;
            }

            $stmt = $this->db->database->prepare("INSERT INTO posts (title, content, created_at, user_id) VALUES (:title, :content, :date, :user)");
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':date', $now);
            $stmt->bindParam(':user', $this->user->id);
            $stmt->execute();
            $id = $this->db->database->lastInsertId();

            if (!$id)
            {
                return false;
            }

            return new Post(intval($id), intval($this->user->id), $title, $content, $now);
        }catch (PDOException $e){
            return false;
        }
    }

    public function updatePost(int $id, string $title, string $content): bool
    {
        try {
            if (!$this->user) {
                return false;
            }

            $this->db->connect();

            if (!$this->db->database) {
                return false;
            }

            $stmt = $this->db->database->prepare(
                "UPDATE posts SET title = :title, content = :content WHERE id = :id AND user_id = :user"
            );
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':user', $this->user->id);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function deletePost(int $id): bool
    {
        try {
            if (!$this->user) {
                return false;
            }

            $this->db->connect();

            if (!$this->db->database) {
                return false;
            }

            $stmt = $this->db->database->prepare("DELETE FROM posts WHERE id = :id AND user_id = :user");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':user', $this->user->id);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getPost($id): false|array
    {
        try {
            $this->db->connect();

            if (!$this->db->database) {
                return false;
            }

            $stmt = $this->db->database->prepare("
                SELECT 
                    posts.*, 
                    users.id, 
                    users.email 
                FROM posts as posts 
                INNER JOIN users as users ON posts.user_id = users.id 
                WHERE posts.id = :id
            ");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $prePost = $stmt->fetch(PDO::FETCH_ASSOC);

            return [
                "user" => new User($prePost['user_id'], $prePost['email'], null),
                "post" => new Post($prePost['id'], $prePost['user_id'], $prePost['title'], $prePost['content'], $prePost['created_at'])
            ];
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getAllPost(): false|array
    {
        try {
            $this->db->connect();

            if (!$this->db->database) {
                return false;
            }

            $stmt = $this->db->database->prepare("SELECT * FROM posts INNER JOIN users ON posts.user_id = users.id");
            $stmt->execute();
            $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            var_dump($posts);
            return $posts;
        }catch (PDOException $e) {
            return false;
        }
    }
}