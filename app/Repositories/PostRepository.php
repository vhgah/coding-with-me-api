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
            ->when(!empty($options['id']), function ($query) use ($options) {
                return $query->where('id', $options['id']);
            })
            ->when(!empty($options['slug']), function ($query) use ($options) {
                return $query->where('slug', $options['slug']);
            })
            ->when(!empty($options['admin_id']), function ($query) use ($options) {
                return $query->where('admin_id', $options['admin_id']);
            })
            ->when(!empty($options['category_id']), function ($query) use ($options) {
                return $query->where('category_id', $options['category_id']);
            })
            ->when(!empty($options['category_slug']), function ($query) use ($options) {
                return $query->whereHas('category', function ($query) use ($options) {
                    return $query->where('slug', $options['category_slug']);
                });
            })
            ->when(!empty($options['keyword']), function ($query) use ($options) {
                return $query->where('title', 'like', '%' . $options['keyword'] . '%');
            })
            ->when(isset($options['status']), function ($query) use ($options) {
                return $query->where('status', $options['status']);
            })
            ->when(!empty($options['sort_field']), function ($query) use ($options) {
                $sortOrder = $options['sort_order'] ?? 'asc';

                if ($sortOrder == 'descend') {
                    $sortOrder = 'desc';
                }

                if ($sortOrder == 'ascend') {
                    $sortOrder = 'asc';
                }

                if (!in_array(strtolower($sortOrder), ['asc', 'desc'])) {
                    $sortOrder = 'asc';
                }

                $query->orderBy($options['sort_field'], $sortOrder);
            });
    }
}
