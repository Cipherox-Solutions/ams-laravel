<?php

namespace App\Filament\Root\Resources\AttributeResource\Pages;

use App\Filament\Root\Resources\AttributeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAttribute extends CreateRecord
{
    protected static string $resource = AttributeResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['saas_account_id'] = auth()->id();

        return $data;
    }
}
