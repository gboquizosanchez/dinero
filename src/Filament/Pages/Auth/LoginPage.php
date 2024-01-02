<?php

declare(strict_types=1);

namespace Filament\Pages\Auth;

use Override;

final class LoginPage extends Login
{
    #[Override]
    public function mount(): void
    {
        parent::mount();

        if (app()->isLocal()) {
            $this->form->fill([
                'email' => 'gboquizo@gmail.com',
                'password' => '12345678',
                'remember' => true,
            ]);
        }
    }
}
