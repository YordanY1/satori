<?php

namespace App\Filament\Resources\NewsletterExcerpts\Pages;

use App\Filament\Resources\NewsletterExcerpts\NewsletterExcerptResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListNewsletterExcerpts extends ListRecords
{
    protected static string $resource = NewsletterExcerptResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
