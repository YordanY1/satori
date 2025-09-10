<?php

namespace App\Filament\Resources\Books\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use App\Models\Genre;
use App\Models\Author;


class BookForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Заглавие')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('slug', Str::slug($state));
                    }),

                TextInput::make('slug')
                    ->label('Slug')
                    ->disabled()
                    ->dehydrated(true)
                    ->required()
                    ->unique(ignoreRecord: true),

                Select::make('author_id')
                    ->label('Автор')
                    ->options(Author::pluck('name', 'id')->toArray())
                    ->searchable()
                    ->required(),


                Select::make('genre_id')
                    ->label('Жанр')
                    ->options(Genre::pluck('name', 'id')->toArray())
                    ->nullable(),

                FileUpload::make('cover')
                    ->label('Корица')
                    ->image()
                    ->directory('books')
                    ->disk('public')
                    ->visibility('public')
                    ->imagePreviewHeight('200')
                    ->downloadable()
                    ->nullable(),

                Textarea::make('description')
                    ->label('Описание')
                    ->columnSpanFull()
                    ->nullable(),

                TextInput::make('price')
                    ->label('Цена (лв.)')
                    ->required()
                    ->numeric()
                    ->prefix('лв.'),

                TextInput::make('price_eur')
                    ->label('Цена (EUR)')
                    ->numeric()
                    ->step(0.01)
                    ->prefix('€')
                    ->nullable(),

                TextInput::make('weight')
                    ->label('Тегло (кг)')
                    ->numeric()
                    ->step(0.001)
                    ->nullable(),

                Select::make('format')
                    ->label('Формат')
                    ->options([
                        'paper' => 'Хартиена книга',
                        'ebook' => 'Електронна книга',
                    ])
                    ->default('paper')
                    ->required(),

                FileUpload::make('excerpt')
                    ->label('Откъс (PDF)')
                    ->directory('books/excerpts')
                    ->disk('public')
                    ->visibility('public')
                    ->acceptedFileTypes(['application/pdf'])
                    ->downloadable()
                    ->nullable(),

                Toggle::make('is_book_of_month')
                    ->label('Книга на месеца')
                    ->default(false),

                Toggle::make('is_recommended')
                    ->label('Препоръчана книга')
                    ->default(false),
            ]);
    }
}
