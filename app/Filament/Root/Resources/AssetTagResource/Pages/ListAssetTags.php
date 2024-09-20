<?php

namespace App\Filament\Root\Resources\AssetTagResource\Pages;

use App\Filament\Root\Resources\AssetTagResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAssetTags extends ListRecords
{
    protected static string $resource = AssetTagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
