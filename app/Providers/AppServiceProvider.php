<?php

declare(strict_types=1);

namespace App\Providers;

use App\Listeners\LogSuccessfulLogin;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Existing bindings
        $this->app->bind(
            \App\Repositories\Interfaces\ArticleRepositoryInterface::class,
            \App\Repositories\ArticleRepository::class
        );
        $this->app->bind(
            \App\Repositories\Contracts\AnnouncementRepositoryInterface::class,
            \App\Repositories\AnnouncementRepository::class
        );

        // Phase 3 — Digital Public Service bindings
        $this->app->bind(
            \App\Repositories\Interfaces\SuratRepositoryInterface::class,
            \App\Repositories\SuratRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\PengaduanRepositoryInterface::class,
            \App\Repositories\PengaduanRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(Login::class, LogSuccessfulLogin::class);
    }
}
