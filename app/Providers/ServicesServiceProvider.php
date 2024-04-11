<?php

namespace App\Providers;

use App\Services\AuthorService;
use App\Services\BookService;
use App\Services\ClientService;
use App\Services\Interfaces\AuthorServiceInterface;
use App\Services\Interfaces\BookServiceInterface;
use App\Services\Interfaces\ClientServiceInterface;
use Illuminate\Support\ServiceProvider;

class ServicesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            ClientServiceInterface::class,
            ClientService::class
        );

        $this->app->bind(
            AuthorServiceInterface::class,
            AuthorService::class
        );

        $this->app->bind(
            BookServiceInterface::class,
            BookService::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
