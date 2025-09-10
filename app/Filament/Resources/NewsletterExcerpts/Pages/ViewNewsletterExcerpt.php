<?php

namespace App\Filament\Resources\NewsletterExcerpts\Pages;

use App\Filament\Resources\NewsletterExcerpts\NewsletterExcerptResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewNewsletterExcerpt extends ViewRecord
{
    protected static string $resource = NewsletterExcerptResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
