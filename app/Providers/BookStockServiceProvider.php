<?php

namespace App\Providers;

use App\Interfaces\BookStockRepositoryInterface;
use App\Repositories\BookStockRepository;
use Illuminate\Support\ServiceProvider;

class BookStockServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(BookStockRepositoryInterface::class, BookStockRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
