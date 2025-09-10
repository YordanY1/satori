<?php

namespace App\Filament\Pages;

use App\Settings\SeoSettings;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\{TextInput, Textarea, FileUpload};

class SeoSettingsPage extends SettingsPage
{
    protected static string $settings = SeoSettings::class;

    public static function getNavigationIcon(): \BackedEnum|string|null { return 'heroicon-o-magnifying-glass'; }
    public static function getNavigationLabel(): string { return 'SEO'; }
    public static function getNavigationGroup(): \UnitEnum|string|null { return 'Настройки'; }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Мета')->schema([
                TextInput::make('meta_title')->label('Meta Title')->maxLength(60),
                Textarea::make('meta_description')->label('Meta Description')->rows(3)->maxLength(160),
                FileUpload::make('og_image')->label('OG image')->image()->directory('seo'),
            ]),
        ]);
    }
}
