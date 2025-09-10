<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
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

                TextColumn::make('customer_name')
                    ->label('Клиент')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('customer_email')
                    ->label('Имейл')
                    ->searchable(),

                TextColumn::make('total')
                    ->label('Сума')
                    ->money('bgn')
                    ->sortable(),

                TextColumn::make('items.book.title')
                    ->label('Книги')
                    ->formatStateUsing(function ($state, $record) {
                        return $record->items->pluck('book.title')->join(', ');
                    })
                    ->limit(50),


                BadgeColumn::make('status')
                    ->label('Статус')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'completed',
                        'info'    => 'paid',
                        'primary' => 'shipped',
                        'danger'  => 'cancelled',
                    ])
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Създадена')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([])
            ->recordActions([
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
