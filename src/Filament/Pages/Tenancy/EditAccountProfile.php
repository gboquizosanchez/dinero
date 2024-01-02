<?php

declare(strict_types=1);

namespace Filament\Pages\Tenancy;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Override;

final class EditAccountProfile extends EditTenantProfile
{
    #[Override]
    public static function getLabel(): string
    {
        return __('pages.account_info');
    }

    #[Override]
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->autofocus()
                    ->required()
                    ->label(__('forms.name.label')),
            ]);
    }
}
