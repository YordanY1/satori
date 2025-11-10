<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use App\Models\Book;
use App\Models\Event;
use App\Models\Post;
use App\Models\SiteSetting;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class SiteSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('featured_book_id')
                ->label('Избрана книга за Hero секцията')
                ->options(Book::pluck('title', 'id'))
                ->default(fn() => SiteSetting::get('featured_book_id'))
                ->searchable()
                ->afterStateUpdated(fn($state) => SiteSetting::set('featured_book_id', $state)),

            Select::make('featured_event_id')
                ->label('Избрано събитие')
                ->options(Event::pluck('title', 'id'))
                ->default(fn() => SiteSetting::get('featured_event_id'))
                ->searchable()
                ->afterStateUpdated(fn($state) => SiteSetting::set('featured_event_id', $state)),

            Select::make('featured_post_id')
                ->label('Избран пост')
                ->options(Post::pluck('title', 'id'))
                ->default(fn() => SiteSetting::get('featured_post_id'))
                ->searchable()
                ->afterStateUpdated(fn($state) => SiteSetting::set('featured_post_id', $state)),
        ]);
    }
}
