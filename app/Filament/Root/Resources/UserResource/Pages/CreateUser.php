<?php

namespace App\Filament\Root\Resources\UserResource\Pages;

use App\Filament\Root\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['saas_account_id'] = auth()->id();

        return $data;
    }
}
