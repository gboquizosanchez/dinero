<?php

declare(strict_types=1);

namespace Filament\Providers;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Http\Middleware\IdentifyTenant;
use Filament\Pages\Auth\LoginPage;
use Filament\Pages\DashboardPage;
use Filament\Pages\Tenancy\EditAccountProfile;
use Filament\Pages\Tenancy\RegisterAccount;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Jeffgreco13\FilamentBreezy\BreezyCore;
use Override;
use Taka\Domain\Models\Account;

final class TakaPanelServiceProvider extends PanelProvider
{
    #[Override]
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('taka')
            ->default()
            ->login(LoginPage::class)
            ->colors([
                'primary' => Color::Orange,
                'secondary' => Color::Yellow,
            ])
            ->discoverResources(
                in: base_path('src/Filament/Resources'),
                for: 'Filament\\Resources',
            )
            ->discoverPages(
                in: base_path('src/Filament/Pages'),
                for: 'Filament\\Pages'
            )
            ->discoverWidgets(
                in: base_path('src/Filament/Widgets'),
                for: 'Filament\\Widgets'
            )
            ->pages([
                DashboardPage::class,
            ])
            ->sidebarWidth('17rem')
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                IdentifyTenant::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->profile()
            ->sidebarCollapsibleOnDesktop()
            ->plugin(
                BreezyCore::make()
                    ->myProfile(hasAvatars: true)
                    ->enableTwoFactorAuthentication()
            )
            ->tenant(model: Account::class, slugAttribute: 'id', ownershipRelationship: 'owner')
            ->tenantRegistration(RegisterAccount::class)
            ->tenantProfile(EditAccountProfile::class)
            ->renderHook('panels::content.start', function () {
                if (config('app.demo')) {
                    return view('banner');
                }

                return null;
            })
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s');
    }
}
