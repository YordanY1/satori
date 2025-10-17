<?php

namespace App\Filament\Resources\Events\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Заглавие')
                    ->searchable(),
                TextColumn::make('slug')
                    ->label('Слаг (URL име)')
                    ->searchable(),
                TextColumn::make('date')
                    ->label('Дата')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('location')
                    ->label('Локация')
                    ->searchable(),
                IconColumn::make('is_paid')
                    ->label('Платено събитие')
                    ->boolean(),
                TextColumn::make('payment_link')
                    ->label('Линк за плащане')
                    ->searchable(),
                TextColumn::make('registration_link')
                    ->label('Линк за регистрация')
                    ->searchable(),
                TextColumn::make('video_url')
                    ->label('Видео линк')
                    ->searchable(),
                TextColumn::make('cover')
                    ->label('Корица')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Създадено на')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Обновено на')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make()->label('Редактирай'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->label('Изтрий избраните'),
                ]),
            ]);
    }
}
