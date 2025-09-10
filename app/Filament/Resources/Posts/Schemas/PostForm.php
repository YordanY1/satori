<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Заглавие')
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

                Textarea::make('excerpt')
                    ->label('Кратко описание')
                    ->rows(3)
                    ->nullable()
                    ->columnSpanFull(),

                RichEditor::make('content')
                    ->label('Съдържание')
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'strike',
                        'link',
                        'bulletList',
                        'orderedList',
                        'blockquote',
                        'codeBlock',
                        'h2',
                        'h3',
                        'redo',
                        'undo',
                    ])
                    ->required()
                    ->columnSpanFull(),

                FileUpload::make('cover')
                    ->label('Корица')
                    ->image()
                    ->directory('posts')
                    ->disk('public')
                    ->visibility('public')
                    ->imagePreviewHeight('200')
                    ->downloadable()
                    ->nullable(),

                TextInput::make('author')
                    ->label('Автор')
                    ->required()
                    ->maxLength(255),
            ]);
    }
}
