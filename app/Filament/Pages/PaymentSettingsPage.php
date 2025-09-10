<?php

namespace App\Filament\Pages;

use App\Settings\PaymentSettings;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\{TextInput, Select};

class PaymentSettingsPage extends SettingsPage
{
    protected static string $settings = PaymentSettings::class;

    public static function getNavigationIcon(): \BackedEnum|string|null { return 'heroicon-o-credit-card'; }
    public static function getNavigationLabel(): string { return 'Плащания'; }
    public static function getNavigationGroup(): \UnitEnum|string|null { return 'Настройки'; }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Stripe')->schema([
                TextInput::make('stripe_public_key')->label('Public key'),
                TextInput::make('stripe_secret_key')->label('Secret key'),
                TextInput::make('stripe_webhook_secret')->label('Webhook secret'),
                Select::make('currency')->label('Валута')->options([
                    'BGN' => 'BGN',
                    'EUR' => 'EUR',
                    'USD' => 'USD',
                ])->required(),
            ])->columns(2),
        ]);
    }
}
