<?php

namespace App\Filament\Resources\Genres;

use App\Filament\Resources\Genres\Pages;
use App\Models\Genre;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\{TextInput, Textarea, Toggle};
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;

class GenreResource extends Resource
{
    protected static ?string $model = Genre::class;

    public static function getNavigationLabel(): string { return 'Жанрове'; }
    public static function getNavigationGroup(): \UnitEnum|string|null { return 'Каталог'; }
    public static function getNavigationIcon(): \BackedEnum|string|null { return 'heroicon-o-rectangle-stack'; }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Основно')->schema([
                TextInput::make('name')
                    ->label('Име')
                    ->required()
                    ->maxLength(255)
                    ->live()
                    ->afterStateUpdated(fn ($set, $state) => $set('slug', Str::slug($state))),

                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->unique(ignoreRecord: true),

                Textarea::make('description')
                    ->label('Описание')
                    ->rows(3),

                Toggle::make('is_active')
                    ->label('Активен')
                    ->default(true),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Име')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('slug')->searchable(),
                Tables\Columns\IconColumn::make('is_active')->boolean()->label('Активен'),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d.m.Y H:i')->label('Създаден')->sortable(),
            ])
            ->actions([
                EditAction::make()->label('Редакция'),
                DeleteAction::make()->label('Изтриване'),
            ])
            ->bulkActions([
                DeleteBulkAction::make()->label('Изтриване избраните'),
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
