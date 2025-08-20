<?php

namespace PHP\Helpers;

use PHP\Modals\Post;

class SessionController
{
    public static function startSession(): void
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function isLoggedIn(): bool
    {
        $userLoggedIn = false;
        self::startSession();

        $userController = new UserController();
        $user = $userController->getUserByToken();

        if ($user) {
            $userLoggedIn = true;
        }

        return $userLoggedIn;
    }

    public static function postBelongsToUser(int $postId): bool
    {
        $postBelongsToUser = false;
        if (!is_numeric($postId)) return false;

        $userController = new UserController();
        $postController = new PostController();

        self::startSession();
        $user = $userController->getUserByToken();
        $postData = $postController->getPost($postId);

        if (!$user || !$postData) return false;

        /** @var Post $post */
        $post = $postData['post'];

        if ($post->user_id === $user->id) {
            $postBelongsToUser = true;
        }

        return $postBelongsToUser;
    }

    public static function reacrionBelongsToUser(int $reactionId): bool
    {
        if (!is_numeric($reactionId)) return false;
        $reactionBelongsToUser = false;

        $userController = new UserController();
        $reactionController = new ReactionController();

        self::startSession();
        $user = $userController->getUserByToken();
        $reaction = $reactionController->getReaction($reactionId);

        if (!$user || !$reaction) return false;

        if ($reaction->user_id === $user->id) {
            $reactionBelongsToUser = true;
        }

        return $reactionBelongsToUser;
    }
}