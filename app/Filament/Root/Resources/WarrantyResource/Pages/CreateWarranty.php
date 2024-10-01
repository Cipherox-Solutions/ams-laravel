<?php

namespace App\Filament\Root\Resources\WarrantyResource\Pages;

use App\Filament\Root\Resources\WarrantyResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateWarranty extends CreateRecord
{
    protected static string $resource = WarrantyResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['saas_account_id'] = auth()->id();

        return $data;
    }
}
