<?php

namespace App\Filament\Root\Resources\AssetTagResource\Pages;

use App\Filament\Root\Resources\AssetTagResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAssetTag extends CreateRecord
{
    protected static string $resource = AssetTagResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['saas_account_id'] = auth()->id();

        return $data;
    }
}
