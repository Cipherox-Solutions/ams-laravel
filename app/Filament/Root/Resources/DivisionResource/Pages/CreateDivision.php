<?php

namespace App\Filament\Root\Resources\DivisionResource\Pages;

use App\Filament\Root\Resources\DivisionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDivision extends CreateRecord
{
    protected static string $resource = DivisionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['saas_account_id'] = auth()->id();

        return $data;
    }
}
