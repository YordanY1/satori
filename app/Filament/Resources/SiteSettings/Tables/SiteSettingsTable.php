<?php

namespace App\Filament\Resources\SiteSettings\Tables;

use App\Models\Book;
use App\Models\Event;
use App\Models\Post;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SiteSettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')
                    ->label('Тип настройка')
                    ->formatStateUsing(function (string $state) {
                        return match ($state) {
                            'featured_book_id' => 'Избрана книга',
                            'featured_event_id' => 'Избрано събитие',
                            'featured_post_id' => 'Избран пост',
                            default => $state,
                        };
                    })
                    ->sortable(),
                TextColumn::make('value')
                    ->label('Стойност')
                    ->formatStateUsing(function ($state, $record) {
                        return match ($record->key) {
                            'featured_book_id' => optional(Book::find($state))->title ?? '-',
                            'featured_event_id' => optional(Event::find($state))->title ?? '-',
                            'featured_post_id' => optional(Post::find($state))->title ?? '-',
                            default => $state,
                        };
                    })
                    ->searchable(),

                TextColumn::make('updated_at')
                    ->label('Обновено на')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
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
