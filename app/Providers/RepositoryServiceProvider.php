<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $repositoryBindings = [
        \App\RepositoryInterfaces\PostRepositoryInterface::class => \App\Repositories\PostRepository::class,
        \App\RepositoryInterfaces\FileRepositoryInterface::class => \App\Repositories\FileRepository::class,
        \App\RepositoryInterfaces\CategoryRepositoryInterface::class => \App\Repositories\CategoryRepository::class,
    ];

    public function register(): void
    {
        foreach ($this->repositoryBindings as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }
}
