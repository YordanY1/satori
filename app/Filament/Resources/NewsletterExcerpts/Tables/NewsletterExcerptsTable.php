<?php

namespace App\Filament\Resources\NewsletterExcerpts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Artisan;

class NewsletterExcerptsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Заглавие')->searchable(),
                TextColumn::make('file_path')->label('Файл')->searchable(),
                IconColumn::make('is_sent')->label('Изпратен')->boolean(),
                TextColumn::make('created_at')->label('Качен на')->dateTime()->sortable(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('send')
                    ->label('Изпрати')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        Artisan::call('newsletter:send', [
                            'excerptId' => $record->id,
                        ]);

                        Notification::make()
                            ->title('Имейлите бяха изпратени успешно!')
                            ->success()
                            ->send();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
