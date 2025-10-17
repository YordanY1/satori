<?php

namespace App\Filament\Resources\Genres;

use App\Filament\Resources\Genres\Pages;
use App\Filament\Resources\Genres\Schemas\GenreForm;
use App\Models\Genre;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;

class GenreResource extends Resource
{
    protected static ?string $model = Genre::class;

    protected static ?string $modelLabel = 'Жанр';
    protected static ?string $pluralModelLabel = 'Жанрове';
    protected static ?string $navigationLabel = 'Жанрове';
    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationIcon(): \BackedEnum|string|null
    {
        return 'heroicon-o-rectangle-stack';
    }

    public static function form(Schema $schema): Schema
    {
        return GenreForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Име')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Слаг (URL име)')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Активен')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Създаден на')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->actions([
                EditAction::make()->label('Редактирай'),
                DeleteAction::make()->label('Изтрий'),
            ])
            ->bulkActions([
                DeleteBulkAction::make()->label('Изтрий избраните'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListGenres::route('/'),
            'create' => Pages\CreateGenre::route('/create'),
            'edit'   => Pages\EditGenre::route('/{record}/edit'),
        ];
    }
}
