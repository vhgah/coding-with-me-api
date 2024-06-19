<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use App\RepositoryInterfaces\PostRepositoryInterface;

class PostRepository extends EloquentRepository implements PostRepositoryInterface
{
    protected function query(array $options = []): Builder
    {
        return Post::query()
            ->when(!empty($options['keyword']), function ($query) use ($options) {
                return $query->where('title', 'like', '%' . $options['keyword'] . '%');
            })
            ->when(isset($options['status']), function ($query) use ($options) {
                return $query->where('status', $options['status']);
            });
    }
}
