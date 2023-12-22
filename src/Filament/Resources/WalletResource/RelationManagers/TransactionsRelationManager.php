<?php

declare(strict_types=1);

namespace Filament\Resources\WalletResource\RelationManagers;

use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\TransactionResource;
use Filament\Tables\Table;
use Override;

final class TransactionsRelationManager extends RelationManager
{
    protected static string $relationship = 'walletTransactions';

    #[Override]
    public function form(Form $form): Form
    {
        return (new TransactionResource())::form($form);
    }

    #[Override]
    public function table(Table $table): Table
    {
        return (new TransactionResource())::table($table);
    }
}
