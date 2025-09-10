<?php

namespace App\Filament\Resources\NewsletterExcerpts\Pages;

use App\Filament\Resources\NewsletterExcerpts\NewsletterExcerptResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditNewsletterExcerpt extends EditRecord
{
    protected static string $resource = NewsletterExcerptResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
