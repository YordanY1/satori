<?php

namespace App\Filament\Resources\Events\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                DateTimePicker::make('date')
                    ->required(),
                TextInput::make('location')
                    ->default(null),
                Textarea::make('program')
                    ->default(null)
                    ->columnSpanFull(),
                Toggle::make('is_paid')
                    ->required(),
                TextInput::make('payment_link')
                    ->default(null),
                TextInput::make('registration_link')
                    ->default(null),
                TextInput::make('video_url')
                    ->default(null),
                TextInput::make('cover')
                    ->default(null),
            ]);
    }
}
