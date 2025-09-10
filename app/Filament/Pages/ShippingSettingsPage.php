<?php

namespace App\Filament\Pages;

use App\Settings\ShippingSettings;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\{TextInput, Select};

class ShippingSettingsPage extends SettingsPage
{
    protected static string $settings = ShippingSettings::class;

    public static function getNavigationIcon(): \BackedEnum|string|null { return 'heroicon-o-truck'; }
    public static function getNavigationLabel(): string { return 'Доставка'; }
    public static function getNavigationGroup(): \UnitEnum|string|null { return 'Настройки'; }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Изпращач')->schema([
                TextInput::make('sender_name')->label('Име')->required(),
                TextInput::make('sender_phone')->label('Телефон')->required(),
                TextInput::make('sender_city')->label('Град')->required(),
                TextInput::make('sender_post')->label('Пощ. код')->required(),
                TextInput::make('sender_street')->label('Улица')->required(),
                TextInput::make('sender_num')->label('№')->required(),
            ])->columns(3),

            Section::make('Econt API')->schema([
                Select::make('econt_env')->label('Среда')->options([
                    'test' => 'test',
                    'production' => 'production',
                ])->required(),
                TextInput::make('econt_user')->label('Потребител')->required(),
                TextInput::make('econt_pass')->label('Парола')->password()->revealable()->required(),
            ])->columns(3),
        ]);
    }
}
