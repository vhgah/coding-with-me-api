<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use App\RepositoryInterfaces\CategoryRepositoryInterface;

class CategoryRepository extends EloquentRepository implements CategoryRepositoryInterface
{
    protected function query(array $options = []): Builder
    {
        return Category::query()
            ->when(!empty($options['id']), function ($query) use ($options) {
                return $query->where('id', $options['id']);
            })
            ->when(!empty($options['slug']), function ($query) use ($options) {
                return $query->where('slug', $options['slug']);
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
