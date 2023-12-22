<?php

declare(strict_types=1);

namespace Filament\Pages\Tenancy;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Illuminate\Database\Eloquent\Model;
use Override;

final class RegisterAccount extends RegisterTenant
{
    protected static ?string $navigationIcon = 'heroicon-m-document-text';

    #[Override]
    public function isCachingForms(): bool
    {
        return false;
    }

    #[Override]
    public static function getSlug(): string
    {
        return 'register-account';
    }

    #[Override]
    public static function getLabel(): string
    {
        return 'Register Account';
    }

    #[Override]
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->placeholder('Personal Account'),
            ]);
    }

    /**
     * @param array<string, mixed> $data
     */
    #[Override]
    protected function handleRegistration(array $data): Model
    {
        return auth()->user()->ownedAccounts()->create($data);
    }
}
