<?php

namespace App\Filament\Resources\Media\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class MediaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')
                ->label('Заглавие')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state))),

            TextInput::make('slug')
                ->label('Slug')
                ->disabled()
                ->dehydrated(true)
                ->required()
                ->unique(ignoreRecord: true),

            Select::make('type')
                ->label('Тип')
                ->options([
                    'youtube' => 'YouTube видео',
                    'audio'   => 'Аудио',
                    'image'   => 'Изображение',
                    'link'    => 'Външен линк',
                ])
                ->required()
                ->live(),

            TextInput::make('youtube_id')
                ->label('YouTube ID')
                ->nullable()
                ->visible(fn($get) => $get('type') === 'youtube'),

            TextInput::make('audio_src')
                ->label('Аудио файл (URL)')
                ->nullable()
                ->visible(fn($get) => $get('type') === 'audio'),

            FileUpload::make('thumbnail')
                ->label('Миниатюра')
                ->image()
                ->directory('media/thumbnails')
                ->disk('public')
                ->visibility('public')
                ->imagePreviewHeight('150')
                ->downloadable()
                ->nullable(),

            TextInput::make('external_url')
                ->label('Външен линк')
                ->url()
                ->nullable()
                ->visible(fn($get) => $get('type') === 'link'),

            Toggle::make('is_published')
                ->label('Публикуван')
                ->default(true),

            TextInput::make('position')
                ->label('Позиция')
                ->numeric()
                ->default(0),

            DateTimePicker::make('published_at')
                ->label('Дата на публикуване')
                ->seconds(false)
                ->nullable(),
        ]);
    }
}
