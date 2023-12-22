<?php

declare(strict_types=1);

namespace Laravel\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Override;

final class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // Silence is golden.
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Silence is golden.
    }

    /**
     * Bootstrap any application services.
     */
    #[Override]
    public function register(): void
    {
        parent::register();

        // Silence is golden.
    }
}
