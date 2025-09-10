<?php

namespace App\Filament\Resources\Books\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BookForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('author_id')
                    ->required()
                    ->numeric(),
                TextInput::make('genre_id')
                    ->numeric()
                    ->default(null),
                TextInput::make('cover')
                    ->default(null),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('weight')
                    ->numeric()
                    ->default(null),
                Select::make('format')
                    ->options(['paper' => 'Paper', 'ebook' => 'Ebook'])
                    ->default('paper')
                    ->required(),
                TextInput::make('excerpt')
                    ->default(null),
                Toggle::make('is_book_of_month')
                    ->required(),
                Toggle::make('is_recommended')
                    ->required(),
            ]);
    }
}
