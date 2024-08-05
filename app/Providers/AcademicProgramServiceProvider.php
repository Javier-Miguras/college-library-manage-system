<?php

namespace App\Providers;

use App\Interfaces\AcademicProgramRepositoryInterface;
use App\Repositories\AcademicProgramRepository;
use Illuminate\Support\ServiceProvider;

class AcademicProgramServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(AcademicProgramRepositoryInterface::class, AcademicProgramRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
