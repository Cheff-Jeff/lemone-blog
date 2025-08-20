<?php
declare(strict_types=1);

namespace PHP\Helpers;

use PHP\Modals\Reaction;
use PHP\Modals\User;

class ReactionController
{
    private DatabaseConnectoion $db;
    private PostController $postController;
    private User|false $user;
    public function __construct()
    {
        $this->db = new DataBaseConnectoion();
        $userController = new UserController();
        $this->postController = new PostController();
        $this->user = $userController->getUserByToken();
    }

    public function createReaction(int $postId, string $title, string $content): bool
    {
        try {
            if (!$this->user){
                return false;
            }

            $this->db->connect();
            if (!$this->db->database) {
                return false;
            }

            $now = date('Y-m-d');

            $stmt = $this->db->database->prepare("
                INSERT INTO reactions (post_id, user_id, title, content, date) 
                VALUES (:post_id, :user_id, :title, :content, :date)
            ");
            $stmt->bindParam(':post_id', $postId);
            $stmt->bindParam(':user_id', $this->user->id);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':date', $now);
            $stmt->execute();

            return true;
        }catch (\PDOException $e){
            return false;
        }
    }

    public function updateReaction(int $reactionId, int $postId, string $title, string $content): bool
    {
        try {
            if (!$this->user){
                return false;
            }

            $this->db->connect();
            if (!$this->db->database) {
                return false;
            }

            $stmt = $this->db->database->prepare("UPDATE reactions SET title = :title, content = :content WHERE id = :id AND user_id = :user_id AND post_id = :post_id");
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':id', $reactionId);
            $stmt->bindParam(':user_id', $this->user->id);
            $stmt->bindParam(':post_id', $postId);
            $stmt->execute();

            return true;
        } catch (\PDOException $e){
            return false;
        }
    }

    public function deleteReaction(int $reactionId, int $postId)
    {
        try {
            if (!$this->user){
                return false;
            }

            $this->db->connect();
            if (!$this->db->database) {
                return false;
            }

            $stmt = $this->db->database->prepare("DELETE FROM reactions WHERE id = :id AND post_id = :post_id AND user_id = :user_id");
            $stmt->bindParam(':id', $reactionId);
            $stmt->bindParam(':post_id', $postId);
            $stmt->bindParam(':user_id', $this->user->id);
            $stmt->execute();

            return true;
        }catch (\PDOException $e){
            return false;
        }
    }

    public function getPostReactions($postId): false|array
    {
        try {
            if (!$this->user){
                return false;
            }

            $this->db->connect();
            if (!$this->db->database) {
                return false;
            }

            $stmt = $this->db->database->prepare("
                SELECT reaction.*, users.id as user_id, users.email 
                FROM reactions as reaction 
                INNER JOIN users as users 
                ON posts.user_id = users.id WHERE post_id = :post_id
            ");
            $stmt->bindParam(':post_id', $postId);
            $stmt->execute();
            $preReactions = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            /** @var Reaction[] $reactions */
            $reactions = [];

            foreach ($preReactions as $reaction){
                $reactions[] = new Reaction($reaction['id'], $reaction['user_id'], $postId, $reaction['title'],$reaction['content'],$reaction['date']);
            }

            return $reactions;
        }catch (\PDOException $e){
            return false;
        }
    }
}