<?php

namespace App\Providers;

use App\Interfaces\CampusRepositoryInterface;
use App\Repositories\CampusRepository;
use Illuminate\Support\ServiceProvider;

class CampusServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CampusRepositoryInterface::class, CampusRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
