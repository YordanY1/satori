<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('№')
                    ->sortable(),

                TextColumn::make('order_number')
                    ->label('Поръчка')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('customer_name')
                    ->label('Клиент')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('customer_email')
                    ->label('Имейл')
                    ->icon('heroicon-m-envelope')
                    ->iconPosition('before')
                    ->copyable()
                    ->copyMessage('Имейлът е копиран!')
                    ->limit(30),

                TextColumn::make('total')
                    ->label('Сума')
                    ->money('bgn')
                    ->sortable()
                    ->alignRight(),

                TextColumn::make('items.book.title')
                    ->label('Книги')
                    ->formatStateUsing(
                        fn($state, $record) =>
                        $record?->items->pluck('book.title')->join(', ') ?? '—'
                    )
                    ->limit(60)
                    ->wrap(),

                IconColumn::make('needs_invoice')
                    ->label('Фактура')
                    ->boolean()
                    ->trueIcon('heroicon-o-document-text')
                    ->falseIcon('heroicon-o-x-mark')
                    ->tooltip(
                        fn($record) =>
                        $record?->needs_invoice
                            ? 'Клиентът желае фактура'
                            : 'Без фактура'
                    ),

                BadgeColumn::make('status')
                    ->label('Статус')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'completed',
                        'info'    => 'paid',
                        'primary' => 'shipped',
                        'danger'  => 'cancelled',
                    ])
                    ->formatStateUsing(fn(?string $state) => match ($state) {
                        'pending'   => 'В изчакване',
                        'completed' => 'Завършена',
                        'paid'      => 'Платена',
                        'shipped'   => 'Изпратена',
                        'cancelled' => 'Отказана',
                        default     => ucfirst($state ?? '—'),
                    })
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Създадена')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])

            ->filters([])

            ->recordActions([
                // 🔹 Само за гледане, без "Изпрати" или "Редактирай"
                Action::make('viewInvoice')
                    ->label('Фактура')
                    ->icon('heroicon-o-document-text')
                    ->modalHeading('Фактурни данни')
                    ->modalWidth('2xl')
                    ->modalContent(fn($record) => view('filament.orders.invoice-modal', [
                        'order' => $record,
                    ]))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Затвори')
                    ->visible(fn($record) => $record?->needs_invoice ?? false),

                EditAction::make()->label('Редакция'),
                DeleteAction::make()->label('Изтриване'),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->label('Изтриване избраните'),
                ]),
            ]);
    }
}
