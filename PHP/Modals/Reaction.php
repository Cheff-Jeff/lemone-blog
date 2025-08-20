<?php

namespace PHP\Modals;

class Reaction
{
    public int $id;
    public int $user_id;
    public int $post_id;
    public string $title;
    public string $content;
    public string $created_at;

    public function __construct(int $id, int $user_id, int $post_id, string $title, string $content, string $created_at)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->post_id = $post_id;
        $this->title = $title;
        $this->content = $content;
        $this->created_at = $created_at;
    }
}