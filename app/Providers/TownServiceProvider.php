<?php

namespace App\Providers;

use App\Interfaces\TownRepositoryInterface;
use App\Repositories\TownRepository;
use Illuminate\Support\ServiceProvider;

class TownServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(TownRepositoryInterface::class, TownRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
