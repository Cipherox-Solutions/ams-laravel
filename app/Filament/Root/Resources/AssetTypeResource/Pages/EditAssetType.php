<?php

namespace App\Filament\Root\Resources\AssetTypeResource\Pages;

use App\Filament\Root\Resources\AssetTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAssetType extends EditRecord
{
    protected static string $resource = AssetTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
