<?php

namespace App\Filament\Root\Resources\SpaceResource\Pages;

use App\Filament\Root\Resources\SpaceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSpace extends CreateRecord
{
    protected static string $resource = SpaceResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['saas_account_id'] = auth()->id();

        return $data;
    }
}
