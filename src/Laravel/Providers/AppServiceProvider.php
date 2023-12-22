<?php

declare(strict_types=1);

namespace Laravel\Providers;

use Barryvdh\Debugbar\ServiceProvider as DebugbarServiceProvider;
use Bavix\Wallet\WalletConfigure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Override;

final class AppServiceProvider extends ServiceProvider
{
    #[Override]
    public function register(): void
    {
        // Silence is golden.
    }

    public function boot(): void
    {
        Model::unguard();
        WalletConfigure::ignoreMigrations();

        Schema::defaultStringLength(191);

        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        if ($this->app->isLocal()) {
            //            Model::shouldBeStrict();

            $this->app->register(DebugbarServiceProvider::class);
        }
    }
}
