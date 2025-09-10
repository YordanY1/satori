<?php

namespace App\Filament\Resources\Events\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class EventForm
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

                DateTimePicker::make('date')
                    ->label('Дата и час')
                    ->required()
                    ->seconds(false)
                    ->native(false),

                TextInput::make('location')
                    ->label('Място')
                    ->nullable(),

                Textarea::make('program')
                    ->label('Програма')
                    ->columnSpanFull()
                    ->nullable(),

                Toggle::make('is_paid')
                    ->label('Платено събитие')
                    ->default(false),

                TextInput::make('payment_link')
                    ->label('Линк за плащане')
                    ->nullable(),

                TextInput::make('registration_link')
                    ->label('Линк за регистрация')
                    ->nullable(),

                TextInput::make('video_url')
                    ->label('Видео линк')
                    ->nullable(),

                FileUpload::make('cover')
                    ->label('Корица')
                    ->image()
                    ->directory('events')
                    ->disk('public')
                    ->visibility('public')
                    ->imagePreviewHeight('200')
                    ->downloadable()
                    ->nullable(),
            ]);
    }
}
