<?php

declare(strict_types=1);

namespace Filament\Widgets;

use Filament\Resources\TransactionResource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Override;
use Taka\Domain\Models\Transaction;

final class LatestTransaction extends TableWidget
{
    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 3;

    #[Override]
    public function table(Table $table): Table
    {
        return $table
            ->query(TransactionResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('happened_at', 'desc')
            ->columns((new TransactionResource())->tableColumns())
            ->actions([
                Action::make('view')
                    ->url(fn (Transaction $record): string => TransactionResource::getUrl('edit', ['record' => $record])),
            ]);
    }
}
