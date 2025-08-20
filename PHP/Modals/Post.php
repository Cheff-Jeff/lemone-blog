<?php
declare(strict_types=1);

namespace PHP\Modals;

class Post
{
    public int $id;
    public int $user_id;
    public string $title;
    public string $content;
    public string $created_at;

    public function __construct(int $id, int $user_id, string $title, string $content, string $created_at)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->title = $title;
        $this->content = $content;
        $this->created_at = $created_at;
    }
}