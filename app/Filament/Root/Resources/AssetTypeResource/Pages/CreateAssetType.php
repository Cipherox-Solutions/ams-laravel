<?php

namespace App\Filament\Root\Resources\AssetTypeResource\Pages;

use App\Filament\Root\Resources\AssetTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAssetType extends CreateRecord
{
    protected static string $resource = AssetTypeResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['saas_account_id'] = auth()->id();

        return $data;
    }
}
