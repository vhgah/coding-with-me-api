<?php

namespace App\Actions;

use App\Models\Post;

class CreatePost
{
    public function __construct(
        private array $data
    ) {
    }

    public function execute(): Post
    {
        $file = Post::create([
            'title' => $this->data['title'],
            'slug' => $this->data['slug'],
            'summary' => $this->data['summary'] ?? null,
            'content' => $this->data['content'],
            'status' => $this->data['status'],
            'published_at' => $this->data['published_at'] ?? null,
            'admin_id' => $this->data['admin_id'],
            'category_id' => $this->data['category_id'],
            'featured_image' => $this->data['featured_image'] ?? null,
        ]);

        return $file;
    }

    public static function make(array $data): self
    {
        return new self($data);
    }
}
