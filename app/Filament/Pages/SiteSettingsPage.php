<?php

namespace App\Filament\Pages;

use App\Settings\SiteSettings;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Schema;
use Filament\Forms\Components\{Section, TextInput, FileUpload};

class SiteSettingsPage extends SettingsPage
{
    protected static string $settings = SiteSettings::class;

    public static function getNavigationIcon(): \BackedEnum|string|null
    {
        return 'heroicon-o-cog-6-tooth';
    }

    public static function getNavigationLabel(): string
    {
        return 'Сайт';
    }

    public static function getNavigationGroup(): \UnitEnum|string|null
    {
        return 'Настройки';
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Бранд')->schema([
                TextInput::make('site_name')->label('Име на сайта')->required(),
                FileUpload::make('logo_path')->image()->directory('branding')->label('Лого'),
            ])->columns(2),

            Section::make('Контакти')->schema([
                TextInput::make('contact_email')->email()->label('Имейл'),
                TextInput::make('contact_phone')->label('Телефон'),
                TextInput::make('address')->label('Адрес'),
            ])->columns(3),

            Section::make('Социални мрежи')->schema([
                TextInput::make('facebook')->url(),
                TextInput::make('instagram')->url(),
            ])->columns(2),
        ]);
    }
}
