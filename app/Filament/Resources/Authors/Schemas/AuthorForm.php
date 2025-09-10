<?php

namespace App\Filament\Resources\Authors\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class AuthorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Име')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('slug', Str::slug($state));
                    }),

                TextInput::make('slug')
                    ->label('Slug')
                    ->disabled()
                    ->dehydrated(true)
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                Textarea::make('bio')
                    ->label('Биография')
                    ->nullable()
                    ->columnSpanFull(),

                FileUpload::make('photo')
                    ->label('Снимка')
                    ->image()
                    ->directory('authors')
                    ->disk('public')
                    ->visibility('public')
                    ->maxSize(2048)
                    ->imagePreviewHeight('150')
                    ->downloadable()
                    ->nullable(),

                Repeater::make('authorLinks')
                    ->label('Външни линкове')
                    ->relationship('links')
                    ->schema([
                        TextInput::make('title')
                            ->label('Заглавие')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('url')
                            ->label('URL')
                            ->url()
                            ->required()
                            ->maxLength(255),

                        Toggle::make('is_published')
                            ->label('Публикуван')
                            ->default(true),

                        TextInput::make('position')
                            ->label('Позиция')
                            ->numeric()
                            ->default(0),
                    ])
                    ->collapsible()
                    ->orderable('position')
                    ->defaultItems(0)
                    ->columnSpanFull(),

                Repeater::make('authorQuotes')
                    ->label('Цитати')
                    ->relationship('quotes')
                    ->schema([
                        Textarea::make('quote')
                            ->label('Цитат')
                            ->required()
                            ->rows(2),

                        Toggle::make('is_published')
                            ->label('Публикуван')
                            ->default(true),

                        TextInput::make('position')
                            ->label('Позиция')
                            ->numeric()
                            ->default(0),
                    ])
                    ->collapsible()
                    ->orderable('position')
                    ->defaultItems(0)
                    ->columnSpanFull(),
            ]);
    }
}
