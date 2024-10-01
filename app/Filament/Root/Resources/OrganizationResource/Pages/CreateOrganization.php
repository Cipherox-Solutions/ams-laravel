<?php

namespace App\Filament\Root\Resources\OrganizationResource\Pages;

use App\Filament\Root\Resources\OrganizationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOrganization extends CreateRecord
{
    protected static string $resource = OrganizationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['saas_account_id'] = auth()->id();

        return $data;
    }
}
