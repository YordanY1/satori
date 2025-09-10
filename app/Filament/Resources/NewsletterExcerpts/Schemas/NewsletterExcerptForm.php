<?php

namespace App\Filament\Resources\NewsletterExcerpts\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;


class NewsletterExcerptForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                FileUpload::make('file_path')
                    ->label('PDF файл')
                    ->directory('newsletter/excerpts')
                    ->disk('public')
                    ->visibility('public')
                    ->acceptedFileTypes(['application/pdf'])
                    ->required()
                    ->downloadable()
                    ->previewable(false),
                Toggle::make('is_sent')
                    ->required(),
            ]);
    }
}
