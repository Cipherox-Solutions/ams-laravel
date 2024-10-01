<?php

namespace App\Filament\Root\Resources\VendorCategoryResource\Pages;

use App\Filament\Root\Resources\VendorCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateVendorCategory extends CreateRecord
{
    protected static string $resource = VendorCategoryResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['saas_account_id'] = auth()->id();

        return $data;
    }
}
