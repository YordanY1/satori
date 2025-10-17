<?php

namespace App\Filament\Resources\Books\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BooksTable
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

                TextColumn::make('author.name')
                    ->label('Автор')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('genre.name')
                    ->label('Жанр')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('cover')
                    ->label('Корица')
                    ->searchable(),

                TextColumn::make('price')
                    ->label('Цена')
                    ->money('bgn', true)
                    ->sortable(),

                TextColumn::make('weight')
                    ->label('Тегло (гр.)')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('format')
                    ->label('Формат'),

                TextColumn::make('excerpt')
                    ->label('Откъс')
                    ->searchable(),

                IconColumn::make('is_book_of_month')
                    ->label('Книга на месеца')
                    ->boolean(),

                IconColumn::make('is_recommended')
                    ->label('Препоръчана')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label('Създадена на')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Обновена на')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([

            ])
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
