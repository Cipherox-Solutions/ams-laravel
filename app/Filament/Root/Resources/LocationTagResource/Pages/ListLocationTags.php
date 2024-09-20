<?php

namespace App\Filament\Root\Resources\LocationTagResource\Pages;

use App\Filament\Root\Resources\LocationTagResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLocationTags extends ListRecords
{
    protected static string $resource = LocationTagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
