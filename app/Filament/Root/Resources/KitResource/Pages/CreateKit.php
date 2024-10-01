<?php

namespace App\Filament\Root\Resources\KitResource\Pages;

use App\Filament\Root\Resources\KitResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKit extends CreateRecord
{
    protected static string $resource = KitResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['saas_account_id'] = auth()->id();

        return $data;
    }
}
