<?php

namespace App\Filament\Root\Resources\VendorTagResource\Pages;

use App\Filament\Root\Resources\VendorTagResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateVendorTag extends CreateRecord
{
    protected static string $resource = VendorTagResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['saas_account_id'] = auth()->id();

        return $data;
    }
}
