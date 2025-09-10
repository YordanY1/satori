<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Forms\Components\{TextInput, Select};
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    public static function getNavigationLabel(): string
    {
        return 'Потребители';
    }

    public static function getNavigationGroup(): \UnitEnum|string|null
    {
        return 'Система';
    }

    public static function getNavigationIcon(): \BackedEnum|string|null
    {
        return 'heroicon-o-user-group';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->label('Име')
                ->required()
                ->maxLength(255),

            TextInput::make('email')
                ->label('Email')
                ->email()
                ->required()
                ->unique(ignoreRecord: true),

            TextInput::make('password')
                ->label('Парола')
                ->password()
                ->revealable()
                ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                ->dehydrated(fn ($state) => filled($state))
                ->required(fn ($record) => $record === null),

            Select::make('roles')
                ->label('Роли')
                ->relationship('roles', 'name')
                ->multiple()
                ->preload()
                ->searchable(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID')->sortable(),
                Tables\Columns\TextColumn::make('name')->label('Име')->searchable(),
                Tables\Columns\TextColumn::make('email')->label('Email')->searchable(),
                Tables\Columns\BadgeColumn::make('roles.name')->label('Роли'),
                Tables\Columns\TextColumn::make('created_at')->label('Създаден')
                    ->dateTime('d.m.Y H:i')->sortable(),
            ])
            ->filters([
                Filter::make('has_role_admin')
                    ->label('Само админи')
                    ->query(fn ($q) => $q->whereHas('roles', fn ($r) => $r->where('name', 'admin'))),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Редакция'),
                Tables\Actions\DeleteAction::make()->label('Изтриване'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()->label('Изтриване избраните'),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit'   => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
