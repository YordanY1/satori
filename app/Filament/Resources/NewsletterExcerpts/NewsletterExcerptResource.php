<?php

namespace App\Filament\Resources\NewsletterExcerpts;

use App\Filament\Resources\NewsletterExcerpts\Pages\CreateNewsletterExcerpt;
use App\Filament\Resources\NewsletterExcerpts\Pages\EditNewsletterExcerpt;
use App\Filament\Resources\NewsletterExcerpts\Pages\ListNewsletterExcerpts;
use App\Filament\Resources\NewsletterExcerpts\Pages\ViewNewsletterExcerpt;
use App\Filament\Resources\NewsletterExcerpts\Schemas\NewsletterExcerptForm;
use App\Filament\Resources\NewsletterExcerpts\Schemas\NewsletterExcerptInfolist;
use App\Filament\Resources\NewsletterExcerpts\Tables\NewsletterExcerptsTable;
use App\Models\NewsletterExcerpt;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class NewsletterExcerptResource extends Resource
{
    protected static ?string $model = NewsletterExcerpt::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';
    protected static ?string $modelLabel = 'Новинарски откъс';
    protected static ?string $pluralModelLabel = 'Новинарски откъси';
    protected static ?string $navigationLabel = 'Новинарски откъси';

    public static function form(Schema $schema): Schema
    {
        return NewsletterExcerptForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return NewsletterExcerptInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NewsletterExcerptsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListNewsletterExcerpts::route('/'),
            'create' => CreateNewsletterExcerpt::route('/create'),
            'view'   => ViewNewsletterExcerpt::route('/{record}'),
            'edit'   => EditNewsletterExcerpt::route('/{record}/edit'),
        ];
    }
}
