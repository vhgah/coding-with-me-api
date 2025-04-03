<?php

namespace App\Actions;

use App\Models\Category;

class CreateCategory
{
    public function __construct(
        private array $data
    ) {
    }

    public function execute(): Category
    {
        $category = Category::create([
            'name' => $this->data['name'],
            'slug' => $this->data['slug'],
            'position' => $this->data['position'],
        ]);

        return $category;
    }

    public static function make(array $data): self
    {
        return new self($data);
    }
}
