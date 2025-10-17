<?php

namespace App\Filament\Resources\NewsletterExcerpts\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class NewsletterExcerptInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title')
                    ->label('Заглавие'),

                TextEntry::make('file_path')
                    ->label('Файл'),

                IconEntry::make('is_sent')
                    ->label('Изпратен')
                    ->boolean(),

                TextEntry::make('created_at')
                    ->label('Създаден на')
                    ->dateTime(),

                TextEntry::make('updated_at')
                    ->label('Обновен на')
                    ->dateTime(),
            ]);
    }
}
