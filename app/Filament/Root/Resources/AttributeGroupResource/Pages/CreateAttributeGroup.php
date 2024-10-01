<?php

namespace App\Filament\Root\Resources\AttributeGroupResource\Pages;

use App\Filament\Root\Resources\AttributeGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAttributeGroup extends CreateRecord
{
    protected static string $resource = AttributeGroupResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['saas_account_id'] = auth()->id();

        return $data;
    }
}
