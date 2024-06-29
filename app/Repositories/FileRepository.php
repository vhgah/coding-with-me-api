<?php

namespace App\Repositories;

use App\Models\File;
use Illuminate\Database\Eloquent\Builder;
use App\RepositoryInterfaces\FileRepositoryInterface;

class FileRepository extends EloquentRepository implements FileRepositoryInterface
{
    protected function query(array $options = []): Builder
    {
        return File::query()
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
