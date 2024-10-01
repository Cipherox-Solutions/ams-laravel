<?php

namespace App\Filament\Root\Resources\LocationTagResource\Pages;

use App\Filament\Root\Resources\LocationTagResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLocationTag extends CreateRecord
{
    protected static string $resource = LocationTagResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['saas_account_id'] = auth()->id();

        return $data;
    }
}
